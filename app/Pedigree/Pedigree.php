<?php

namespace App\Pedigree;

use App\Dog;

class Pedigree
{

    public function generatePed($id, $nGens): string
    {
        $nest = [];
        for ($i = 0; $i < $nGens; $i++) {
            $nest[] = 'parents';
        }
        $nestString = implode('.', $nest);
        $dog = Dog::with([$nestString => function ($query) {
            $query->select('id', 'name', 'image_url', 'dob');
        }])->where('id', $id)->firstOrFail();


        $nGenP2 = pow(2, $nGens);

        $color = $dog->sex === 'female' ? 'table-light text-dark' : 'table-primary text-dark';

        $pretitle = $dog->pretitle !== null ? '<span class="text-primary">' . $dog->pretitle . '</span> <br>' : null;
        $dogname = $dog->name !== null ? $dog->name . '<br>' : 'N/a';
        $posttitle = $dog->posttitle !== null ? '<span class="text-danger">' . $dog->posttitle . '</span> <br>' : null;
        $image = $dog->image_url !== null ? '<div><img src="/storage/pedigree-img/thumbnails/'
            . $dog->image_url . '" alt="Dog Thumb"></div>' : null;
        $date = $dog->dob !== null ? $dog->dob->format('Y') : null;


        //$output = null;
        $output = '<table><tr><td rowspan="' . $nGenP2 . '" class="' . $color . '">' . $pretitle . $dogname . $posttitle . $image . $date . '</td>' . $this->buildOutput($nGens, $this->GetParentsArray($dog)) . '</tr></table>';
        return $output;
    }


    public function generateTestmate($sirename, $damname, $nGen)
    {
        $relString = trim(str_repeat('parents.', $nGen), '.');
        $dam = Dog::with([$relString => function ($query) {
            $query->select('id', 'name', 'image_url', 'dob', 'posttitle', 'pretitle');
        }])->where('name', $damname);

        $parents = Dog::with([$relString => function ($query) {
            $query->select('id', 'name', 'image_url', 'dob', 'posttitle', 'pretitle');
        }])->where('name', $sirename)->union($dam)->get();

        $nGenP2 = pow(2, $nGen);

        $output = '<table> <tr> <td rowspan="' . pow(2, $nGen+1) .'" class="table-light text-dark"> Test Mate</td>';

        foreach($parents as $dog) {
            $color = $dog->sex === 'female' ? 'table-light text-dark' : 'table-primary text-dark';

            $pretitle = $dog->pretitle !== null ? '<span class="text-primary">' . $dog->pretitle . '</span> <br>' : null;
            $dogname = $dog->name !== null ? $dog->name . '<br>' : 'N/a';
            $posttitle = $dog->posttitle !== null ? '<span class="text-danger">' . $dog->posttitle . '</span> <br>' : null;
            $image = $dog->image_url !== null ? '<div><img src="/storage/pedigree-img/thumbnails/'
                . $dog->image_url . '" alt="Dog Thumb"></div>' : null;
            $date = $dog->dob !== null ? $dog->dob->format('Y') : null;


            //$output = null;
            $output .= '<td rowspan="' . $nGenP2 . '" class="' . $color . '">' .
                $pretitle . $dogname . $posttitle . $image . $date . '</td>' . $this->buildOutput($nGen, $this->GetParentsArray($dog));
        }

        return $output . '</tr></table>';
    }

    /**
     * Build text output for
     *
     * @param Int $nGen
     * @param $parents
     * @return string
     */
    protected function buildOutput(Int $nGen, $parents)
    {
        $nGen -= 1;

        $nGenP2 = pow(2, $nGen);

        $string = '';
        $this->iterations++;


        foreach ($parents as $dog) {


            if ($nGen > 0) {
                $color = ($dog->sex === 'female') ? 'table-light text-dark' :
                    (($dog->sex === 'male') ? 'table-primary text-dark' : 'table-danger text-dark');

                $pretitle = $dog->pretitle !== null ? '<span class="text-primary">' . $dog->pretitle . '</span> <br>' : null;
                $dogname = $dog->name !== null ? $dog->name . '<br>' : 'N/a';
                $posttitle = $dog->posttitle !== null ? '<span class="text-danger">' . $dog->posttitle . '</span> <br>' : null;
                $image = $dog->image_url !== null ? '<div><img src="/storage/pedigree-img/thumbnails/'
                    . $dog->image_url . '" alt="Dog Thumb"></div>' : null;
                $date = $dog->dob !== null ? $dog->dob->format('Y') : null;


                $string .= (
                    '<td rowspan="' . $nGenP2 . '" class="' . $color . '"> <a href="/dogs/' . $dog->id . '"><div>'
                    . $pretitle
                    . $dogname
                    . $posttitle
                    . $image
                    . $date
                    . '</div></a></td>');
                $string .= $this->buildOutput($nGen, $this->GetParentsArray($dog));

            }
            if ($nGen == 0) {

                $string .= '</tr><tr>';

            }
        }
        return $string;

    }


    /**
     * Build the parents array so that we can control the order
     * which they are processed. Also, if they don't exist, create
     * an empty dog.
     *
     * @param $dog
     * @return array
     */

    protected function GetParentsArray($dog)
    {
        $parents = [
            $dog->father() ?? new Dog(),
            $dog->mother() ?? new Dog()
        ];
        return $parents;
    }

    protected $iterations = 1;

    /**
     * @param $id
     * @param $nGens
     * @return string
     */


}