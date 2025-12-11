<?php
namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UatBeneficiaryFlowTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function staff_can_add_beneficiary_and_filter_by_date()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/dashboard')
                ->clickLink('Beneficiaries')
                ->press('Add New')
                ->type('name', 'Sara N.')
                ->type('phone', '0569998887')
                ->select('service_type', 'Food Aid')
                ->press('Save')
                ->assertSee('Saved successfully')
                ->clickLink('Reports')
                ->type('from_date', now()->subMonth()->format('Y-m-d'))
                ->type('to_date', now()->format('Y-m-d'))
                ->press('Filter')
                ->assertSee('Sara N.');
        });
    }
}