<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Admin;
use App\Models\Facility;
use App\Models\Organization;

class FacilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_all_facilities()
    {
        $admin = factory(Admin::class)->create();
        $response = $this->actingAs($admin)->get('/api/admin/facilities');
        
        $response->assertStatus(200);
    }

    public function test_can_create_a_facility()
    {
        $admin = factory(Admin::class)->create();
        $organization = factory(Organization::class)->create();
        $response = $this->actingAs($admin)
            ->post('/api/admin/facilities', [
                'title' => 'Some Title',
                'description' => 'Some Description',
                'organization_id'=>$organization->id,
            ]);

        $response->assertStatus(200);
        $this->assertEquals(1, Facility::count());
    }

    public function test_can_show_a_facility()
    {
        $admin = factory(Admin::class)->create();
        $facility = factory(Organization::class)->create();
        $response = $this->actingAs($admin)->get("/api/admin/facilities/$facility->id");

        $response->assertStatus(200);
    }

    public function test_can_update_a_facility()
    {
        $admin = factory(Admin::class)->create();
        $organization = factory(Organization::class)->create();
        $facility = factory(Facility::class)->create();
        $response = $this->actingAs($admin)
            ->put("/api/admin/facilities/{$facility->id}", [
                'title' => 'Some Title',
                'description' => 'Some Description',
                'organization_id'=> $organization->id,
                'id'=> $facility->id,
                'creator_id'=>$admin->id,
            ]);

        $response->assertStatus(200);
    }
    
    public function test_can_delete_a_facility()
    {
        $admin = factory(Admin::class)->create();
        $facility = factory(Facility::class)->create();
        $response = $this->actingAs($admin)->delete("/api/admin/facilities/{$facility->id}");

        $response->assertStatus(200);
        $this->assertEquals(0, Facility::count());
    }

}
