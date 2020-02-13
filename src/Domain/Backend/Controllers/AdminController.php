<?php

namespace App\Http\Controllers;

use App\Dog;
use App\History;
use DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //

    function history($id)
    {
        $history = (new History)->newQuery()->where('class', Dog::class)->where('class_id', $id)->orderBy('created_at', 'desc')->get();
        return view('backend.dogs.history', compact('history'));
    }

    function showhistory($id)
    {
        $history = History::find($id);

        return view('backend.dogs.showhistory', compact('history'));
    }

    function deletehistory($id)
    {
        $history = History::find($id);
        if ($history) {
            $history->delete();
            return redirect("/backend/dogs/{$history->dog_id}")->with('success', 'Deleted history from Database!');
        }
        return redirect("/backend/dogs/0")->with('fail', 'Failed to delete history from Database!');
    }

    function restorehistory($id) {
        $history = History::restore($id);

        return redirect("backend/dogs/{$history->class_id}")->with('success', 'Successfully Restored History!');

    }

    function showdog($id)
    {
        $dog = Dog::with('parents')->find($id);
        return view('backend.dogs.show', compact('dog'));
    }

    function deletedog($id) {

    }
}
