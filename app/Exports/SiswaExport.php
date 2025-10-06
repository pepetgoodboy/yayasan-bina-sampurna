<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class SiswaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $search;
    protected $kelas;
    
    public function __construct($search = null, $kelas = null)
    {
        $this->search = $search;
        $this->kelas = $kelas;
    }
    
    public function collection()
    {
        $query = Siswa::with(['kelas', 'ortu']);
        
        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('nis', 'like', '%' . $this->search . '%')
                  ->orWhereHas('ortu', function($subQ) {
                      $subQ->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }
        
        if ($this->kelas) {
            $query->where('id_kelas', $this->kelas);
        }
        
        return $query->orderBy('nama')->get();
    }
    
    public function headings(): array
    {
        return [
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Jenis Kelamin',
            'Gelombang Pendaftaran',
            'Nama Orang Tua',
            'Email Orang Tua'
        ];
    }
    
    public function map($siswa): array
    {
        return [
            $siswa->nis,
            $siswa->nama,
            $siswa->kelas->nama_kelas,
            $siswa->jenis_kelamin,
            $siswa->gelombang ?? '-',
            $siswa->ortu->name ?? '-',
            $siswa->ortu->email ?? '-'
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        
        // Style untuk header
        $sheet->getStyle('A1:' . $highestColumn . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E5E7EB']
            ],
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

        // Center align untuk semua data
        $sheet->getStyle('A1:' . $highestColumn . $highestRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        return [];
    }
}
