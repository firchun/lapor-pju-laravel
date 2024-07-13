<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Kerusakan;
use App\Models\Perbaikan;
use App\Models\PerbaikanSelesai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class KerusakanController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Laporan Masyarakat Kerusakan PJU',
            'pending' => Kerusakan::where('status', 'Pending')->count(),
            'verified' => Kerusakan::where('status', 'Verified')->count(),
            'Repair' => Kerusakan::where('status', 'Repair')->count(),
            'finished' => Kerusakan::where('status', 'Finished')->count(),
        ];
        return view('admin.kerusakan.index', $data);
    }
    public function updateStatus()
    {
        $data = [
            'title' => 'Update pekerjaan',
        ];
        return view('admin.kerusakan.update_status', $data);
    }
    public function store(Request $request)
    {
        // Validasi input jika diperlukan
        $request->validate([
            'foto_pelapor' => 'required|image', // contoh validasi untuk foto
            'foto_kerusakan_1' => 'required|image',
            'foto_kerusakan_2' => 'required|image',
            'nama_pelapor' => 'required|string|max:255',
            'no_hp_pelapor' => 'required|string|max:20',
            'keterangan' => 'required|string',
        ]);

        // Simpan data ke dalam database
        $kerusakan = new Kerusakan();
        $kerusakan->id_fasilitas = $request->id_fasilitas;
        $kerusakan->nama_pelapor = $request->nama_pelapor;
        $kerusakan->no_hp_pelapor = $request->no_hp_pelapor;
        $kerusakan->keterangan = $request->keterangan;

        // Simpan foto-foto ke dalam storage dan dapatkan path-nya
        $foto_pelapor_path = $request->file('foto_pelapor')->storeAs('public/kerusakan', 'foto_pelapor_' . now()->timestamp . '.' . $request->file('foto_pelapor')->extension());
        $foto_kerusakan_1_path = $request->file('foto_kerusakan_1')->storeAs('public/kerusakan', 'foto_kerusakan_1_' . now()->timestamp . '.' . $request->file('foto_kerusakan_1')->extension());
        $foto_kerusakan_2_path = $request->file('foto_kerusakan_2')->storeAs('public/kerusakan', 'foto_kerusakan_2_' . now()->timestamp . '.' . $request->file('foto_kerusakan_2')->extension());

        // Ubah path menjadi URL publik jika perlu, menggunakan asset() atau Storage::url()

        $kerusakan->foto_pelapor = $foto_pelapor_path;
        $kerusakan->foto_kerusakan_1 = $foto_kerusakan_1_path;
        $kerusakan->foto_kerusakan_2 = $foto_kerusakan_2_path;

        // Simpan data ke dalam database
        $kerusakan->save();

        // Redirect atau kembali ke halaman yang sesuai dengan logika aplikasi Anda
        session()->flash('success', 'Terimakasih telah melapor, Laporan telah berhasil dikirim');
        return redirect()->to('/laporan_user');
    }
    public function update(Request $request)
    {
        $code = $request->input('code');
        $fasilitas = Fasilitas::where('code', $code)->first();
        if (!$fasilitas) {
            session()->flash('danger', 'Fasilitas not found');
            return redirect()->to('/kerusakan/update-status');
        }
        $cek_laporan = Kerusakan::where('id_fasilitas', $fasilitas->id)->count();
        $cek_finished = Kerusakan::where('id_fasilitas', $fasilitas->id)->where('status', 'Finished')->count();
        $cek_verified = Kerusakan::where('id_fasilitas', $fasilitas->id)->whereIn('status', ['Verified', 'Repair'])->count();

        if ($cek_laporan == 0) {
            session()->flash('danger', 'Tidak ada laporan pada fasilitas ini');
            return redirect()->to('/kerusakan/update-status');
        }
        if ($cek_finished != 0) {
            session()->flash('danger', 'laporan ini telah selesai');
            return redirect()->to('/kerusakan/update-status');
        }
        if ($cek_verified == 0) {
            session()->flash('danger', 'laporan belum di verifikasi');
            return redirect()->to('/kerusakan/update-status');
        }
        // return redirect()->back();
        $Kerusakan = Kerusakan::where('id_fasilitas', $fasilitas->id)->first();
        if ($Kerusakan->status == 'Verified') {
            return view('admin.kerusakan.update_kerusakan', ['kerusakan' => $Kerusakan]);
        } else {
            return view('admin.kerusakan.update_selesai', ['kerusakan' => $Kerusakan]);
        }
    }
    public function perbaikan(Request $request)
    {
        $request->validate([
            'id_fasilitas' => 'required', // contoh validasi untuk foto
            'id_kerusakan' => 'required', // contoh validasi untuk foto
            'alat_diganti' => 'required', // contoh validasi untuk foto
            'keterangan' => 'required', // contoh validasi untuk foto
            'jenis_kerusakan' => 'required', // contoh validasi untuk foto
        ]);
        $perbaikan = new Perbaikan();
        $perbaikan->id_user = Auth::id();
        $perbaikan->id_fasilitas = $request->input('id_fasilitas');
        $perbaikan->id_kerusakan = $request->input('id_kerusakan');
        $perbaikan->alat_diganti = $request->input('alat_diganti');
        $perbaikan->keterangan = $request->input('keterangan');
        $perbaikan->jenis_kerusakan = $request->input('jenis_kerusakan');

        $kerusakan = Kerusakan::find($request->input('id_kerusakan'));
        $kerusakan->status = 'Repair';
        if ($kerusakan->save() && $perbaikan->save()) {
            session()->flash('success', 'berhasil update perbaikan');
            return redirect()->to('/kerusakan/update-status');
        } else {
            return back()->withInput($request->all());
        }
    }
    public function selesai(Request $request)
    {
        $request->validate([
            'foto_sebelum' => 'required|image',
            'foto_proses' => 'required|image',
            'foto_selesai' => 'required|image',
            'keterangan' => 'required', // contoh validasi untuk foto

        ]);
        $selesai = new PerbaikanSelesai();
        $selesai->id_user = Auth::id();
        $selesai->id_kerusakan = $request->input('id_kerusakan');
        $selesai->keterangan = $request->input('keterangan');
        //simpan foto
        $foto_sebelum_path = $request->file('foto_sebelum')->storeAs('public/laporan', 'foto_sebelum_' . now()->timestamp . '.' . $request->file('foto_sebelum')->extension());
        $foto_proses_path = $request->file('foto_proses')->storeAs('public/laporan', 'foto_proses_' . now()->timestamp . '.' . $request->file('foto_proses')->extension());
        $foto_selesai_path = $request->file('foto_selesai')->storeAs('public/laporan', 'foto_selesai_' . now()->timestamp . '.' . $request->file('foto_selesai')->extension());
        //update path
        $selesai->foto_sebelum = $foto_sebelum_path;
        $selesai->foto_proses = $foto_proses_path;
        $selesai->foto_selesai = $foto_selesai_path;
        //update status
        $kerusakan = Kerusakan::find($request->input('id_kerusakan'));
        $kerusakan->status = 'Finished';
        if ($kerusakan->save() && $selesai->save()) {
            session()->flash('success', 'berhasil update perbaikan');
            return redirect()->to('/kerusakan/update-status');
        } else {
            return back()->withInput($request->all());
        }
    }

    public function getKerusakanDataTable()
    {
        $Kerusakan = Kerusakan::with(['fasilitas'])->orderByDesc('id');

        return DataTables::of($Kerusakan)
            ->addColumn('action', function ($Kerusakan) {
                return view('admin.kerusakan.components.actions', compact('Kerusakan'));
            })
            ->addColumn('pelapor', function ($Kerusakan) {
                return '<strong>' . $Kerusakan->nama_pelapor . '</strong><br><a target="__blank" href="https://wa.me/' . $Kerusakan->no_hp_pelapor . '">' . $Kerusakan->no_hp_pelapor . '</a>';
            })
            ->addColumn('lihat_laporan', function ($Kerusakan) {
                return '<a href="' . url('/laporan/detail-laporan', $Kerusakan->id) . '" target="__blank" class="btn btn-primary">Lihat Laporan</a>';
            })
            ->rawColumns(['action', 'pelapor', 'lihat_laporan'])
            ->make(true);
    }
    public function terima($id)
    {
        $kerusakan = Kerusakan::find($id);
        $kerusakan->is_verified = 1;
        $kerusakan->status = 'Verified';
        $kerusakan->save();

        return back();
    }
    public function tolak($id)
    {
        $kerusakan = Kerusakan::find($id);
        $kerusakan->is_verified = 2;
        $kerusakan->status = 'Reject';
        $kerusakan->save();

        return back();
    }
    public function destroy($id)
    {
        $Kerusakan = Kerusakan::find($id);

        if (!$Kerusakan) {
            return response()->json(['message' => 'Kerusakan not found'], 404);
        }

        $Kerusakan->delete();

        return response()->json(['message' => 'Kerusakan deleted successfully']);
    }
    public function edit($id)
    {
        $Kerusakan = Kerusakan::find($id);

        if (!$Kerusakan) {
            return response()->json(['message' => 'Kerusakan not found'], 404);
        }

        return response()->json($Kerusakan);
    }
}
