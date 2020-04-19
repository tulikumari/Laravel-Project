<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Casediscussion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table   = 'case_discussion';
    protected $dates   = ['created_at', 'updated_at'];
}
