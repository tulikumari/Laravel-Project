<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskManagement extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table   = 'task_management';
    protected $dates   = ['created_at', 'updated_at'];
}
