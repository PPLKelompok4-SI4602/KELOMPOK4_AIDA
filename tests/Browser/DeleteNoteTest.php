<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Note;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DeleteNoteTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test successful note deletion
     */
    public function test_user_can_delete_note()
    {
        // Create a test user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        // Create a test note
        $note = Note::factory()->create([
            'user_id' => $user->id,
            'title' => 'Note to be deleted',
            'description' => 'This note will be deleted'
        ]);

        $this->browse(function (Browser $browser) use ($user, $note) {
            // Login first
            $browser->visit('/login')
                   ->type('email', $user->email)
                   ->type('password', 'password123')
                   ->press('LOG IN')
                   ->clickLink('Notes') // Click on Notes link
                   ->clickLink('Delete') // Click on Delete button for the note
                   ->acceptDialog() // Accept the confirmation dialog
                   ->assertDontSee('Note to be deleted'); // Verify note is no longer visible in the list
        });
    }
} 