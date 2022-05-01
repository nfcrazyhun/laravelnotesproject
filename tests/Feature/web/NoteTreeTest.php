<?php

namespace Tests\Feature\web;

use App\Models\Note;
use App\Models\User;
use Mockery\Matcher\Not;
use Tests\TestCase;

class NoteTreeTest extends TestCase
{
    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_user_can_see_notes_tree_index_page()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('notes-tree.index'));

        $response
            ->assertOk()
            ->assertSee('Notes Tree') //page title
        ;
    }

    public function test_user_can_see_own_notes()
    {
        $this->actingAs($this->user);

        $notePrivate = Note::factory()->private()->for($this->user)->create();
        $notePublic = Note::factory()->for($this->user)->create();


        $response = $this->get(route('notes-tree.index', ['username' => $this->user->username]));

        $response
            ->assertOk()
            ->assertSee($notePrivate->body)
            ->assertSee($notePublic->body)
        ;
    }

    public function test_user_can_see_another_user_public_notes_under_his_hierarchy()
    {
        $this->actingAs($this->user);

        $anotherUser = User::factory()->create();


        $notePrivate = Note::factory()->private()->for($anotherUser)->create();
        $notePublic = Note::factory()->for($anotherUser)->create();


        $response = $this->get(route('notes-tree.index', ['username' => $anotherUser->username]));

        $response
            ->assertOk()
            ->assertSee($notePrivate->body)
            ->assertSee($notePublic->body)
        ;
    }
}
