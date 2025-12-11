<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Beneficiary;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BeneficiaryServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_validates_palestinian_phone_and_creates_beneficiary()
    {
        $valid = '0591234567';
        $invalid = '12345';

        $isValid = fn(string $p) => preg_match('/^(059|056)\d{7}$/', $p);

        $this->assertTrue($isValid($valid));
        $this->assertFalse($isValid($invalid));

        $b = Beneficiary::create([
            'name' => 'Ahmed Ali',
            'phone' => $valid,
            'service_type' => 'Food Aid',
        ]);

        $this->assertDatabaseHas('beneficiaries', [
            'id' => $b->id,
            'name' => 'Ahmed Ali',
            'phone' => $valid,
        ]);
    }
}