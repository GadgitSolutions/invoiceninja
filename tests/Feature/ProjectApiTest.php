<?php
/**
 * Invoice Ninja (https://invoiceninja.com).
 *
 * @link https://github.com/invoiceninja/invoiceninja source repository
 *
 * @copyright Copyright (c) 2020. Invoice Ninja LLC (https://invoiceninja.com)
 *
 * @license https://opensource.org/licenses/AAL
 */
namespace Tests\Feature;

use App\DataMapper\DefaultSettings;
use App\Models\Account;
use App\Models\Project;
use App\Models\ProjectContact;
use App\Models\Company;
use App\Models\User;
use App\Utils\Traits\MakesHash;
use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Tests\MockAccountData;
use Tests\TestCase;

/**
 * @test
 * @covers App\Http\Controllers\ProjectController
 */
class ProjectApiTest extends TestCase
{
    use MakesHash;
    use DatabaseTransactions;
    use MockAccountData;

    public function setUp() :void
    {
        parent::setUp();

        $this->makeTestData();

        Session::start();

        $this->faker = \Faker\Factory::create();

        Model::reguard();
    }

    public function testProjectGet()
    {
        $response = $this->withHeaders([
                'X-API-SECRET' => config('ninja.api_secret'),
                'X-API-TOKEN' => $this->token,
            ])->get('/api/v1/projects/'.$this->encodePrimaryKey($this->project->id));

        $response->assertStatus(200);
    }


    public function testProjectPost()
    {
        $data = [
            'name' => $this->faker->firstName,
            'client_id' => $this->client->hashed_id,
        ];

        $response = $this->withHeaders([
                'X-API-SECRET' => config('ninja.api_secret'),
                'X-API-TOKEN' => $this->token,
            ])->post('/api/v1/projects', $data);

        $response->assertStatus(200);
    }

    public function testProjectPut()
    {
        $data = [
            'name' => $this->faker->firstName,
            'public_notes' => 'Coolio',
        ];

        $response = $this->withHeaders([
                'X-API-SECRET' => config('ninja.api_secret'),
                'X-API-TOKEN' => $this->token,
            ])->put('/api/v1/projects/'.$this->encodePrimaryKey($this->project->id), $data);

        $response->assertStatus(200);
    }


    public function testProjectNotArchived()
    {
        $response = $this->withHeaders([
                'X-API-SECRET' => config('ninja.api_secret'),
                'X-API-TOKEN' => $this->token,
            ])->get('/api/v1/projects/'.$this->encodePrimaryKey($this->project->id));

        $arr = $response->json();

        $this->assertEquals(0, $arr['data']['archived_at']);
    }

    public function testProjectArchived()
    {
        $data = [
            'ids' => [$this->encodePrimaryKey($this->project->id)],
        ];

        $response = $this->withHeaders([
                'X-API-SECRET' => config('ninja.api_secret'),
                'X-API-TOKEN' => $this->token,
            ])->post('/api/v1/projects/bulk?action=archive', $data);

        $arr = $response->json();

        $this->assertNotNull($arr['data'][0]['archived_at']);
    }

    public function testProjectRestored()
    {
        $data = [
            'ids' => [$this->encodePrimaryKey($this->project->id)],
        ];

        $response = $this->withHeaders([
                'X-API-SECRET' => config('ninja.api_secret'),
                'X-API-TOKEN' => $this->token,
            ])->post('/api/v1/projects/bulk?action=restore', $data);

        $arr = $response->json();

        $this->assertEquals(0, $arr['data'][0]['archived_at']);
    }

    public function testProjectDeleted()
    {
        $data = [
            'ids' => [$this->encodePrimaryKey($this->project->id)],
        ];

        $response = $this->withHeaders([
                'X-API-SECRET' => config('ninja.api_secret'),
                'X-API-TOKEN' => $this->token,
            ])->post('/api/v1/projects/bulk?action=delete', $data);

        $arr = $response->json();

        $this->assertTrue($arr['data'][0]['is_deleted']);
    }
}
