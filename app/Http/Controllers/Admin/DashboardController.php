<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view(): Renderable
    {
        /** @var \App\User $user */
        $user = Auth::user();
        $games = $user->games()->limit(3)->get();

        return view('admin.dashboard', ['games' => $games]);
    }
}
