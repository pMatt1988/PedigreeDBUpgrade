<?php

namespace App\Http\Controllers;

use App\Dog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DogController extends Controller
{
    //mytodo: Advanced Search
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dogs = Dog::orderBy('name')->paginate(25);
        return view('dog.index', compact('dogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = $request->validate($this->validationRules());
        $validated['user_id'] = Auth::id();

        $dog = Dog::create($validated);

        //Refresh dog model to make sure our info is up to date!
        $dog->refresh();

        /*
         * Set up relationships
         */
        $this->setUpDogRelationships($dog, ['sire', 'dam']);

        /*
         * Handle image uploads
         */
        if (request()->hasFile('image')) {
            $imagePath = $this->handleImage(request()->file('image'));
            $fileName = basename($imagePath);
            $this->makeThumbnail(request()->file('image'), $fileName);

        }

        return redirect('dogs');
    }


    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
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
     * @param  $id
     * @return \Illuminate\Http\Response
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
     * @param \Illuminate\Http\Request $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $dog = Dog::findOrFail($id);
        $validated = request()->validate($this->validationRules());

        $dog->update($validated);

        //Refresh dog model to get updated changes.
        $dog->refresh();

        /*
         * Set up relationships
         */
        $this->setUpDogRelationships($dog, ['sire', 'dam']);


        if (request()->hasFile('image')) {
            $imagePath = $this->handleImage(request()->file('image'));
            $fileName = basename($imagePath);
            $this->makeThumbnail(request()->file('image'), $fileName);

            $this->deleteImage($dog->image_url);
            $dog->image_url = $fileName;
            $dog->save();
        }


        return redirect('dogs/' . $id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Dog::destroy($id);

        return redirect('/dogs/');
    }


    private function setUpDogRelationships($dog, $relations)
    {
        foreach ($relations as $relation) {
            $value = request($relation);
            if ($value === null) continue;

            $parent = Dog::where('name', '=', $value)->first();

            if ($parent == null) {
                $parent = Dog::create([
                    'name' => $value,
                    'sex' => $relation == 'sire' ? 'male' : 'female'
                ]);
            }

            DB::table('dog_relationship')->updateOrInsert(
                [
                    'dog_id' => $dog->id,
                    'relation' => $relation
                ],
                [
                    'parent_id' => $parent->id
                ]);

//            } else {
//
////                if ($relation === 'sire') {
////                    $error = \Illuminate\Validation\ValidationException::withMessages([
////                        'sire' => ['Sire must already exist in the Database'],
////                    ]);
////
////                    throw $error;
////                }
////                if($relation === 'dam') {
////                    $error = \Illuminate\Validation\ValidationException::withMessages([
////                        'dam' => ['Dam must already exist in the Database.'],
////                    ]);
////
////                    throw $error;
////                }
//            }
        }
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

    private function validationRules()
    {
        return [
            'name' => ['required'],
            'sex' => ['required', 'in:male,female'],
            'dob' => ['nullable', 'date_format:Y-m-d'],
            'pretitle' => ['nullable', 'max:32'],
            'posttitle' => ['nullable', 'max:32'],
            'reg' => ['nullable', 'max:64'],
            'color' => ['nullable', 'max:64'],
            'markings' => ['nullable', 'max:64'],

            'image' => ['nullable', 'image',
                Rule::dimensions()
                    ->maxWidth(config('dog.image-max-width'))
                    ->maxHeight(config('dog.image-max-height'))],

            'breeder' => ['nullable', 'max:32'],
            'owner' => ['nullable', 'max:32'],
            'website' => ['nullable', 'url'],
        ];
    }
}
