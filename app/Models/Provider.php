<?php

namespace App\Models;

use App\Traits\HasCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    protected $table = 'providers';
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [];
    public $timestamps = true;

	use SoftDeletes, HasCreator;

    /***************************************************************************************
     ** RELATIONS
     ***************************************************************************************/

    public function facilities()
    {
        return $this->belongsToMany(Facility::class)->using(FacilityProvider::class);
    }

	public function organization()
	{
		return $this->belongsTo(Organization::class, 'organization_id');
	}

    public function procedures()
    {
        return $this->hasMany(\App\Models\Procedure::class, 'provider_id');
    }

    /***************************************************************************************
     ** HELPERS
     ***************************************************************************************/

    public function getSuffix()
    {
        switch($this->suffix_type) {
            case 'md':
                return 'M.D.';
                break;
            case 'phd':
                return 'Ph.D.';
                break;
            case 'md-phd':
                return 'M.D.,Ph.D';
                break;
            case 'pa':
                return 'P.A.';
                break;
            case 'np':
                return 'N.P.';
                break;
            case 'rn':
                return 'R.N.';
                break;
        }
    }
}