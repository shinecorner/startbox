<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Admin;

class FacilityValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_facility_title_must_not_be_empty()
    {
        $admin = factory(Admin::class)->create();
        $response = $this->actingAs($admin)
            ->post('/api/admin/facilities',[
                'description' => 'Some Description'
            ]);
        $response->assertStatus(200);
        $response->assertJson([
            'code' => 422,
        ]);
        
    }

    public function test_facility_description_must_not_be_empty()
    {
        $admin = factory(Admin::class)->create();
        $response = $this->actingAs($admin)
            ->post('/api/admin/facilities',[
                'title' => 'Some Title'
            ]);
        $response->assertStatus(200);
        $response->assertJson([
            'code' => 422,
        ]);
    }
}
