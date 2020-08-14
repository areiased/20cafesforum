<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Post;
use App\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);

        if(DB::table('users')->get()->count() == 0){
            factory(User::class, 10)->create();
            DB::table('users')->insert([
                [
                    'user_realname' => 'Admin Test',
                    'username' => 'admin-username',
                    'email' => 'admin@mail.com',
                    'email_verified_at' => now(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password <- THIS IS THIS PASSWORD
                    'remember_token' => Str::random(10),
                    'user_active' => 1,
                    'user_role' => 1, // admin user
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'user_realname' => 'User Test',
                    'username' => 'user-username',
                    'email' => 'user@mail.com',
                    'email_verified_at' => now(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password <- THIS IS THIS PASSWORD
                    'remember_token' => Str::random(10),
                    'user_active' => 1,
                    'user_role' => 0, // normal user
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

            ]);
        }; // só executa se a table estiver vazia, para não estragar os dados atuais

        if(DB::table('categories')->get()->count() == 0){
            // factory(Category::class, 1)->create();
            DB::table('categories')->insert([

                [
                    'category_title' => 'General Discussion',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'category_active' => '1',
                ],
                [
                    'category_title' => 'Hardware and Software',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'category_active' => '1',
                ],
                [
                    'category_title' => 'Operating Systems',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'category_active' => '1',
                ],
                [
                    'category_title' => 'Hacking',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'category_active' => '1',
                ],
                [
                    'category_title' => 'Other Topics',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'category_active' => '1',
                ],
        
            ]);
        }; // só executa se a table estiver vazia, para não estragar os dados atuais

        factory(Post::class, 20)->create();

        foreach (\App\Post::all() as $post) {
            $categoryid = \App\Category::inRandomOrder()->take(rand(1,3))->pluck('id');
            $post->categories()->attach($categoryid);

        }

    }
}
