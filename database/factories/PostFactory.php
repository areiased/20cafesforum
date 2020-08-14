<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Post::class, function (Faker $faker) {

    $content = $faker->paragraph(10, true);
    $author = \App\User::inRandomOrder()->take(1)->pluck('id');
    return [
        'post_author' => str_replace (array('[', ']'), '' , $author), //como take() devolve sempre um array mas apenas temos 1 valor
        'post_title' => $faker->sentence,
        'post_content' => nl2br($content),  // preserva os line breaks
        'post_trimmed_desc' => Str::of($content)->words(30, ' (...)'), // corta o conteudo para uma breve descrição
    ];
});
