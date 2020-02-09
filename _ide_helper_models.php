<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
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
 * @property-read \App\Models\Auth\User $user
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
 * @property string|null $callname
 * @property string|null $image_url
 * @property string|null $thumbnail_url
 * @property string|null $website
 * @property string|null $breeder
 * @property string|null $owner
 * @property-read int|null $dam_count
 * @property-read mixed $first_dam
 * @property-read mixed $first_sire
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Dog[] $parents
 * @property-read int|null $parents_count
 * @property-read int|null $sire_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog whereBreeder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog whereCallname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog whereOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog whereThumbnailUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dog whereWebsite($value)
 */
	class Dog extends \Eloquent {}
}

namespace App{
/**
 * App\DogHistory
 *
 * @property int $id
 * @property int $dog_id
 * @property int $sire_id
 * @property int $dam_id
 * @property string $model
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DogHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DogHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DogHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DogHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DogHistory whereDamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DogHistory whereDogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DogHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DogHistory whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DogHistory whereSireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DogHistory whereUpdatedAt($value)
 */
	class DogHistory extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Dog[] $dogs
 * @property-read int|null $dogs_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

