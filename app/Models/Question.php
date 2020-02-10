<?php


namespace App\Models;

use App\Traits\HasCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    protected $table = 'questions';
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [];
    public $timestamps = true;

    use SoftDeletes;

    /***************************************************************************************
     ** RELATIONS
     ***************************************************************************************/

    public function topic(){
        return $this->belongsTo(Topic::class, 'topic_id');
    }

    public function possibleAnswers(){
        return $this->hasMany(PossibleAnswer::class, 'question_id');
    }
}
