<?php

namespace App\Http\Controllers;

use App\Models\Kerusakan;
use App\Models\Pemantauan;
use App\Models\Perbaikan;
use App\Models\PerbaikanSelesai;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class laporanController extends Controller
{
    public function pemantauan()
    {
        $data = [
            'title' => 'Laporan pemantauan ',
        ];
        return view('admin.laporan.pemantauan', $data);
    }
    public function teknisi()
    {
        $data = [
            'title' => 'Laporan teknisi ',
        ];
        return view('admin.laporan.teknisi', $data);
    }

    public function perbaikan()
    {
        $data = [
            'title' => 'Laporan perbaikan ',
        ];
        return view('admin.laporan.perbaikan', $data);
    }
    public function pemeliharaan()
    {
        $data = [
            'title' => 'Laporan pemeliharaan Box Control ',
        ];
        return view('admin.laporan.pemeliharaan', $data);
    }
    public function pemeliharaan_teknisi()
    {
        $data = [
            'title' => 'Laporan pemeliharaan Box Control ',
        ];
        return view('admin.laporan.pemeliharaan_teknisi', $data);
    }
    public function perbaikan_teknisi()
    {
        $data = [
            'title' => 'Laporan perbaikan ',
        ];
        return view('admin.laporan.perbaikan_teknisi', $data);
    }
    public function akhir_teknisi()
    {
        $data = [
            'title' => 'Laporan akhir oleh teknisi',
        ];
        return view('admin.laporan.akhir_teknisi', $data);
    }
    public function getTeknisiDataTable()
    {
        $teknisi = User::where('role', 'Teknisi')->orderByDesc('id');

        return DataTables::of($teknisi)
            ->addColumn('pemeriksaan', function ($teknisi) {
                return Perbaikan::where('id_user', $teknisi->id)->count();
            })
            ->addColumn('perbaikan', function ($teknisi) {
                return PerbaikanSelesai::where('id_user', $teknisi->id)->count();
            })
            ->rawColumns(['pemeriksaan', 'perbaikan'])
            ->make(true);
    }
    public function getPerbaikanTeknisiDataTable()
    {
        $perbaikan = Perbaikan::with(['kerusakan', 'fasilitas'])->where('id_user', Auth::id())->orderByDesc('id');

        return DataTables::of($perbaikan)
            ->make(true);
    }
    public function getAkhirTeknisiDataTable(Request $request)
    {
        $perbaikan = PerbaikanSelesai::with(['kerusakan'])->where('id_user', Auth::id())->orderByDesc('id');
        if ($request->has('date') && !empty($request->date)) {
            $date = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y-m-d');

            $perbaikan->whereDate('created_at', $date);
        }
        return DataTables::of($perbaikan)
            ->addColumn('code', function ($perbaikan) {
                return $perbaikan->kerusakan->fasilitas->code;
            })
            ->rawColumns(['code'])
            ->make(true);
    }
    public function detail_laporan($id)
    {
        $data = Kerusakan::find($id);
        $perbaikan = Perbaikan::with(['fasilitas', 'kerusakan'])->where('id_kerusakan', $id)->first();
        $selesai = PerbaikanSelesai::where('id_kerusakan', $id)->first();
        $pdf = PDF::loadview('admin/laporan/detail_laporan', ['data' => $data, 'perbaikan' => $perbaikan, 'selesai' => $selesai])->setPaper("A4", "portrait");
        return $pdf->stream('laporan_perbaikan_' . date('His') . '.pdf');
    }
    public function print_pemantauan(Request $request)
    {
        $Pemantauan = Pemantauan::with(['user', 'fasilitas']);
        if (Auth::user()->role == 'Teknisi') {
            $Pemantauan->where('id_user', Auth::id());
        }
        $tanggal = 'Semua Tanggal';
        if ($request->has('date') && !empty($request->date)) {
            $date = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y-m-d');

            $Pemantauan->whereDate('created_at', $date);
            $tanggal =  Carbon::createFromFormat('Y-m-d', $request->date)->format('d-m-Y');
        }
        $data =  $Pemantauan->get();

        $pdf = PDF::loadview('admin/laporan/pdf/pemantauan', ['data' => $data, 'tanggal' => $tanggal])->setPaper("A4", "portrait");
        return $pdf->stream('laporan_pemantauan_' . date('His') . '.pdf');
    }
}