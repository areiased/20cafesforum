<?php

namespace App\Http\Controllers;

use Illuminate\Cache\RedisTaggedCache;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $thisComment = Comment::create([
            'content' => nl2br($request->comment_content), // preserva os line breaks e converte para brs
            'original_post' => $request->post_id,
            'created_at' => now(),
            'updated_at' => now(),
            'comment_author' => Auth::user()->id,
        ]);

        $thisComment->users()->associate(Auth::user()->id);

        $thisComment->posts()->associate($request->post_id);

        return redirect()->back();  // volta para a pagina anterior apos inserir corretamente o comment
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->content = nl2br($request->comment_content); // preserva line breaks

        if (Auth::user()->user_role == 1) {
        $comment->content = $request->comment_content . '<br /><br /> [ Edited by ADMIN - ' . Auth::user()->user_realname .  ' ]';  // adiciona isto se detectar que foi um edit feito por um user com role ADMIN
        $comment->content = nl2br($comment->content);
        }

        
        $comment->updated_at = now();

        $comment->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // boas praticas de database apenas se desativa o comment mas por falta de tempo vou mesmo apagar
        // ja deste o inicio a tabela comments estava preparada para isto com "comment_active" 1 ou 0

        $thisComment = Comment::findOrFail($id); //procurar o comment em questão na DB

        $thisComment->users()->dissociate(); // apagar as relações com o user que o criou

        $thisComment->posts()->dissociate(); // apagar as relações com o post onde pertence

        $thisComment->delete(); // apagar o comment

        return redirect()->back();

    }
}
