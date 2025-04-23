<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test successful registration with valid data
     */
    public function test_user_can_register_with_valid_data()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                   ->type('name', 'Test User')
                   ->type('email', 'test@example.com')
                   ->type('password', 'password123')
                   ->type('password_confirmation', 'password123')
                   ->press('REGISTER')
                   ->assertPathIs('/dashboard') // Assuming successful registration redirects to dashboard
                   ->assertSee('Dashboard'); // Verify we're on dashboard page
        });
    }
}
