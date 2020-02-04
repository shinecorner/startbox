<?php

namespace App\Http\Controllers\Client\API;

use App\Helpers\Search;
use App\Http\Controllers\Client\Controller;
use App\Http\Resources\ProviderCollection;
use App\Http\Resources\ProviderResource;
use App\Models\Patient;
use App\Models\Provider;
use Auth;
use Illuminate\Http\Request;
use Log;

class ProviderController extends Controller
{
    /***************************************************************************************
     ** GET
     ***************************************************************************************/

    public function list(Request $request)
    {
        $search = new Search(Auth::user(), $request->input('term'), [
            'paginate' => $request->input('paginate', true),
            'items_per_page' => $request->input('items_per_page', 10),
        ]);
        $providers = $search->providers();

        return new ProviderCollection($providers);
    }

    public function listByPatient(Patient $patient)
    {
        $providers = $patient->procedures()->with('provider')->get()->pluck('provider')->keyBy('id');
        
        // add default
        if ($patient->defaultProvider && $providers->has($patient->defaultProvider->id) === false) {
            $providers->push($patient->defaultProvider);
        }

        return new ProviderCollection($providers);
    }

    public function get(Provider $provider, Request $request)
    {
        $provider->load(['facilities', 'procedures' => function ($query) {
            $query->with('facility', 'location', 'patient')
                  ->scheduledToday();
        }]);

        return $this->success(new ProviderResource($provider));
    }

}
