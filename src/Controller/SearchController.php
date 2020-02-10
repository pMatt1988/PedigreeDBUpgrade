<?php

namespace App\Http\Controllers;

use App\Dog;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //

    public function result($query) {
        $result = Dog::where('name', "LIKE", "%{$query}%")->get()->toJson();
        return $result;
    }

    public function resultsex($query, $sex) {
        $result = Dog::where([['name', "LIKE", "%{$query}%"], ["sex", "=", $sex]])->get()->toJson();
        return $result;
    }
}
