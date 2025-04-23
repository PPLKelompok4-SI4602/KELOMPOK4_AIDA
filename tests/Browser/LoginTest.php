<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test successful login with valid credentials
     */
    public function test_user_can_login_with_valid_credentials()
    {
        // Create a test user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                   ->type('email', $user->email)
                   ->type('password', 'password123')
                   ->press('LOG IN')
                   ->assertPathIs('/dashboard') // Assuming successful login redirects to dashboard
                   ->assertSee('Dashboard'); // Verify we're on dashboard page
        });
    }
}
