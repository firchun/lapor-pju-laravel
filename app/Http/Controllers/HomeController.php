<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Fasilitas;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'users' => User::count(),
            'fasilitas' => Fasilitas::count()
        ];
        return view('admin.dashboard', $data);
    }
}
