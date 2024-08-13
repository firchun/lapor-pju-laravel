<?php

namespace App\Http\Controllers;

use App\Models\Pemantauan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PemantauanController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Input pemantauan'
        ];
        return view('admin.pemantauan.index', $data);
    }
    public function getPemantauanDataTable(Request $request)
    {
        $Pemantauan = Pemantauan::with(['fasilitas', 'user'])->orderByDesc('id');
        if (Auth::user()->role == 'Teknisi') {
            $Pemantauan->where('id_user', Auth::id());
        }
        if ($request->has('date') && !empty($request->date)) {
            $date = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y-m-d');

            $Pemantauan->whereDate('created_at', $date);
        }
        return DataTables::of($Pemantauan)

            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'id_fasilitas' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
        ]);

        $pemantauanData = [
            'id_fasilitas' => $request->input('id_fasilitas'),
            'tunggakan' => $request->input('tunggakan'),
            'id_user' => Auth::id(),
            'keterangan' => $request->input('keterangan'),
        ];

        if ($request->filled('id')) {
            $data = Pemantauan::find($request->input('id'));
            if (!$data) {
                return response()->json(['message' => 'data not found'], 404);
            }

            $data->update($pemantauanData);
            $message = 'data updated successfully';
        } else {
            Pemantauan::create($pemantauanData);
            $message = 'data created successfully';
        }

        return response()->json(['message' => $message]);
    }
}
