<?php

namespace App\Models;

use App\Traits\HasCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PossibleAnswer extends Model
{
    protected $table = 'possible_answers';
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [];
    public $timestamps = true;

    use SoftDeletes;
    
    /***************************************************************************************
     ** RELATIONS
     ***************************************************************************************/

     public function question(){
        return $this->belongsTo(Question::class, 'question_id');
     }
}
