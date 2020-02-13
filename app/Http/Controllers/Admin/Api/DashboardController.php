<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\ApiController;
use App\Services\Report;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardController extends ApiController
{
    protected $sReport;

    public function __construct(Report $sReport)
    {
       $this->sReport = $sReport;
    }

    public function index(Request $request)
    {
        $summary['active_users'] = [];
        $active_users = $this->sReport->getUsers();
        if($active_users->count() > 0){
            $current_page = LengthAwarePaginator::resolveCurrentPage();
            $per_page = 6;
            $current_page_items = $active_users->slice(($current_page * $per_page) - $per_page, $per_page)->all();
            $paginated_active_users = new LengthAwarePaginator($current_page_items, count($active_users), $per_page);
            $paginated_active_users->setPath($request->url());
            $summary['active_users'] = $paginated_active_users;
        }
        $total_users = $this->sReport->getTotalUsers()->count();
        $total_organizations = $this->sReport->getTotalOrganizations()->count();
        $total_facilities = $this->sReport->getTotalFacilities()->count();
        $total_locations = $this->sReport->getTotalLocations()->count();

        $summary['total_organizations'] = $total_organizations;
        $summary['total_facilities'] = $total_facilities;
        $summary['total_locations'] = $total_locations;
        $summary['total_users'] = $total_users;
        
        return $this->respondData('Dashboard summary',  $summary);
    }
}
