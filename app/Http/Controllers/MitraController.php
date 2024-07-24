<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Illuminate\Http\Request;

class MitraController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Mitra Perbaikan PJU',
        ];
        return view('admin.mitra.index', $data);
    }
    public function getMItraDataTable()
    {
        $mitra = Mitra::orderByDesc('id');

        return datatables()::of($mitra)
            ->addColumn('action', function ($mitra) {
                return view('admin.mitra.components.actions', compact('mitra'));
            })
            ->addColumn('no_hp', function ($mitra) {
                return '<a href="https://wa.me/' . $mitra->no_hp . '" target="__blank">' . $mitra->no_hp . '</a>';
            })
            ->rawColumns(['action', 'no_hp'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_mitra' => 'required|string|max:255',
            'no_hp' => 'required|string|max:16',
            'email' => 'required|string',
            'alamat' => 'string',
        ]);

        $mitraData = [
            'nama_mitra' => $request->input('nama_mitra'),
            'no_hp' => $request->input('no_hp'),
            'email' => $request->input('email'),
            'alamat' => $request->input('alamat'),
        ];

        if ($request->filled('id')) {
            $Mitra = Mitra::find($request->input('id'));
            if (!$Mitra) {
                return response()->json(['message' => 'Mitra not found'], 404);
            }

            $Mitra->update($mitraData);
            $message = 'Mitra updated successfully';
        } else {
            Mitra::create($mitraData);
            $message = 'Mitra created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function destroy($id)
    {
        $Mitras = Mitra::find($id);

        if (!$Mitras) {
            return response()->json(['message' => 'Mitra not found'], 404);
        }

        $Mitras->delete();

        return response()->json(['message' => 'Mitra deleted successfully']);
    }
    public function edit($id)
    {
        $Mitra = Mitra::find($id);

        if (!$Mitra) {
            return response()->json(['message' => 'Mitra not found'], 404);
        }

        return response()->json($Mitra);
    }
}
