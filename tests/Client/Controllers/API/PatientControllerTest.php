<?php

namespace Tests\Client\Controllers\API;

use Carbon\Carbon;
use Faker\Factory;
use Tests\TestCase;
use App\Models\User;
use Faker\Generator;
use App\Models\Patient;
use App\Models\Facility;
use App\Models\Organization;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PatientControllerTest extends TestCase
{
    use RefreshDatabase;

    /***************************************************************************************
     ** GET
     ***************************************************************************************/

    /**
     * @test
     * GET 'api/patients'
     */
    public function a_user_can_get_a_list_of_patients()
    {
        $user = factory(User::class)->create();
        $patients = factory(Patient::class, 2)->create(['creator_id' => $user->id]);

        $response = $this->actingAs($user, 'airlock')
                        ->json('GET', '/client/api/v1/patients')
                        ->assertJson(['success' => true]);
        $response = json_decode($response->getContent());
        $this->assertCount(2, $response->data);
    }

    /**
     * @test
     * GET 'api/patients'
     */
    public function a_user_can_search_for_a_patient_by_name()
    {
        $user = factory(User::class)->create();
        $patients = factory(Patient::class, 5)->create(['creator_id' => $user->id]);

        $random_patient = $patients->random();

        $response = $this->actingAs($user, 'airlock')
                        ->json('GET', '/client/api/v1/patients', [
                            'term' => $random_patient->first_name,
                        ])
                        ->assertJson(['success' => true]);
        $response = json_decode($response->getContent());

        $this->assertTrue(count($response->data) >= 1);

        $returned_patients = collect($response->data);
        $this->assertTrue($returned_patients->pluck('id')->contains($random_patient->id));
        $this->assertEquals($returned_patients->first()->id, $random_patient->id);
    }

    /**
     * @test
     * GET 'api/patients/{patient}'
     */
    public function a_user_can_get_a_patient()
    {
        $user = factory(User::class)->create();
        $patient = factory(Patient::class)->create(['creator_id' => $user->id]);

        $response = $this->actingAs($user, 'airlock')
                        ->json('GET', '/client/api/v1/patients/' . $patient->id)
                        ->assertJson(['success' => true]);
        $response = json_decode($response->getContent());

        $this->assertEquals($response->data->id, $patient->id);
    }

    /***************************************************************************************
     ** CRUD
     ***************************************************************************************/

    /**
     * @test
     * POST 'api/patients'
     */
    public function a_user_can_create_a_patient()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'airlock')
                        ->json('POST', '/client/api/v1/patients', [
                            'first_name' => 'Jonny',
                            'last_name' => 'Bravo',
                            'dob' => '1972-01-02',
                            'sex' => 'm',
                        ])
                        ->assertJson(['success' => true]);

        $response = json_decode($response->getContent());

        tap($response->data, function ($rPatient) {
            $this->assertEquals('Jonny', $rPatient->first_name);
            $this->assertEquals('Bravo', $rPatient->last_name);
            $this->assertEquals('m', $rPatient->sex);
            $this->assertEquals('1972-01-02', $rPatient->dob);
        });

        $patient = Patient::find($response->data->id);
    }

    /**
     * @test
     * PUT 'api/patients/{patient}'
     */
    public function a_user_can_update_a_patient()
    {
        $user = factory(User::class)->states('provider')->create();
        $patient = factory(Patient::class)->create([
            'creator_id' => $user->id,
            'sex' => 'm',
        ]);

        $response = $this->actingAs($user, 'airlock')
                        ->json('PUT', '/client/api/v1/patients/' . $patient->id, [
                            'first_name' => 'Rico',
                            'last_name' => 'Suave',
                            'dob' => '1972-01-05',
                            'sex' => 'o',
                        ])
                        ->assertJson(['success' => true]);
        $response = json_decode($response->getContent());

        tap($response->data, function ($rPatient) {
            $this->assertEquals('Rico', $rPatient->first_name);
            $this->assertEquals('Suave', $rPatient->last_name);
            $this->assertEquals('o', $rPatient->sex);
            $this->assertEquals('1972-01-05', $rPatient->dob);
        });
    }

    /**
     * @test
     * DELETE 'api/patients/{patient}'
     */
    public function a_provider_cannot_delete_a_patient()
    {
        $user = factory(User::class)->states('provider')->create();
        $patient = factory(Patient::class)->create(['creator_id' => $user->id]);

        $response = $this->actingAs($user, 'airlock')
                        ->json('DELETE', '/client/api/v1/patients/' . $patient->id)
                        ->assertForbidden();
    }
}