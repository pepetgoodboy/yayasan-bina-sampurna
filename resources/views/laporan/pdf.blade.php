<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header h2 { margin: 5px 0; font-size: 14px; color: #666; }
        .info-box { background: #f5f5f5; padding: 15px; margin-bottom: 20px; }
        .summary-box { background: #e8f5e8; padding: 15px; margin-bottom: 20px; text-align: center; }
        .summary-box .total { font-size: 24px; font-weight: bold; color: #2d5016; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background: #f5f5f5; font-weight: bold; }
        .table tr:nth-child(even) { background: #f9f9f9; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #666; }
        .text-right { text-align: right; }
        .text-green { color: #16a34a; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>YAYASAN BINA SAMPURNA</h1>
        <h2>Laporan Keuangan</h2>
    </div>

    <div class="info-box">
        <strong>Periode:</strong> {{ date('d/m/Y', strtotime($tanggalMulai)) }} - {{ date('d/m/Y', strtotime($tanggalSelesai)) }}<br>
        <strong>Kelas:</strong> {{ $kelas }}<br>
        <strong>Jenis Pembayaran:</strong> {{ $jenis }}<br>
        <strong>Tanggal Cetak:</strong> {{ now()->format('d/m/Y H:i') }}
    </div>

    <div class="summary-box">
        <div>Total Pemasukan</div>
        <div class="total">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jenis Pembayaran</th>
                <th>Jumlah Bayar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembayaran as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->tanggal_bayar->format('d/m/Y') }}</td>
                    <td>{{ $item->siswa->nis }}</td>
                    <td>{{ $item->siswa->nama }}</td>
                    <td>{{ $item->siswa->kelas->nama_kelas }}</td>
                    <td>{{ $item->jenisPembayaran->nama }}</td>
                    <td class="text-right text-green">Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #666;">Tidak ada data pembayaran</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="background: #f0f0f0; font-weight: bold;">
                <td colspan="6" class="text-right">TOTAL:</td>
                <td class="text-right text-green">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Laporan ini dicetak secara otomatis dari sistem Yayasan Bina Sampurna</p>
    </div>
</body>
</html>