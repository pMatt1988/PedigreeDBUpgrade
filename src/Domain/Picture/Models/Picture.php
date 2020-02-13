<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Picture extends Model
{
    protected $table = 'pictures';
    //

    /**
     *
     * @return array
     */
    public static function validationRules() {
        return [
            'image' => ['sometimes', 'nullable', 'image',
                Rule::dimensions()
                    ->maxWidth(config('picture.image-max-width'))
                    ->maxHeight(config('picture.image-max-height'))],
        ];
    }

    public static function create(array $attributes = [], $file = null) {

        $model = static::query()->create($attributes);
        //TODO do stuff with file
        return $model;
    }
}
