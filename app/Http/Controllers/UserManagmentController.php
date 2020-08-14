<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;

class UserManagmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view()->with('allUserData', User::all());
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
        //
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
    public function edit(User $user)
    {
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if ( Auth::user() == null ) {
            return redirect('login');   // redireciona o user para a pagina de login se nao estiver logado
        }

        // hash::check compara a passe que o user deu com a hash stored na database
        if ( ! Hash::check($request->givenpassword, User::find(Auth::user()->id)->password) ) { // cancela se a pass do user estiver mal
            return redirect('home')->withErrors(["password"=>"Wrong Password!"]);
        };

        $user->user_realname = $request->user_realname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->updated_at = now();
        
        $user->save();

        return redirect('/home')->with('user_data', Auth::user());

    }

    public function deactivate(Request $request, User $user) {

        if ( Auth::user() == null ) {
            return redirect('login');   // redireciona o user para a pagina de login se nao estiver logado
        }

        if ( ! Hash::check($request->deactivatepassword, Auth::user()->password) ) { // cancela se a pass do user estiver mal
            return redirect('home')->withErrors(["deactivatepassword"=>"Wrong Password!"]);
        };

        $user = User::find(Auth::user()->id);
        $user->updated_at = now();
        $user->user_active = 0;

        $user->save();


        return redirect('logout');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // utiliei deactivate, criado por mim, instead
    }
}
