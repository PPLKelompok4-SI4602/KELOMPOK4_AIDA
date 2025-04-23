<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Note;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class EditNoteTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test successful note editing
     */
    public function test_user_can_edit_note()
    {
        // Create a test user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        // Create a test note
        $note = Note::factory()->create([
            'user_id' => $user->id,
            'title' => 'Original Title',
            'description' => 'Original Description'
        ]);

        $this->browse(function (Browser $browser) use ($user, $note) {
            // Login first
            $browser->visit('/login')
                   ->type('email', $user->email)
                   ->type('password', 'password123')
                   ->press('LOG IN')
                   ->clickLink('Notes') // Click on Notes link
                   ->clickLink('Edit') // Click on Edit button for the note
                   ->type('title', 'Updated Title')
                   ->type('description', 'Updated Description')
                   ->press('UPDATE')
                   ->visit('/notes')
                   ->assertSee('Updated Title'); // Verify note is updated and visible in notes list
        });
    }
}
