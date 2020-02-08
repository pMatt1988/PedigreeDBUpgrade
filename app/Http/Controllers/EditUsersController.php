<?php

namespace App\Http\Controllers;


use App\Dog;
use Html;
use Illuminate\Http\Request;
use App\User;
use Nayjest\Grids\DataRow;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use Spatie\Permission\Models\Role;

//use Nayjest\Grids\Grids;


class EditUsersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {


        $grid = new Grid(
            (new GridConfig)
                ->setDataProvider(
                    new EloquentDataProvider(User::query())
                )
                ->setName('users')
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
                        ->setCallback(function ($val) {
                            return "<span class='glyphicon glyphicon-user'></span>{$val}";
                        })
                        ->setSortable(true)
                        ->addFilter(
                            (new FilterConfig)
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        )
                    ,
                    (new FieldConfig)
                        ->setName('email')
                        ->setLabel('Email')
                        ->setSortable(true)
                        ->addFilter(
                            (new FilterConfig)
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        )
                    ,
                    (new FieldConfig)
                        ->setName('id')
                        ->setLabel('edit')
                        ->setSortable(false)
                        ->setCallback(function ($val) {
                            return "<a class='btn btn-xs btn-primary' href='users/{$val}/edit'>Edit</a>";
                        })

                ])

        );
        $grid = $grid->render();

        return view('backend.EditUsers.index', compact('grid'));
    }



//
//    /**
//     * Display the specified resource.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
//     */
//    public function show($id)
//    {
//        //
//        return view('backend.EditUsers.show');
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {

        $roles = Role::all();
        $user = User::with('dogs')->find($id);

        $query = (new Dog)->newQuery()->where('user_id', $id);

        $cfg = (new GridConfig)
            ->setDataProvider(new EloquentDataProvider($query))
            ->setColumns([
                new FieldConfig('id'),
                (new FieldConfig)
                ->setName('name')
                ->setLabel('Name')
                ->setCallback(function($val, DataRow $row) {
                    $src = $row->getSrc();
                    return "<a href='/dogs/{$src->id}'>" . $val . "</a>";
                }),
                new FieldConfig('dob')
            ]);

        $grid = new Grid($cfg);
        $grid = $grid->render();
        return view('backend.EditUsers.edit', compact('roles', 'user', 'grid'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, $id)
    {
        $inputs = $request->all();
        $roles = [];

        foreach ($inputs as $key => $input) {
            if ($key != '_token')
                $roles[] = str_replace("_", " ", $key);
        }
        $user = User::find($id);
        $user->syncRoles($roles);

        return redirect('/backend/users/' . $id . "/edit");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
