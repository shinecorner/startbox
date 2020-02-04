<?php 

namespace Tests\Controllers\API;

use Tests\TestCase;
use Faker\Generator;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;
use Faker\Factory;

use App\Models\Facility;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\Procedure;
use App\Models\Provider;
use App\Models\User;

use Tests\ProcedureFactory;
use Tests\ProviderFactory;

class ProviderControllerTest extends TestCase
{
    use RefreshDatabase;

    /***************************************************************************************
     ** GET
     ***************************************************************************************/

    /**
     * @test
     * GET 'api/providers'
     */
    public function a_user_can_get_a_list_of_providers()
    {
        $user = factory(User::class)->states('no-profile')->create();

        $providers = factory(Provider::class, 2)->create(['creator_id' => $user->id]);
        
        $response = $this->actingAs($user, 'airlock')
                        ->json('GET', '/client/api/v1/providers')
                        ->assertJson(['success' => true])
                        ->assertJsonStructure([
                            'data' => ['*' => [
                                'id',
                                'first_name',
                                'last_name',
                                'suffix',
                            ]],
                        ]);
        $response = json_decode($response->getContent());
        $this->assertCount(2, $response->data);
    }

    /**
     * @test
     * GET 'api/providers'
     */
    public function a_user_can_search_for_a_provider_by_name()
    {
        $user = factory(User::class)->create();
        $providers = factory(Provider::class, 5)->create(['creator_id' => $user->id]);

        $random_provider = $providers->random();

        $response = $this->actingAs($user, 'airlock')
                        ->json('GET', '/client/api/v1/providers', [
                            'term' => $random_provider->first_name,
                        ])
                        ->assertJson(['success' => true]);
        $response = json_decode($response->getContent());

        $this->assertTrue(count($response->data) >= 1);

        $returned_providers = collect($response->data);
        $this->assertTrue($returned_providers->pluck('id')->contains($random_provider->id));
        $this->assertEquals($returned_providers->first()->id, $random_provider->id);
    }

    /**
     * @test
     * GET 'api/providers/{provider}'
     */
    public function a_user_can_get_a_provider()
    {
        $user = factory(User::class)->create();

        $provider = app(ProviderFactory::class)
            ->withFacilityCount(2)
            ->withTodayProcedureCount(4)
            ->withFutureProcedureCount(3)
            ->create();

        $this->assertCount(7, $provider->procedures);

        $response = $this->actingAs($user, 'airlock')
                        ->json('GET', '/client/api/v1/providers/' . $provider->id)
                        ->assertJson(['success' => true])
                        ->assertJsonStructure([
                            'data' => [
                                'id',
                                'first_name',
                                'last_name',
                                'suffix',
                                'facilities' => [],
                                'procedures' => [],
                            ],
                        ]);

        $response = json_decode($response->getContent());

        tap($response->data, function ($rProvider) use ($provider) {
            $this->assertEquals($rProvider->id, $provider->id);
            $this->assertCount(2, $rProvider->facilities);
            $this->assertCount(4, $rProvider->procedures);
        });

        $this->assertEquals($response->data->id, $provider->id);
    }

    /**
     * @test
     * GEt 'api/patients/{patient}/providers'
     */
    public function a_user_can_list_providers_by_patient()
    {
        $user = factory(User::class)->create();

        $defaultProvider = factory(Provider::class)->create();
        
        $patient = factory(Patient::class)->create([
            'default_provider_id' => $defaultProvider->id,
            'organization_id' => $defaultProvider->organization_id,
        ]);

        $procedures = collect([]);
        for ($i=0; $i < 3; $i++) { 
            $procedure = app(ProcedureFactory::class)
                ->hasOrganization($defaultProvider->organization)
                ->hasPatient($patient)
                ->create();

            $procedures->push(3);
        }

        // should not be pulled
        // factory(Procedure::class, 4)->create();

        $response = $this->actingAs($user, 'airlock')
                        ->json('GET', '/client/api/v1/patients/' . $patient->id .'/providers')
                        ->assertJson(['success' => true]);

        $response = json_decode($response->getContent());

        logger(json_encode($response->data));
        
        tap(collect($response->data), function($rProviders) {
            $this->assertEquals(4, $rProviders->count());
        });
    }
}