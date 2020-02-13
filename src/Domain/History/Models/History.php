<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class History extends Model
{
    protected $table = "edit_history";
    //

    protected $fillable = [
        'class_id',
        'class',
        'model_attributes',
        'other_attributes'

    ];

    /**
     * Take a model and create a History entry.
     *
     * @param Model $mod 'The model that we are creating a History for'
     * @param array|null $other 'Any other data that we want to store'
     * @return \Illuminate\Database\Eloquent\Builder|Model 'Return the newly created History Object'
     */

    /** @var Model $mod */
    public static function create($mod, array $other = null)
    {
        $class = get_class($mod);
        $return = static::query()->create([
            'class' => $class,
            'class_id' => $mod->id,
            'model_attributes' => json_encode($mod->getAttributes()),
            'other_attributes' => $other ? json_encode($other) : null
        ]);


        return $return;
    }




    public static function restore($id)
    {
        $hist = (new History)->newQuery()->find($id);
        if ($hist) {
            $class = $hist->class;
            $model = $class::find($hist->class_id);
            $model->setRawAttributes(json_decode($hist->model_attributes, true));
            $model->save();
            return $hist;
        }

        return false;
    }
}
