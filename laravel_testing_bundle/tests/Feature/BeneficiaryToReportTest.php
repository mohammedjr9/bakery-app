<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BeneficiaryToReportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function newly_created_beneficiary_appears_in_monthly_report()
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        $payload = [
            'name' => 'Mona Saleh',
            'phone' => '0569876543',
            'service_type' => 'Cash Aid',
        ];

        $this->post('/beneficiaries', $payload)->assertStatus(302);

        $res = $this->get('/reports?type=monthly')->assertOk();
        $res->assertSee('Mona Saleh');
    }
}