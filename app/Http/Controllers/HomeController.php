<?php

namespace App\Http\Controllers;

use App\Models\BoxControl;
use App\Models\Customer;
use App\Models\Fasilitas;
use App\Models\Kerusakan;
use App\Models\Mitra;
use App\Models\Pemeliharaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'admin' => User::where('role', 'Admin')->count(),
            'teknisi' => User::where('role', 'Teknisi')->count(),
            'fasilitas' => Fasilitas::count(),
            'kerusakan' => Kerusakan::count(),
            'box' => BoxControl::count(),
            'pemeliharaan' => Pemeliharaan::count(),
            'mitra' => Mitra::count(),
        ];
        return view('admin.dashboard', $data);
    }
    public function grafik()
    {
        $pemeliharaan = Pemeliharaan::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $kerusakan = Kerusakan::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Fill missing months with 0
        for ($i = 1; $i <= 12; $i++) {
            if (!isset($pemeliharaan[$i])) {
                $pemeliharaan[$i] = 0;
            }
            if (!isset($kerusakan[$i])) {
                $kerusakan[$i] = 0;
            }
        }

        ksort($pemeliharaan);
        ksort($kerusakan);

        $data = [
            'months' => array_keys($pemeliharaan),
            'pemeliharaan' => array_values($pemeliharaan),
            'kerusakan' => array_values($kerusakan),
        ];

        return response()->json($data);
    }
}
