<?php

namespace Tests\Feature\web;

use App\Enums\NoteStatus;
use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NoteTest extends TestCase
{
    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_user_can_see_their_notes()
    {
        $this->actingAs($this->user);

        $note1 = Note::factory()->for($this->user)->create();
        $note2 = Note::factory()->for($this->user)->create();

        $response = $this->get(route('notes.index'));

        $response
            ->assertOk()
            ->assertSee([
                $note1->id,
                $note1->body,
            ])
            ->assertSee([
                $note2->id,
                $note2->body,
            ])
        ;
    }

    public function test_user_can_create_note()
    {
        $this->actingAs($this->user);

        $note1 = Note::factory()->for($this->user)->create();
        $note2 = Note::factory()->for($this->user)->create();

        $response = $this->get(route('notes.index'));

        $response
            ->assertOk()
            ->assertSee([
                $note1->id,
                $note1->body,
            ])
            ->assertSee([
                $note2->id,
                $note2->body,
            ])
        ;
    }

    public function test_user_can_update_note()
    {
        $this->actingAs($this->user);

        $note = Note::factory()->for($this->user)->create([
            'body' => 'foobar',
            'status' => NoteStatus::PRIVATE->value,
        ]);

        $response = $this->patch(route('notes.update', $note), [
            'body' => 'updated',
            'status' => NoteStatus::PUBLIC->value,
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('notes',[
            'body' => 'foobar',
            'status' => NoteStatus::PRIVATE->value,
        ]);

        $this->assertDatabaseHas('notes',[
            'body' => 'updated',
            'status' => NoteStatus::PUBLIC->value,
        ]);
    }

    public function test_user_can_delete_note()
    {
        $this->actingAs($this->user);

        $note = Note::factory()->for($this->user)->create([
            'body' => 'foobar',
            'status' => NoteStatus::PRIVATE->value,
        ]);

        $response = $this->delete(route('notes.destroy', $note));

        $response->assertStatus(302);

        $this->assertSoftDeleted('notes', $note->getAttributes());
    }

    /*
     * Sad paths
     */

    public function test_user_cannot_update_another_user_note()
    {
        $this->actingAs($this->user);

        $anotherUser = User::factory();
        $anotherNote = Note::factory()->for($anotherUser)->create([
            'body' => 'foobar',
            'status' => NoteStatus::PRIVATE->value,
        ]);

        $response = $this->patch(route('notes.update', $anotherNote->id), [
            'body' => 'updated',
            'status' => NoteStatus::PUBLIC->value,
        ]);

        $response
            ->assertForbidden();

        $this->assertDatabaseHas('notes',[
            'body' => 'foobar',
            'status' => NoteStatus::PRIVATE->value,
        ]);

        $this->assertDatabaseMissing('notes',[
            'body' => 'updated',
            'status' => NoteStatus::PUBLIC->value,
        ]);
    }

    public function test_user_can_delete_another_user_note()
    {
        $this->actingAs($this->user);

        $anotherUser = User::factory();
        $anotherNote = Note::factory()->for($anotherUser)->create([
            'body' => 'foobar',
            'status' => NoteStatus::PRIVATE->value,
        ]);


        $response = $this->delete( route('notes.destroy', $anotherNote));

        $response
            ->assertForbidden();

        $this->assertDatabaseHas('notes', $anotherNote->getAttributes());
    }
}
