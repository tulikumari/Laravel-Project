<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class Bookmark extends Model

{

    /**

     * The table associated with the model.

     *

     * @var string

     */

    public $timestamps = false;

    protected $table   = 'bookmark';

    protected $dates   = ['created_at', 'updated_at'];

}

