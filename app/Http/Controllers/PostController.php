<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Comment;

class PostController extends Controller
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
        if ( Auth::user() == null ) {
            return redirect('login');   // redireciona o user para a pagina de login se nao estiver logado
        }

        return view('posts.create')->with('categories', Category::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ( Auth::user() == null ) {
            return redirect('login');   // redireciona o user para a pagina de login se nao estiver logado
        }

        $trimmed_desc = Str::of($request->post_content)->words(30, ' (...)'); // guarda o content ate 30 primeiras palavras e adiciona (...) no fim

        $thisPost = Post::create([
            'post_author' => Auth::user()->id,  // associa o novo post ao utilizador que o criou
            'post_title' => $request->post_title,
            'post_content' => nl2br($request->post_content), // preserva os line breaks e converte-os para <br/>
            'post_trimmed_desc' => $trimmed_desc, // corta o conteudo para uma breve descrição
        ]);

        $thisPost->categories()->attach($request->category_id);

        $thisPost->users()->associate(Auth::user()->id);

        return redirect()->route('startpage'); // temporario
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // $currentUrl = url()->current(); // provavelmente useless, mas oh well

        $category_id = $_GET['category'];
        $post_id = $_GET['post'];

        

        return view('posts/postpage')->with('post', Post::find($post_id))->with('category', Category::find($category_id))
            ->with('comments', Comment::all()->where('original_post', $post_id));
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
    public function update(Request $request, Post $post)
    {

        $post->post_content = nl2br($request->post_content); // preserva line breaks

        if (Auth::user()->user_role == 0) {
            $post->post_content = $request->post_content . '<br /><br /> [ Edited ]';  // adiciona isto se detectar que foi um edit feito por um user com role ADMIN
            $post->post_content = nl2br($post->post_content);
            }

        if (Auth::user()->user_role == 1) {
        $post->post_content = $request->post_content . '<br /><br /> [ Edited by ADMIN - ' . Auth::user()->user_realname .  ' ]';  // adiciona isto se detectar que foi um edit feito por um user com role ADMIN
        $post->post_content = nl2br($post->post_content);
        }

        $post->post_title = $request->post_title;
        $post->updated_at = now();

        $post->save();


        return redirect()->back();
    }

    public function deactivate(Request $request, Post $post)
    {
        // vamos desativar o post em vez de o apagar - boas praticas de bases de dados
        // IGNORAR, NÃO FOI UTILIZADO - UTILIZOU-SE destroy() INSTEAD
        return redirect()->route('startpage');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // vamos desativar o post em vez de o apagar - boas praticas de bases de dados

        $thisPost = Post::findOrFail($post->id);

        $thisPost->post_active = 0;

        $thisPost->save();

        // se fossemos apagar mesmo o post teriamos de correr as funcoes para atualizar as relações M:N deste post com as categorias
        // como apenas estamos a desativar, não é necessário

        // mas senão teríamos de fazer algo do estilo, neste caso: 

        // $thisPost->categories()->detach();
        // para dar "detach" de todas as categorias associadas a este post (post has many categories)

        // para apagar as referencias a este post na tabela pivot category_post

        return redirect()->route('startpage');

    }
}
