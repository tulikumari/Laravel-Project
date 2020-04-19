<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relatedcase extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table   = 'related_cases';
    protected $dates   = ['created_at', 'updated_at'];
}
