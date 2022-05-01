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
}
