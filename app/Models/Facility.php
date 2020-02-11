<?php

namespace App\Models;

use App\Traits\HasCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facility extends Model
{
    protected $table = 'facilities';
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [];

    protected $fillable = [
        'title', 'description', 'organization_id'
    ];

    public $timestamps = true;

	use SoftDeletes, HasCreator;

    /***************************************************************************************
     ** RELATIONS
     ***************************************************************************************/

	public function organization()
	{
		return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function providers()
    {
        return $this->belongsToMany(Provider::class)->using(FacilityProvider::class);
    }
}