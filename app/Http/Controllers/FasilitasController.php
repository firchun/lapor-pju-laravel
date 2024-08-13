<?php

namespace App\Http\Controllers;

use App\Models\AlatPerbaikan;
use App\Models\Fasilitas;
use App\Models\Kerusakan;
use App\Models\Perbaikan;
use App\Models\PerbaikanMitra;
use App\Models\PerbaikanSelesai;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Storage;
use PDF;
use QrCode;

class FasilitasController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Fasilitas Penerangan Jalan Umum',
        ];
        return view('admin.fasilitas.index', $data);
    }
    public function getall()
    {
        $data = Fasilitas::all();
        return response()->json($data);
    }
    public function getFasilitasDataTable()
    {
        $Fasilitas = Fasilitas::orderByDesc('id');

        return DataTables::of($Fasilitas)
            ->addColumn('action', function ($Fasilitas) {
                return view('admin.fasilitas.components.actions', compact('Fasilitas'));
            })
            ->addColumn('koordinat', function ($Fasilitas) {
                $url = 'https://www.google.com/maps?q=' . $Fasilitas->latitude . ',' . $Fasilitas->longitude;
                return '<a href="' . $url . '" target="__blank">' . $Fasilitas->latitude . ' , ' . $Fasilitas->longitude . '</a>';
            })
            ->addColumn('foto', function ($Fasilitas) {
                return '<a href="' . Storage::url($Fasilitas->foto) . '" target="__blank"><img src="' . Storage::url($Fasilitas->foto) . '" style="height:50px;width:50px;object-fit:cover;"><a/>';
            })
            ->rawColumns(['action', 'koordinat', 'foto'])
            ->make(true);
    }
    public function store(Request $request)
    {

        $request->validate([
            'id_pelanggan_pln' => 'required|string|max:255',
            'tarip' => 'required|string|max:255',
            'daya' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'latitude' => 'required|string|max:255',
            'longitude' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ]);
        if (!$request->filled('alamat')) {
            return response()->json(['message' => 'Alamat tidak boleh kosong'], 400);
        }
        if (!$request->filled('latitude') || !$request->filled('longitude')) {
            return response()->json(['message' => 'Koordinat tidak boleh kosong'], 400);
        }
        $code = 'PJU-' . date('ymdhis');
        // URL QR Code
        $qrcodeUrl = url("/lapor-kerusakan/$code");

        $fasilitasData = [
            'code' =>  $code,
            // 'qrcode' => $qrcodeUrl,
            'id_pelanggan_pln' => $request->input('id_pelanggan_pln'),
            'tarip' => $request->input('tarip'),
            'daya' => $request->input('daya'),
            'nama' => $request->input('nama'),
            'alamat' => $request->input('alamat'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
        ];
        $fasilitasData['qrcode'] = $qrcodeUrl;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('public/photos', $fileName);
            $fasilitasData['foto'] = $filePath;
        }

        if ($request->filled('id')) {
            $Fasilitas = Fasilitas::find($request->input('id'));
            if (!$Fasilitas) {
                return response()->json(['message' => 'Fasilitas not found'], 404);
            }

            $Fasilitas->update($fasilitasData);
            $message = 'Fasilitas updated successfully';
        } else {
            Fasilitas::create($fasilitasData);
            $message = 'Fasilitas created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function update(Request $request)
    {
        $request->validate([
            'id_pelanggan_pln' => 'required|string|max:255',
            'tarip' => 'required|string|max:255',
            'daya' => 'required|string|max:255',
            'id_fasilitas' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'alamat' => 'required|string|max:255',
        ]);
        $Fasilitas = Fasilitas::find($request->input('id_fasilitas'));
        $fasilitasData = [
            // 'qrcode' => $qrcodeUrl,
            'id_pelanggan_pln' => $request->input('id_pelanggan_pln'),
            'tarip' => $request->input('tarip'),
            'daya' => $request->input('daya'),
            'nama' => $request->input('nama'),
            'alamat' => $request->input('alamat'),
            'latitude' => $request->input('latitude') ?? $Fasilitas->latitude,
            'longitude' => $request->input('longitude') ?? $Fasilitas->longitude,
        ];
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('public/photos', $fileName);
            $fasilitasData['foto'] = $filePath;
        }

        if (!$Fasilitas) {
            return response()->json(['message' => 'Fasilitas not found'], 404);
        }

        $Fasilitas->update($fasilitasData);
        $message = 'Fasilitas updated successfully';
        return response()->json(['message' => $message]);
    }
    public function destroy($id)
    {
        // Temukan fasilitas berdasarkan ID
        $fasilitas = Fasilitas::find($id);

        // Jika fasilitas tidak ditemukan, kembalikan response 404
        if (!$fasilitas) {
            return response()->json(['message' => 'Fasilitas not found'], 404);
        }

        // Hapus semua perbaikan yang terkait dengan fasilitas
        Perbaikan::where('id_fasilitas', $fasilitas->id)->delete();

        // Hapus semua kerusakan yang terkait dengan fasilitas
        $kerusakan = Kerusakan::where('id_fasilitas', $fasilitas->id)->get();
        foreach ($kerusakan as $k) {
            // Hapus semua perbaikan selesai terkait dengan kerusakan
            PerbaikanSelesai::where('id_kerusakan', $k->id)->delete();

            // Hapus semua perbaikan mitra terkait dengan kerusakan
            PerbaikanMitra::where('id_kerusakan', $k->id)->delete();

            // Hapus semua alat perbaikan terkait dengan kerusakan
            AlatPerbaikan::where('id_kerusakan', $k->id)->delete();
        }

        // Hapus semua kerusakan yang terkait dengan fasilitas
        Kerusakan::where('id_fasilitas', $fasilitas->id)->delete();

        // Hapus fasilitas itu sendiri
        $fasilitas->delete();

        // Kembalikan response sukses
        return response()->json(['message' => 'Fasilitas deleted successfully']);
    }

    public function edit($id)
    {
        $Fasilitas = Fasilitas::find($id);

        if (!$Fasilitas) {
            return response()->json(['message' => 'Fasilitas not found'], 404);
        }

        return response()->json($Fasilitas);
    }
    public function print($id)
    {
        $data = Fasilitas::find($id);
        $qr = base64_encode(QrCode::format('svg')->size(80)->errorCorrection('H')->generate($data->qrcode));
        $pdf = PDF::loadview('admin/fasilitas/print', ['data' => $data, 'qr' => $qr])->setPaper("A4", "portrait");
        return $pdf->stream('fasilitas_' . $data->code . '.pdf');
    }
}
