<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Запускаем сидер ролей
        $this->call(RoleSeeder::class);

        // 2. Создаем модератора
        $moderatorRole = Role::where('name', 'moderator')->first();
        
        User::create([
            'name' => 'Главный Модератор',
            'email' => 'moderator@example.com',
            'password' => Hash::make('123456'),
            'role_id' => $moderatorRole->id,
        ]);

        // 3. Создаем читателя
        $readerRole = Role::where('name', 'reader')->first();
        User::create([
            'name' => 'Обычный Читатель',
            'email' => 'reader@example.com',
            'password' => Hash::make('123456'),
            'role_id' => $readerRole->id,
        ]);
    }
}