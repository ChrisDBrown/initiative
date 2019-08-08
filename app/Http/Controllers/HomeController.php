<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): Renderable
    {
        /** @var \App\User $user */
        $user = Auth::user();
        $games = $user->games;

        return view('home', ['games' => $games]);
    }
}
