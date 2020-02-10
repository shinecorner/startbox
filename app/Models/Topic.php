<?php

namespace App\Models;

use App\Traits\HasCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    protected $table = 'topics';
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [];
    public $timestamps = true;

    use SoftDeletes;
    
    /***************************************************************************************
     ** RELATIONS
     ***************************************************************************************/

    public function courses(){
        return $this->belongsToMany(Course::class)->using(CourseTopic::class);
    }
    
    public function questions(){        
        return $this->hasMany(Question::class, 'topic_id');
    }
}
