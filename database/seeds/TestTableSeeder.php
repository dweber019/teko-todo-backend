<?php

use Illuminate\Database\Seeder;

class TestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\User::class)->times(3)->create();
        $user = factory(\App\Models\User::class)->create([
          'firstName' => 'David',
          'lastName' => 'Weber',
          'birthday' => '1990-06-29',
          'email' => 'david.weber@w3tec.ch',
          'password' => 'awes0me!',
        ]);

        $tasklists = factory(\App\Models\Tasklist::class)->times(5)->create();

        foreach ($tasklists->all() AS $item) {
            $user->tasklists()->attach($item->id);
        }

        $user->assignRole('admin');

        factory(\App\Models\Task::class)->times(20)->create([
            'tasklistId' => $tasklists->random()->id,
            'userId' => $user->id
        ]);
    }
}
