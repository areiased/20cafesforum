<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPanelController extends Controller
{

    public function __construct()  // verifica se o user está logged in, senão redireciona para a página de login
    {
        $this->middleware('auth');
    }

    public function index() {

        if ( Auth::user()->user_role == 0 ) {   // evita que users com role 0 "user" consigam aceder ao admin panel
            return redirect(RouteServiceProvider::START);
        };

        if ( User::find(Auth::user()->id)->user_role == 0 ) {   // proteção adicional que vai ver mesmo à DB caso consigam avançar a primeira
            return redirect(RouteServiceProvider::START);
        };

        return view('adminpanel');
    }
}
