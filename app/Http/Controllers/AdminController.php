<?php

namespace App\Http\Controllers;

use App\Dog;
use App\DogHistory;
use DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //

    function history($id)
    {
        $history = DogHistory::where('dog_id', $id)->orderBy('created_at', 'desc')->get();
        return view('backend.dogs.history', compact('history'));
    }

    function showhistory($id)
    {
        $history = DogHistory::find($id);

        return view('backend.dogs.showhistory', compact('history'));
    }

    function deletehistory($id)
    {
        $history = DogHistory::find($id);
        if ($history) {
            $history->delete();
            return redirect("/backend/dogs/{$history->dog_id}")->with('fail', 'Failed to delete history from Database!');
        }
        return redirect("/backend/dogs/0")->with('fail', 'Failed to delete history from Database!');
    }

    function restorehistory($id) {
        $history = DogHistory::find($id);
        $model = json_decode($history->model, true);
        $dog = Dog::find($history->dog_id);
        $dog->setRawAttributes($model);
        $dog->save();

        $history->delete();

        return redirect("backend/dogs/{$dog->id}")->with('success', 'Successfully Restored History!');

    }

    function showdog($id)
    {
        $dog = Dog::with('parents')->find($id);
        return view('backend.dogs.show', compact('dog'));
    }

    function deletedog($id) {

    }
}
