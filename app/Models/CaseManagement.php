<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseManagement extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table   = 'case_management';
    protected $dates   = ['created_at', 'updated_at'];
	
	public function task(){
		return $this->hasMany('\App\Models\TaskManagement');
	}
	
	public function notes(){
		return $this->hasMany('\App\Models\Notes');
	}
	
	public function events(){
		return $this->hasMany('\App\Models\Events');
	}
	
	public function map(){
		return $this->hasMany('\App\Models\Map');
	}
	
	public function files(){
		return $this->hasMany('\App\Models\File');
	}
	
	public function contactPeople(){
		return $this->hasMany('\App\Models\ContactPeople');
	}
	
	public function discussion(){
		return $this->hasMany('\App\Models\DiscussionCase');
	}
	
	public function bookmark(){
		return $this->hasMany('\App\Models\Bookmark');
	}
	
	public function security(){
		return $this->hasMany('\App\Models\Security');
    }
    public function related_cases(){
		return $this->hasMany('\App\Models\Relatedcase');
	}
}
