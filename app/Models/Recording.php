<?php

namespace App\Models;

use App\Traits\HasCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recording extends Model
{
    protected $table = 'recordings';
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [];
    public $timestamps = true;

	use SoftDeletes, HasCreator;

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

	public function provider()
	{
		return $this->belongsTo(Provider::class, 'provider_id');
	}

	public function patient()
	{
		return $this->belongsTo(Patient::class, 'patient_id');
	}

	public function procedure()
	{
		return $this->belongsTo(Procedure::class, 'procedure_id');
	}

}