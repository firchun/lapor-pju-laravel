<?php

namespace App\Http\Controllers;

use App\Models\Kerusakan;
use App\Models\Perbaikan;
use App\Models\PerbaikanSelesai;
use Illuminate\Http\Request;
use PDF;

class laporanController extends Controller
{
    public function perbaikan()
    {
        $data = [
            'title' => 'Laporan perbaikan oleh teknisi',
        ];
        return view('admin.laporan.perbaikan', $data);
    }
    public function detail_laporan($id)
    {
        $data = Kerusakan::find($id);
        $perbaikan = Perbaikan::where('id_kerusakan', $id)->first();
        $selesai = PerbaikanSelesai::where('id_kerusakan', $id)->first();
        $pdf = PDF::loadview('admin/laporan/detail_laporan', ['data' => $data, 'perbaikan' => $perbaikan, 'selesai' => $selesai])->setPaper("A4", "portrait");
        return $pdf->stream('laporan_perbaikan_' . date('His') . '.pdf');
    }
}
