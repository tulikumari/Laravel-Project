<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table   = 'events';
    protected $dates   = ['created_at', 'updated_at'];
    public static function getEvent($eventId)
    {
        $events = self::find($eventId);
        return $events;
    }
}
