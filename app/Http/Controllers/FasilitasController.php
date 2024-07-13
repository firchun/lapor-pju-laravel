<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
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
                return '<a href="' . $url . '" target="__blank">' . $Fasilitas->latitude . ',' . $Fasilitas->longitude . '</a>';
            })
            ->addColumn('foto', function ($Fasilitas) {
                return '<img src="' . Storage::url($Fasilitas->foto) . '" style="height:50px;width:50px;object-fit:cover;">';
            })
            ->rawColumns(['action', 'koordinat', 'foto'])
            ->make(true);
    }
    public function store(Request $request)
    {

        $request->validate([
            'alamat' => 'required|string|max:255',
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
            'id_fasilitas' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ]);
        $Fasilitas = Fasilitas::find($request->input('id_fasilitas'));
        $fasilitasData = [
            // 'qrcode' => $qrcodeUrl,
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
        $Fasilitas = Fasilitas::find($id);

        if (!$Fasilitas) {
            return response()->json(['message' => 'Fasilitas not found'], 404);
        }

        $Fasilitas->delete();

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
