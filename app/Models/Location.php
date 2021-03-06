<?php

namespace App\Models;

use App\Traits\HasCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    protected $table = 'locations';
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [];
    public $timestamps = true;

    use SoftDeletes, HasCreator;
    
    protected $fillable = [
        'title', 'description', 'organization_id', 'facility_id'
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

	public function organization()
	{
		return $this->belongsTo(Organization::class, 'organization_id');
	}

	public function facility()
	{
		return $this->belongsTo(Facility::class, 'facility_id');
	}
}