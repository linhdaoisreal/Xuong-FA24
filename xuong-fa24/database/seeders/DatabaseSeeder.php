<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Comment;
use App\Models\Phone;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('classrooms')->insert([
                'name' => 'Classroom ' . Str::random(5), // Tên lớp học ngẫu nhiên
                'teacher_name' => 'Teacher ' . Str::random(5), // Tên giáo viên ngẫu nhiên
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Seed 10 bản ghi cho bảng subjects
        for ($i = 1; $i <= 10; $i++) {
            DB::table('subjects')->insert([
                'name' => 'Subject ' . Str::random(5), // Tên môn học ngẫu nhiên
                'credits' => rand(1, 5), // Số tín chỉ ngẫu nhiên từ 1 đến 5
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // for ($i = 0; $i < 10; $i++) {
        //     Role::query()->create([
        //         'name'   => fake()->text(20),
        //     ]);
        // }

        // $userIDs = User::pluck('id')->all();

        // foreach ($userIDs as $userID) {
        //     Phone::query()->create([
        //         'user_id'   =>$userID,
        //         'value'     => fake()->unique()->phoneNumber(),
        //     ]);
        // }

        // for ($i = 0; $i < 10; $i++) {
        //     Post::query()->create([
        //         'tittle'   => fake()->text(100),
        //     ]);
        // }

        // for ($i = 1; $i < 11; $i++) {
        //     Comment::query()->create([
        //         'post_id'   => $i,
        //         'content'   => fake()->text,
        //     ]);

        //     Comment::query()->create([
        //         'post_id'   => $i,
        //         'content'   => fake()->text,
        //     ]);

        //     Comment::query()->create([
        //         'post_id'   => $i,
        //         'content'   => fake()->text,
        //     ]);
        // }

        // \App\Models\User::factory(1000)->create();

        // \App\Models\Department::factory(5)->create();
        // \App\Models\Manager::factory(5)->create();


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
