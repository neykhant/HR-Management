<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    // protected $casts = [
    //     'images' => 'array',
    //     'files' => 'array'
    // ];

    public function leaders () {
        return $this->belongsToMany(User::class, 'project_leaders', 'project_id', 'user_id');
    }

    public function members(){
        return $this->belongsToMany(User::class, 'project_members', 'project_id', 'user_id');
    }

    public function tasks(){
        return $this->hasMany(Task::class, 'project_id', 'id');
    }

    // public function image_path(){
    //     if(is_array($this->images)){

    //         foreach($this->images as $this->image){
    //         return asset('storage/project/' . $this->image);
    //         }
    //         return null;
    //     }
        
    // }
}
