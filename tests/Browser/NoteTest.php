<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class NoteTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test successful note creation
     */
    public function test_user_can_create_note()
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
                   ->clickLink('Notes') // Click on Notes link
                   ->clickLink('Create Note') // Click on Create Note button
                   ->type('title', 'Test Note Title')
                   ->type('description', 'This is a test note description')
                   ->press('CREATE')
                   ->visit('/notes')
                   ->assertSee('Test Note Title'); // Verify note is created and visible in notes list
        });
    }
} 