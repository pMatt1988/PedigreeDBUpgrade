<?php

namespace App;

use Auth;
use DB;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;


/**
 * App\Dog
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property int $sireid
 * @property int $damid
 * @property string $sex
 * @property string $dob
 * @property string $pretitle
 * @property string $posttitle
 * @property string $reg
 * @property string $color
 * @property string $markings
 * @property int $fss
 * @property int $rat
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Dog $dam
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Dog[] $offspring
 * @property-read \App\Dog $sire
 * @property-read \Illuminate\Foundation\Auth\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog whereDamid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog whereFss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog whereMarkings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog wherePosttitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog wherePretitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog whereRat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog whereReg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog whereSireid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog whereUserId($value)
 * @mixin Eloquent
 */
class Dog extends Model
{
    //
    use HasPicture;

    protected $fillable = [
        'user_id',
        'name',
        'sex',
        'dob',
        'pretitle',
        'posttitle',
        'reg',
        'color',
        'markings',
        'image_url',
        'thumbnail_url',
        'website',
        'breeder',
        'owner',
    ];

    protected $dates = [
        'dob'
    ];


    public function getDate()
    {
        return $this->dob->format('Y-m-d');
    }

    public function getDBDate()
    {

    }

    public function getBirthYear()
    {
        return $this->dob->format('Y');
    }

    public function mother()
    {
        if ($this->parents == null) return null;

        foreach ($this->parents as $parent) {
            if ($parent->sex == 'female')
                return $parent;
        }

        return null;
    }

    public function father()
    {
        if ($this->parents == null) return null;
        foreach ($this->parents as $parent) {
            if ($parent->sex == 'male')
                return $parent;
        }

        return null;
    }

    public function sire()
    {
        return $this->belongsToMany(Dog::class, 'dog_relationship', 'dog_id', 'parent_id', 'id')->wherePivot('relation', 'sire');
    }


    public function getFirstSireAttribute()
    {
        return $this->sire->first();
    }

    public function dam()
    {
        return $this->belongsToMany(Dog::class, 'dog_relationship', 'dog_id', 'parent_id', 'id')->wherePivot('relation', 'dam');
    }

    public function getFirstDamAttribute()
    {
        return $this->dam->first();
    }

    public function parents()
    {
        return $this->belongsToMany(Dog::class, 'dog_relationship', 'dog_id', 'parent_id', 'id')->withPivot('relation');
    }

    public static function store(array $attributes = [])
    {
        $model = static::query()->create($attributes);
        $model->setUpDogRelationships();
        return $model;

    }

    //region Model Specific Behaviour
    public function
    setUpDogRelationships(array $relations = ['sire', 'dam'])
    {

        foreach ($relations as $relation) {
            $value = request($relation);
            if ($value === null) continue;

            $parent = Dog::where('name', '=', $value)->first();

            if ($parent == null) {
                $parent = Dog::create([
                    'name' => $value,
                    'sex' => $relation == 'sire' ? 'male' : 'female',
                    'user_id' => Auth::id()
                ]);
            }

            DB::table('dog_relationship')->updateOrInsert(
                [
                    'dog_id' => $this->id,
                    'relation' => $relation
                ],
                [
                    'parent_id' => $parent->id,
                ]);

        }
    }
    //endregion
}
