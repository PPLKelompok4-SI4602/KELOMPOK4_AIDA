<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LogoutTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test successful user logout
     */
    public function test_user_can_logout()
    {
        // Create a test user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            // Login first
            $browser->visit('/login')
                   ->type('email', $user->email)
                   ->type('password', 'password123')
                   ->press('LOG IN')
                   ->assertPathIs('/dashboard')
                   ->clickLink('Logout') // Click on Logout link
                   ->assertPathIs('/login') // Verify redirected to login page
                   ->assertSee('LOG IN'); // Verify login page is displayed
        });
    }
} 