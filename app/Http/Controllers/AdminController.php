<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): Renderable
    {
        /** @var \App\User $user */
        $user = Auth::user();
        $games = $user->games()::limit(3)->get();

        return view('admin.dashboard', ['games' => $games]);
    }
}
