<?php

namespace App\Models;

use App\Models\Traits\Authorization;
use App\Models\Traits\Validation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class Task extends Model
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

    protected $dates = ['dueDate', 'createdAt', 'updatedAt', 'deletedAt'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'name',
      'description',
      'dueDate',
      'favorite',
      'status',
      'tasklistId',
      'userId'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
      'tasklistId' => 'integer',
      'userId' => 'integer',
      'favorite' => 'boolean'
    ];

    /**
     * Configure validation rules
     */
    protected $validationRules = [
      'name' => 'required',
      'description' => 'required',
      'dueDate' => 'date',
      'favorite' => 'boolean',
      'status' => 'in:open,inprocess,closed,archived',
      'tasklistId' => 'integer',
      'userId' => 'integer'

    ];

    public static function boot()
    {
        parent::boot();

        Task::saving(function($task)
        {
            if (!isset($task->userId)) {
                if (Auth::user() !== NULL) { $task->userId = Auth::id(); }
            }
        });
    }

    public function tasklist()
    {
        return $this->hasOne(Tasklist::class, 'id', 'tasklistId');
    }

    public function responsible()
    {
        return $this->hasOne(User::class, 'id', 'userId');
    }
}
