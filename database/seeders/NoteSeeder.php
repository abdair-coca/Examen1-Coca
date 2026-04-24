<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Note;
use App\Models\User;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $users = User::all();

        // Crear 15 notas
        Note::factory(15)->create()->each(function ($note) use ($users) {

            // 1. Asignar owner (primer usuario)
            $owner = User::where('email', 'admin@uatf.bo')->first();
            $note->users()->attach($owner->id, ['role' => 'owner']);

            // 2. Compartir con 1 o 2 usuarios aleatorios
            $collaborators = $users->random(rand(1, 2));

            foreach ($collaborators as $user) {
                if ($user->id !== $owner->id) {
                    $note->users()->attach($user->id, [
                        'role' => fake()->randomElement(['editor', 'viewer'])
                    ]);
                }
            }
        });
    }
}
