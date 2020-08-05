<?php

namespace App\Http\Controllers;

use App\Dog;
use App\Pedigree\Pedigree;
use Illuminate\Http\Request;

class PedigreeController extends Controller
{

    //mytodo: Create Advanced Search

    public function GeneratePedigree()
    {
        return null;
    }

    public function show($id, $nGens)
    {
        $pedigree = new Pedigree();
        $output = $pedigree->generatePed($id, $nGens);
        
        return view('dog.pedigree.show', compact('output', 'id'));
    }

    public function showtestmate(Request $request) {
        $sirename = $request->get('sire');
        $damname = $request->get('dam');
        $nGens = 5;

        $pedigree = new Pedigree();
        $output = $pedigree->generateTestmate($sirename, $damname, $nGens);

        //return redirect();
        return view('dog.testmate.show', compact('output'));

    }

    public function testmate() {
        return view('dog.testmate.search');
    }


}


