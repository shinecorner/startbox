<?php namespace App\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Patient;
use App\Models\Provider;
use Carbon\Carbon;
use Log;

class Search
{
    public $term;
    public $order_field;
    public $order_direction;
    public $limit;

    public $paginate;
    public $items_per_page;
    public $params;

    // conditional params
    public $user;
    public $facility;
    public $location;

    public function __construct(User $user, string $term = null, array $additional_params = [])
    {
        // Searching
        $this->term = $term;

        // Ordering
        $this->order_field = Arr::get($additional_params, 'order_field');
        $this->order_direction = Arr::get($additional_params, 'order_direction', 'ASC');

        // Limiting (Pagination Off)
        $this->limit = Arr::get($additional_params, 'limit', 0);

        // Pagination
        $this->paginate = Arr::get($additional_params, 'paginate', false);
        $this->items_per_page = Arr::get($additional_params, 'items_per_page', 10);

        // additional params
        $this->params = $additional_params;
        $this->user = $user;

        $this->facility = Arr::get($additional_params, 'facility');
    }

    /***************************************************************************************
     ** PATIENTS
     ***************************************************************************************/

    public function patients()
    {
        $patients = Patient::when($this->term, function ($query) {
                            $query->whereRaw($this->getRawConcatStatement($this->term, 'patients'))
                                   ->orWhere('email', 'LIKE', '%' . $this->term . '%');
                        })
                        ->when($this->order_field, function ($query) {
                            $query->orderBy($this->order_field, $this->order_direction);
                        })
                        ->when(!$this->paginate && $this->limit, function ($query) {
                            $query->take($this->limit);
                        })
                        ->select('patients.*');
        // pagination
        if ($this->paginate && $this->items_per_page) {
            return $patients->paginate($this->items_per_page);
        }
        return $patients->get();
    }

    /***************************************************************************************
     ** PROVIDERS
     ***************************************************************************************/

    public function providers()
    {
        $providers = Provider::with('facilities')->when($this->term, function ($query) {
                            $query->whereRaw($this->getRawConcatStatement($this->term, 'providers'))
                                   ->orWhere('email', 'LIKE', '%' . $this->term . '%');
                        })
                        ->when($this->facility, function ($query) {
                            $query->join('facility_provider', function ($query) {
                                $query->on('providers.id', '=', 'facility_provider.provider_id')
                                    ->where('facility_provier.facility_id', $this->facility->id);
                            });
                        })
                        ->when($this->order_field, function ($query) {
                            $query->orderBy($this->order_field, $this->order_direction);
                        })
                        ->when(!$this->paginate && $this->limit, function ($query) {
                            $query->take($this->limit);
                        })
                        ->select('providers.*');
        // pagination
        if ($this->paginate && $this->items_per_page) {
            return $providers->paginate($this->items_per_page);
        }
        return $providers->get();
    }

    /***************************************************************************************
     ** USERS
     ***************************************************************************************/

    public function users()
    {
        $users = User::when($this->term, function ($query) {
                            $query->whereRaw($this->getRawConcatStatement($this->term))
                                   ->orWhere('email', 'LIKE', '%' . $this->term . '%');
                        })
                        ->when($this->order_field, function ($query) {
                            $query->orderBy($this->order_field, $this->order_direction);
                        })
                        ->when(!$this->paginate && $this->limit, function ($query) {
                            $query->take($this->limit);
                        })
                        ->select('users.*');
        // pagination
        if ($this->paginate && $this->items_per_page) {
            return $users->paginate($this->items_per_page);
        }
        return $users->get();
    }

    /***************************************************************************************
     ** HELPERS
     ***************************************************************************************/
    
    protected function getRawConcatStatement($term, string $tableName = 'users')
    {
        if (app()->environment('testing')) {
            return '(`'. $tableName .'`.`first_name` || `'. $tableName .'`.`last_name`) LIKE "%' . $term . '%"';
        }
        return 'CONCAT(`'. $tableName .'`.`first_name`, " ", `'. $tableName .'`.`last_name`) LIKE "%' . $term . '%"';
    }
}
