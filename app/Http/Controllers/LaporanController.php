<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\JenisPembayaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanKeuanganExport;

class LaporanController extends Controller
{
    public function index()
    {
        $tanggalMulai = request('tanggal_mulai', now()->startOfMonth()->format('Y-m-d'));
        $tanggalSelesai = request('tanggal_selesai', now()->endOfMonth()->format('Y-m-d'));
        $kelasId = request('kelas_id');
        $jenisId = request('jenis_id');
        
        $query = Pembayaran::with(['siswa.kelas', 'jenisPembayaran'])
            ->whereBetween('tanggal_bayar', [$tanggalMulai, $tanggalSelesai]);
        
        if ($kelasId) {
            $query->whereHas('siswa', function($q) use ($kelasId) {
                $q->where('id_kelas', $kelasId);
            });
        }
        
        if ($jenisId) {
            $query->where('id_jenis', $jenisId);
        }
        
        $pembayaran = $query->orderBy('tanggal_bayar', 'desc')->get();
        $totalPemasukan = $pembayaran->sum('jumlah_bayar');
        
        $kelas = Kelas::all();
        $jenisPembayaran = JenisPembayaran::all();
        
        return view('laporan.index', compact(
            'pembayaran', 'totalPemasukan', 'kelas', 'jenisPembayaran',
            'tanggalMulai', 'tanggalSelesai', 'kelasId', 'jenisId'
        ));
    }
    
    public function exportPDF()
    {
        $tanggalMulai = request('tanggal_mulai', now()->startOfMonth()->format('Y-m-d'));
        $tanggalSelesai = request('tanggal_selesai', now()->endOfMonth()->format('Y-m-d'));
        $kelasId = request('kelas_id');
        $jenisId = request('jenis_id');
        
        $query = Pembayaran::with(['siswa.kelas', 'jenisPembayaran'])
            ->whereBetween('tanggal_bayar', [$tanggalMulai, $tanggalSelesai]);
        
        if ($kelasId) {
            $query->whereHas('siswa', function($q) use ($kelasId) {
                $q->where('id_kelas', $kelasId);
            });
        }
        
        if ($jenisId) {
            $query->where('id_jenis', $jenisId);
        }
        
        $pembayaran = $query->orderBy('tanggal_bayar', 'desc')->get();
        $totalPemasukan = $pembayaran->sum('jumlah_bayar');
        
        $data = [
            'pembayaran' => $pembayaran,
            'totalPemasukan' => $totalPemasukan,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'kelas' => $kelasId ? Kelas::find($kelasId)->nama_kelas : 'Semua Kelas',
            'jenis' => $jenisId ? JenisPembayaran::find($jenisId)->nama : 'Semua Jenis'
        ];
        
        $pdf = Pdf::loadView('laporan.pdf', $data);
        
        return $pdf->download('Laporan-Keuangan-' . $tanggalMulai . '-' . $tanggalSelesai . '.pdf');
    }
    
    public function exportExcel()
    {
        $tanggalMulai = request('tanggal_mulai', now()->startOfMonth()->format('Y-m-d'));
        $tanggalSelesai = request('tanggal_selesai', now()->endOfMonth()->format('Y-m-d'));
        $kelasId = request('kelas_id');
        $jenisId = request('jenis_id');
        
        return Excel::download(
            new LaporanKeuanganExport($tanggalMulai, $tanggalSelesai, $kelasId, $jenisId),
            'Laporan-Keuangan-' . $tanggalMulai . '-' . $tanggalSelesai . '.xlsx'
        );
    }
}
