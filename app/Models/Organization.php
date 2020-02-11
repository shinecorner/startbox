<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    protected $table = 'organizations';
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [];
    public $timestamps = true;

    use SoftDeletes;

    protected $fillable = [
        'title', 'description'
    ];
    
    public $searchable = [
        'title', 'description'
    ];

    public function toSearchableArray()
    {
        return array_flip($this->searchable);
    }

    public function getSearchableArray()
    {
        return $this->searchable;
    }

    /***************************************************************************************
     ** RELATIONS
     ***************************************************************************************/

     public function users()
     {
         return $this->hasMany(User::class);
     }

}