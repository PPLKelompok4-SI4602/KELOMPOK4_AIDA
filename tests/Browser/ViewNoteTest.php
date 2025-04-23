<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Note;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ViewNoteTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test successful note viewing
     */
    public function test_user_can_view_note()
    {
        // Create a test user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        // Create a test note
        $note = Note::factory()->create([
            'user_id' => $user->id,
            'title' => 'Test Note Title',
            'description' => 'This is a test note description'
        ]);

        $this->browse(function (Browser $browser) use ($user, $note) {
            // Login first
            $browser->visit('/login')
                   ->type('email', $user->email)
                   ->type('password', 'password123')
                   ->press('LOG IN')
                   ->clickLink('Notes') // Click on Notes link
                   ->clickLink('View') // Click on View button for the note
                   ->assertSee('Test Note Title') // Verify note title is visible
                   ->assertSee('This is a test note description'); // Verify note description is visible
        });
    }
} 