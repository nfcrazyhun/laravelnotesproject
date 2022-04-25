<?php

namespace Database\Seeders;

use App\Enums\NoteStatus;
use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seeding demo note data.
     * @return void
     */
    public function run()
    {


        $admin = User::where(['username' => 'admin'])->first();


        //Create a public note
        Note::factory()->create(['user_id' => $admin]);


        //Create a private note
        Note::factory()->private()->create(['user_id' => $admin]);



        //Create notes for users randomly
        $users = User::pluck('id');

        for ($i = 0; $i < 30; $i++) {
            Note::factory()->create([
                'user_id' => Arr::random($users->toArray()),
                'status' => Arr::random([NoteStatus::PUBLIC, NoteStatus::PUBLIC, NoteStatus::PRIVATE]), // 1/3 chance to private
            ]);
        }

    }
}
