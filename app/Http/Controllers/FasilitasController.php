<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FasilitasController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Fasilitas Penerangan Jalan Umum',
        ];
        return view('admin.fasilitas.index', $data);
    }
    public function getFasilitasDataTable()
    {
        $Fasilitas = Fasilitas::select(['id', 'name', 'phone', 'address', 'created_at', 'updated_at'])->orderByDesc('id');

        return DataTables::of($Fasilitas)
            ->addColumn('action', function ($Fasilitas) {
                return view('admin.fasilitas.components.actions', compact('Fasilitas'));
            })
            ->addColumn('phone', function ($Fasilitas) {
                return '<a href="https://wa.me/' . $Fasilitas->phone . '" target="__blank">' . $Fasilitas->phone . '</a>';
            })
            ->rawColumns(['action', 'phone'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $fasilitasData = [
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
        ];

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
}
