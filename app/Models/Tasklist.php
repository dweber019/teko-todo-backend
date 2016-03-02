<?php

namespace App\Models;

use App\Models\Traits\Authorization;
use App\Models\Traits\Validation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Tasklist extends Model
{
    /**
     * Trait imports
     */
    use Validation, Authorization;

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

    protected $dates = ['createdAt', 'updatedAt', 'deletedAt'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'name',
      'color',
      'order',
    ];

    /**
     * Configure validation rules
     */
    protected $validationRules = [
      'name' => 'required',
      'color' => 'min:6',
    ];

    public static function boot()
    {
        parent::boot();

        Tasklist::saved(function($tasklist)
        {
            if (Auth::user() !== NULL) { $tasklist->users()->sync([Auth::id()]); }
        });
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'tasklistId');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'tasklist_user', 'tasklistId', 'userId');
    }
}
