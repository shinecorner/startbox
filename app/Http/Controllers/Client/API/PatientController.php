<?php

namespace App\Http\Controllers\Client\API;

use Log;
use Auth;
use App\Helpers\Search;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Requests\PatientRequest;
use App\Http\Resources\PatientResource;
use App\Http\Resources\PatientCollection;
use App\Http\Controllers\Client\Controller;

class PatientController extends Controller
{
    /***************************************************************************************
     ** GET
     ***************************************************************************************/

    public function list(PatientRequest $request)
    {
        $search = new Search(Auth::user(), $request->input('term'), [
            'paginate' => $request->input('paginate', true),
            'items_per_page' => $request->input('items_per_page', 10),
        ]);
        $patients = $search->patients();

        return new PatientCollection($patients);
    }

    public function get(Patient $patient, PatientRequest $request)
    {
        return $this->success(new PatientResource($patient));
    }

    /***************************************************************************************
     ** CRUD
     ***************************************************************************************/

    public function create(PatientRequest $request)
    {
        $patient = Patient::makeOne($request->all());

        return $this->success(new PatientResource($patient));
    }

    public function update(Patient $patient, PatientRequest $request)
    {
        $patient->update($request->validated());

        return $this->success(new PatientResource($patient));
    }

    public function delete(Patient $patient, PatientRequest $request)
    {
        $patient->delete();

        return $this->success();
    }
}
