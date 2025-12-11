<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SystemFlowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function full_user_journey_runs_smoothly()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/dashboard');

        $this->actingAs($user)
            ->post('/beneficiaries', [
                'name' => 'Khaled Omar',
                'phone' => '0591112233',
                'service_type' => 'Medical Aid',
            ])->assertRedirect();

        $this->actingAs($user)
            ->get('/reports?type=summary')
            ->assertOk()
            ->assertSee('Khaled Omar');
    }
}