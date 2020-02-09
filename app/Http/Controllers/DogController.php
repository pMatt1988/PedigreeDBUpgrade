<?php

namespace App\Http\Controllers;

use App\Dog;
use App\DogHistory;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Nayjest\Grids\DataRow;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use PHPUnit\Util\Filter;
use Session;

class DogController extends Controller
{
    //mytodo: Advanced Search
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {

        //$dogs = Dog::orderBy('name')->paginate(25);

        //$query = (new Dog)->newQuery()->with(['sire', 'dam']);
        $query = (new Dog)->newQuery()
            ->leftJoin('dog_relationship as sire', function (Builder $join) {
                $join->on('sire.dog_id', '=', 'dogs.id')
                    ->where('sire.relation', 'sire')->orWhereNull('sire.relation');

            })
            ->leftJoin('dog_relationship as dam', function (Builder $join) {
                $join->on('dam.dog_id', '=', 'dogs.id')
                    ->where('dam.relation', 'dam')->orWhereNull('dam.relation');

            })
            ->addSelect('name', 'dob', 'id', 'pretitle', 'posttitle', 'sire.parent_id', 'sire.parent_name as sire_name', 'dam.parent_id', 'dam.parent_name as dam_name');


        $grid = new Grid(
            (new GridConfig)
                ->setDataProvider(
                    new EloquentDataProvider($query)
                )
                ->setName('dogs')
                ->setPageSize(15)
                ->setColumns([
                    (new FieldConfig)
                        ->setName('id')
                        ->setLabel('ID')
                        ->setSortable(true)
                        ->setSorting(Grid::SORT_ASC)
                    ,
                    (new FieldConfig)
                        ->setName('name')
                        ->setLabel('Name')
                        ->setSortable(true)
                        ->addFilter(
                            (new FilterConfig)
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        )
                        ->setCallback(function ($val, DataRow $row) {
                            $src = $row->getSrc();
                            $newval = strtoupper($val);
                            if ($src->pretitle) {
                                $pretitle = strtoupper($src->pretitle);
                                $newval = "<span class='text-success'>{$pretitle}</span> " . $newval;
                            }
                            if ($src->posttitle) {
                                $posttitle = strtoupper($src->posttitle);
                                $newval = $newval . " <span class='text-success'>{$posttitle}</span>";
                            }
                            return "<a href='/dogs/{$src->id}'>" . $newval . "</a>";
                        })
                    ,

                    (new FieldConfig)
                        ->setName('sire_name')
                        ->setLabel('Sire')
                        ->setSortable(true)
                        ->setCallback(function ($val, DataRow $row) {
                            $src = $row->getSrc();
                            return "<a href='/dogs/{$src->id}'>" . strtoupper($val) . "</a>";
                        })
                        ->addFilter(
                            (new FilterConfig)
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                                ->setName('sire.parent_name')
                        )
                    ,

                    (new FieldConfig)
                        ->setName('dam_name')
                        ->setLabel('Dam')
                        ->setSortable(true)
                        ->setCallback(function ($val, DataRow $row) {
                            $src = $row->getSrc();
                            return "<a href='/dogs/{$src->id}'>" . strtoupper($val) . "</a>";
                        })
                        ->addFilter(
                            (new FilterConfig)
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                                ->setName('dam.parent_name')
                        )
                    ,

                    (new FieldConfig)
                        ->setName('dob')
                        ->setLabel('Birth Date')
                        ->setSortable(true)
                        ->setCallback(function ($val) {
                            if ($val) {
                                $date = Carbon::parse($val);

                                return $date->format('d/m/Y');
                            }
                            return $val;
                        })
                        ->addFilter(
                            (new FilterConfig)->setOperator(FilterConfig::OPERATOR_LIKE)

                        )
                    ,
                ])
//                ->setComponents([
//                    (new THead)
//                        ->setComponents([
//                            (new ColumnHeadersRow),
//                            (new FiltersRow),
//
//
//                        ])
//                    ,
//                ])
        );
        $grid = $grid->render();
        return view('dog.index', compact('grid'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        //

        $method = 'POST';
        $dog = new Dog();
        return view('dog.create', compact('method', 'dog'));
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {

        $validated = $request->validate($this->validationRules());
        $validated['user_id'] = Auth::id();

        $dog = Dog::store($validated);

        /*
         * Handle image uploads
         */
        if (request()->hasFile('image')) {
            $imagePath = $this->handleImage(request()->file('image'));
            $fileName = basename($imagePath);
            $this->makeThumbnail(request()->file('image'), $fileName);

        }

        $this->createDogHistory($dog);

        //create an edit history for this dog so that we can go back to it

        return redirect('dogs');
    }


    /**
     * Display the specified resource.
     *
     */
    public function show($id)
    {
        //
        $dog = Dog::with(['parents'])->findOrFail($id);
        return view('dog.show', compact('dog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit($id)
    {
        //
        $dog = Dog::with('parents')->find($id);
        $method = 'PATCH';


        return view('dog.edit', compact('dog', 'method'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update($id)
    {
        $dog = Dog::with(['parents'])->findOrFail($id);
        $oldDog = $dog;
        $validated = request()->validate($this->validationRules($id));
        $dog->update($validated);
        $dog->refresh();


        if (request()->hasFile('image')) {

            $imagePath = $this->handleImage(request()->file('image'));
            $fileName = basename($imagePath);
            $this->makeThumbnail(request()->file('image'), $fileName);

            $this->deleteImage($dog->image_url);
            $dog->image_url = $fileName;
            $dog->save();
        }

        if ($dog->wasChanged() || request('sire') != $dog->father()->name || request('dam') != $dog->mother()->name) {
            $this->createDogHistory($dog);
        }


        return redirect('dogs/' . $id);

    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id)
    {
        //
        Dog::destroy($id);

        return redirect('/dogs/');
    }





    private function handleImage($image)
    {

        $path = config('dog.image-directory');
        $filePath = $image->store($path, 'public');

        return $filePath;


    }

    private function makeThumbnail($image, $fileName, $width = null)
    {

        //If a width isn't defined, use the width stored in Config.
        if ($width === null)
            $width = config('dog.image-thumbnail-width');

        $path = config('dog.thumbnail-directory');

        $filePath = $image->storeAs($path, $fileName, 'public');
        $filePath = Storage::disk('public')->path($filePath);

        $thumbnail = Image::make($filePath)->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $thumbnail->save($filePath);


    }

    private function deleteImageUrl($dog, $deleteImageOnDisk = true)
    {
        //mytodo: implement deleteImageUrl
        if ($dog->image_url === null) return;

        if ($deleteImageOnDisk) {
            $this->deleteImage($dog->image_url);
        }

        $dog->image_url = null;
        $dog->save();


    }

    private function deleteImage($filename, $deleteThumbnail = true)
    {
        if ($filename != null) {
            $path = config('dog.image-directory') . '/';


            if (Storage::disk('public')->exists($path . $filename)) {
                Storage::disk('public')->delete($path . $filename);
            }
            if ($deleteThumbnail) {
                $thumbnailPath = config('dog.thumbnail-directory') . '/';
                if (Storage::disk('public')->exists($thumbnailPath . $filename)) {
                    Storage::disk('public')->delete($thumbnailPath . $filename);
                }
            }
        }

    }

    private function validationRules($id = 0)
    {
        return [
            'name' => 'required|unique:dogs,name,' . $id,
            'sex' => 'required|in:male,female',
            'dob' => 'nullable|date_format:Y-m-d',
            'pretitle' => 'nullable|max:32',
            'posttitle' => 'nullable|max:32',
            'reg' => 'nullable|max:64',
            'color' => 'nullable|max:64',
            'markings' => 'nullable|max:64',

            'image' => ['nullable', 'image',
                Rule::dimensions()
                    ->maxWidth(config('dog.image-max-width'))
                    ->maxHeight(config('dog.image-max-height'))],

            'breeder' => 'nullable|max:32',
            'owner' => 'nullable|max:32',
            'website' => ['nullable', 'url'],
        ];
    }

    private function createDogHistory($dog)
    {
        DogHistory::create([
            'dog_id' => $dog->id ?? 0,
            'sire_id' => $dog->father()->id ?? 0,
            'dam_id' => $dog->mother()->id ?? 0,
            'model' => json_encode($dog->getAttributes())
        ]);
    }
}
