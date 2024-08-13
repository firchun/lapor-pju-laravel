<?php

namespace App\Http\Controllers;

use App\Models\AlatPerbaikan;
use App\Models\BoxControl;
use App\Models\Fasilitas;
use App\Models\Kerusakan;
use App\Models\Perbaikan;
use App\Models\PerbaikanMitra;
use App\Models\PerbaikanSelesai;
use Carbon\Carbon;
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
    public function input()
    {
        $data = [
            'title' => 'Tambah pekerjaan Perbaikan PJU',

        ];
        return view('admin.kerusakan.input', $data);
    }
    public function updateStatus()
    {
        $data = [
            'title' => 'Update pekerjaan',
        ];
        return view('admin.kerusakan.update_status', $data);
    }
    public function show($id)
    {
        $kerusakan = Kerusakan::find($id);
        $data = [
            'title' => 'Detail Laporan',
            'kerusakan' => $kerusakan,
        ];
        return view('admin.kerusakan.detail', $data);
    }
    public function store(Request $request)
    {
        // Validasi input jika diperlukan
        $request->validate([
            'foto_pelapor' => 'image', // contoh validasi untuk foto
            'foto_kerusakan_1' => 'image',
            'foto_kerusakan_2' => 'image',
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

        if ($request->has('id_user')) {

            $kerusakan->id_user = $request->id_user;
            $kerusakan->is_verified = 1;
            $kerusakan->Status = 'Verified';
        }

        // Simpan foto-foto ke dalam storage dan dapatkan path-nya
        if ($request->has('foto_pelapor')) {
            $foto_pelapor_path = $request->file('foto_pelapor')->storeAs('public/kerusakan', 'foto_pelapor_' . now()->timestamp . '.' . $request->file('foto_pelapor')->extension());
        }
        if ($request->has('foto_kerusakan_1')) {
            $foto_kerusakan_1_path = $request->file('foto_kerusakan_1')->storeAs('public/kerusakan', 'foto_kerusakan_1_' . now()->timestamp . '.' . $request->file('foto_kerusakan_1')->extension());
        }
        if ($request->has('foto_kerusakan_2')) {
            $foto_kerusakan_2_path = $request->file('foto_kerusakan_2')->storeAs('public/kerusakan', 'foto_kerusakan_2_' . now()->timestamp . '.' . $request->file('foto_kerusakan_2')->extension());
        }

        // Ubah path menjadi URL publik jika perlu, menggunakan asset() atau Storage::url()

        $kerusakan->foto_pelapor = $foto_pelapor_path ?? null;
        $kerusakan->foto_kerusakan_1 = $foto_kerusakan_1_path ?? null;
        $kerusakan->foto_kerusakan_2 = $foto_kerusakan_2_path ?? null;

        // Simpan data ke dalam database

        $cek_laporan = Kerusakan::where('id_fasilitas', $request->id_fasilitas)->whereBetween('status', ['Pending', 'Verified', 'Repair'])->count();

        if ($cek_laporan > 0) {
            session()->flash('danger', 'Terimakasih telah melapor, Fasilitas ini telah telah dilaporkan oleh orang lain');
            if (auth()->check()) {
                return redirect()->back();
            } else {
                return redirect()->to('/laporan_user');
            }
        } else {
            $kerusakan->save();
            session()->flash('success', 'Terimakasih telah melapor, Laporan telah berhasil dikirim');
            if (auth()->check()) {
                return redirect()->back();
            } else {
                return redirect()->to('/laporan_user');
            }
        }
        // Redirect atau kembali ke halaman yang sesuai dengan logika aplikasi Anda
    }
    public function update(Request $request)
    {
        $code = $request->input('code');
        $angkadepan = substr($code, 0, 3);
        if ($angkadepan == 'PJU') {
            $fasilitas = Fasilitas::where('code', $code)->first();
        } else {
            $box = BoxControl::where('code', $code)->first();
        }
        if ($angkadepan == 'BOX') {
            if (!$box) {
                session()->flash('danger', 'Box not found');
                return redirect()->to('/kerusakan/update-status');
            } else {
                return view('admin.box_control.update_pemeliharaan', ['box' => $box]);
            }
        }

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
        // if ($cek_finished != 0) {
        //     session()->flash('danger', 'laporan ini telah selesai');
        //     return redirect()->to('/kerusakan/update-status');
        // }
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
            if ($request->has('id_mitra')) {
                $mitra = new PerbaikanMitra();
                $mitra->id_mitra = $request->input('id_mitra');
                $mitra->id_kerusakan = $request->input('id_kerusakan');
                $mitra->biaya = $request->input('biaya');
                $mitra->save();
            }
            if ($request->has('nama_alat')) {
                $alats = $request->input('nama_alat');

                // Simpan data ke database
                foreach ($alats as $alat) {
                    $alatPerbaikan = new AlatPerbaikan();
                    $alatPerbaikan->id_kerusakan = $request->input('id_kerusakan');
                    $alatPerbaikan->id_perbaikan = $perbaikan->id;
                    $alatPerbaikan->nama_alat = $alat;
                    $alatPerbaikan->jumlah = $request->input('jumlah')[$alat];
                    $alatPerbaikan->save();
                }
            }
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

    public function getKerusakanDataTable(Request $request)
    {
        $Kerusakan = Kerusakan::with(['fasilitas'])->orderByDesc('id');
        if ($request->has('date') && !empty($request->date)) {
            $date = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y-m-d');

            $Kerusakan->whereDate('created_at', $date);
        }
        return DataTables::of($Kerusakan)
            ->addColumn('action', function ($Kerusakan) {
                return view('admin.kerusakan.components.actions', compact('Kerusakan'));
            })
            ->addColumn('jenis_laporan', function ($Kerusakan) {
                $jenis_pelapor = $Kerusakan->id_user ? 'badge badge-warning' : 'badge badge-success';
                $jenis = $Kerusakan->id_user ? 'Teknisi' : 'Masyarakat';
                return '<span class="' . $jenis_pelapor . '">' . $jenis . '</span>';
            })
            ->addColumn('pelapor', function ($Kerusakan) {

                return '<strong>' . $Kerusakan->nama_pelapor . '</strong><br><a target="__blank" href="https://wa.me/' . $Kerusakan->no_hp_pelapor . '">' . $Kerusakan->no_hp_pelapor . '</a>';
            })
            ->addColumn('lihat_laporan', function ($Kerusakan) {
                return '<a href="' . url('/laporan/detail-laporan', $Kerusakan->id) . '" target="__blank" class="btn btn-primary">Lihat Laporan</a>';
            })
            ->rawColumns(['action', 'pelapor', 'lihat_laporan', 'jenis_laporan'])
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
