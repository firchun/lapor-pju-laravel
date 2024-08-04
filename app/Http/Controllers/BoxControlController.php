<?php

namespace App\Http\Controllers;

use App\Models\BoxControl;
use App\Models\Pemeliharaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use PDF;
use QrCode;

class BoxControlController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Box Control'
        ];
        return view('admin.box_control.index', $data);
    }
    public function getBoxControlDataTable()
    {
        $customers = BoxControl::orderByDesc('id');

        return DataTables::of($customers)
            ->addColumn('action', function ($customer) {
                return view('admin.box_control.components.actions', compact('customer'));
            })
            ->addColumn('foto', function ($customer) {
                return '<a href="' . Storage::url($customer->foto) . '" target="__blank"><img src="' . Storage::url($customer->foto) . '" alt="box" style="width:100px;height:100px;object-fit:cover;"></a>';
            })

            ->rawColumns(['action', 'foto'])
            ->make(true);
    }
    public function getPemeliharaanDataTable()
    {
        $customers = Pemeliharaan::with(['box_control', 'user'])->orderByDesc('id');
        if (Auth::user()->role == 'Teknisi') {
            $customers = $customers->where('id_user', Auth::id());
        }
        return DataTables::of($customers)

            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tempat' => 'required|string',
            'foto' => 'image',
        ]);
        $code = 'BOX-' . date('ymdhis');
        if ($request->has('foto')) {
            $foto_path = $request->file('foto')->storeAs('public/box', 'foto_' . now()->timestamp . '.' . $request->file('foto')->extension());
        }
        $customerData = [
            'code' => $code,
            'foto' => $foto_path ?? null,
            'nama' => $request->input('nama'),
            'tempat' => $request->input('tempat'),
        ];

        if ($request->filled('id')) {
            $customer = BoxControl::find($request->input('id'));
            if (!$customer) {
                return response()->json(['message' => 'box not found'], 404);
            }

            $customer->update($customerData);
            $message = 'box updated successfully';
        } else {
            BoxControl::create($customerData);
            $message = 'box created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function store_pemeliharaan(Request $request)
    {
        $request->validate([
            'id_box_control' => 'required|string|max:255',
            'keterangan.*' => 'required|string',
        ]);

        $keteranganArray = $request->input('keterangan');
        $idBoxControl = $request->input('id_box_control');

        foreach ($keteranganArray as $keterangan) {
            Pemeliharaan::create([
                'id_box_control' => $idBoxControl,
                'id_user' => Auth::id(),
                'keterangan' => $keterangan,
            ]);
        }

        session()->flash('success', 'Berhasil update pemeliharaan box control');
        return redirect()->to('kerusakan/update-status');
    }
    public function destroy($id)
    {
        $customers = BoxControl::find($id);
        $pemeliharaan = Pemeliharaan::where('id_box_control', $customers->id);
        $pemeliharaan->delete();

        if (!$customers) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $customers->delete();

        return response()->json(['message' => 'Customer deleted successfully']);
    }
    public function edit($id)
    {
        $customer = BoxControl::find($id);

        if (!$customer) {
            return response()->json(['message' => 'customer not found'], 404);
        }

        return response()->json($customer);
    }
    public function print($id)
    {
        $data = BoxControl::find($id);
        $qr = base64_encode(QrCode::format('svg')->size(80)->errorCorrection('H')->generate($data->code));
        $pdf = PDF::loadview('admin/box_control/print', ['data' => $data, 'qr' => $qr])->setPaper("A4", "portrait");
        return $pdf->stream('box_control_' . $data->code . '.pdf');
    }
}
