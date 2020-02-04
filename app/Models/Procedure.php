<?php

namespace App\Models;

use App\Traits\HasCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Procedure extends Model
{
    protected $table = 'procedures';
    protected $guarded = ['id'];
    protected $hidden = ['scheduled_at', 'archived_at', 'canceled_at', 'created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['scheduled_at', 'archived_at', 'canceled_at', 'created_at', 'updated_at', 'deleted_at'];
    protected $casts = [];
    public $timestamps = true;

	use SoftDeletes, HasCreator;

    /***************************************************************************************
     ** SCOPES
     ***************************************************************************************/

    public function scopeScheduledToday($query)
    {
        $timezone = getRequestTimezone();

        $dayStart = Carbon::now($timezone)->startOfDay();
        $dayEnd = Carbon::now($timezone)->endOfDay();
        
        return $query->whereBetween('scheduled_at', [$dayStart, $dayEnd]);
    }

    public function scopeFutureDates($query)
    {
        $timezone = getRequestTimezone();

        return $query->where('scheduled_at', '>', Carbon::now($timezone)->endOfDay());
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

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

	public function patient()
	{
		return $this->belongsTo(Patient::class, 'patient_id');
	}

	public function provider()
	{
		return $this->belongsTo(Provider::class, 'provider_id');
	}

	public function template()
	{
		return $this->belongsTo(Template::class, 'template_id');
	}

    /***************************************************************************************
     ** HELPERS
     ***************************************************************************************/

    public function getLaterality()
    {
        switch ($this->laterality) {
            case 0:
                return 'L';
                break;
            case 1:
                return 'R';
                break;
            case 2:
                return 'N';
                break;
        }
    }
}