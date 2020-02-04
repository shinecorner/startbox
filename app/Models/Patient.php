<?php

namespace App\Models;

use App\Traits\HasCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class Patient extends Model
{
    protected $table = 'patients';
    protected $guarded = ['id'];
    protected $hidden = ['dob', 'created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['dob', 'created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'dob' => 'date:Y-m-d'
    ];
    public $timestamps = true;

	use SoftDeletes, HasCreator;

    /***************************************************************************************
     ** RELATIONS
     ***************************************************************************************/

    public function defaultProvider()
    {
        return $this->belongsTo(\App\Models\Provider::class, 'default_provider_id');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }

	public function organization()
	{
		return $this->belongsTo(Organization::class, 'organization_id');
	}

    public function procedures()
    {
        return $this->hasMany(Procedure::class, 'patient_id');
    }

    /***************************************************************************************
     ** 
     ***************************************************************************************/

    public static function makeOne(array $data)
    {
        $patient = new Patient;
        $patient->organization_id = Organization::first()->id; // replace
        $patient->default_provider_id = Arr::get($data, 'default_provider_id');
        $patient->first_name = Arr::get($data, 'first_name');
        $patient->last_name = Arr::get($data, 'last_name');
        $patient->dob = Arr::get($data, 'dob');
        $patient->sex = Arr::get($data, 'sex');
        $patient->save();

        return $patient;
    }

}