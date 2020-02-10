<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DogHistory extends Model
{
    protected $table = "dog_history";
    //

    protected $fillable = [
        'dog_id',
        'sire_id',
        'dam_id',
        'model'

    ];
}
