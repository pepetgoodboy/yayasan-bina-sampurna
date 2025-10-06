<?php

namespace App\Exports;

use App\Models\Pembayaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;

class LaporanKeuanganExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $tanggalMulai;
    protected $tanggalSelesai;
    protected $kelasId;
    protected $jenisId;
    
    public function __construct($tanggalMulai, $tanggalSelesai, $kelasId = null, $jenisId = null)
    {
        $this->tanggalMulai = $tanggalMulai;
        $this->tanggalSelesai = $tanggalSelesai;
        $this->kelasId = $kelasId;
        $this->jenisId = $jenisId;
    }
    
    public function collection()
    {
        $query = Pembayaran::with(['siswa.kelas', 'jenisPembayaran'])
            ->whereBetween('tanggal_bayar', [$this->tanggalMulai, $this->tanggalSelesai]);
        
        if ($this->kelasId) {
            $query->whereHas('siswa', function($q) {
                $q->where('id_kelas', $this->kelasId);
            });
        }
        
        if ($this->jenisId) {
            $query->where('id_jenis', $this->jenisId);
        }
        
        return $query->orderBy('tanggal_bayar', 'desc')->get();
    }
    
    public function headings(): array
    {
        return [
            'Tanggal',
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Jenis Pembayaran',
            'Jumlah Bayar',
            'Keterangan'
        ];
    }
    
    public function map($pembayaran): array
    {
        return [
            $pembayaran->tanggal_bayar->format('d/m/Y'),
            $pembayaran->siswa->nis,
            $pembayaran->siswa->nama,
            $pembayaran->siswa->kelas->nama_kelas,
            $pembayaran->jenisPembayaran->nama,
            $pembayaran->jumlah_bayar,
            $pembayaran->keterangan ?? '-'
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        
        // Style untuk header (baris 1)
        $sheet->getStyle('A1:' . $highestColumn . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E5E7EB']
            ]
        ]);
        
        // Border untuk semua data
        $sheet->getStyle('A1:' . $highestColumn . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);
        
        // Format currency untuk kolom jumlah bayar (kolom F)
        $sheet->getStyle('F2:F' . $highestRow)->getNumberFormat()
            ->setFormatCode('#,##0');
            
        return [];
    }
}
