<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactPeople extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table   = 'contact_people';
    protected $dates   = ['created_at', 'updated_at'];
}
