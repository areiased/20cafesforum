<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Post;
use App\User;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function welcome() {

        $active_categories = Category::all()->where('category_active', 1);
        $allActivePosts = Post::all()->where('post_active', 1);

        return view('welcome')->with('categories', $active_categories)->with('allActivePosts', $allActivePosts);
    }

    public function viewCategory(Request $request) {
        $categoryid = $request->path();
        $categoryid = trim($categoryid, "category="); // fica apenas o id da categoria mesmo
        
        $category = Category::find($categoryid);

        if($category == null) {
            return redirect()->route('startpage'); // handler para caso o user especifique manualmente um URL duma category que não existe
        }


        if ( ($category->category_active) == 0) {
            return redirect()->route('startpage'); // se a categoria estiver desativada (user entrou via link), o user é redirecionado para a startpage
        };

        return view('categorypage')->with('category', $category)->with('posts', Category::find($category->id)->posts()->get()->reverse());
    }

    public function deactivate(Category $requested_category) {

        if( Auth::user()->user_role == 1 ) {    // verifica se o user logado tem permissao de admin e só executa se sim

            $category = Category::findOrFail($requested_category->id);

            $category->category_active = 0;

            $category->save();

            return redirect()->route('startpage');
        };

        return redirect()->route('startpage');
    }
}
