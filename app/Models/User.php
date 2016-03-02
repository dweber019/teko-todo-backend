<?php namespace App\Models;

use App\Models\Traits\Authorization;
use App\Models\Traits\Validation;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{

    /**
     * Trait imports
     */
    use Validation, Authorization, HasRoles;

    /**
     * Set sneakCase for this modal
     *
     * @var bool
     */
    public static $snakeAttributes = false;

    /**
     * Timestamp handling
     */
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
    const DELETED_AT = 'deletedAt';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'firstName',
      'lastName',
      'birthday',
      'email',
      'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
      'password',
      'remember_token',
    ];

    protected $dates = ['birthday', 'createdAt', 'updatedAt', 'deletedAt'];

    /**
     * Configure validation rules
     */
    protected $validationRules = [
      'firstName' => 'required',
      'lastName' => 'required',
      'birthday' => 'date',
      'email' => ['required', 'email'],
      'password' => 'min:6'
    ];

    public static function boot()
    {
        parent::boot();

        User::saved(function($user)
        {
            $user->assignRole('user');
        });
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function setBirthdayAttribute($date)
    {
        $this->attributes['birthday'] = Carbon::parse($date);
    }

    public function tasklists()
    {
        return $this->belongsToMany(Tasklist::class, 'tasklist_user', 'userId', 'tasklistId');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
