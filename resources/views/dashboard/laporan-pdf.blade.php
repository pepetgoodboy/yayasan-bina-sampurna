<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Pembayaran - {{ $periode }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }

        .info-box {
            background: #f5f5f5;
            padding: 10px;
            margin-bottom: 20px;
        }

        .siswa-section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }

        .siswa-header {
            background: #e3f2fd;
            padding: 10px;
            margin-bottom: 15px;
        }

        .pembayaran-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .pembayaran-table th,
        .pembayaran-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .pembayaran-table th {
            background: #f5f5f5;
            font-weight: bold;
        }

        .status-lunas {
            color: #4caf50;
            font-weight: bold;
        }

        .status-cicilan {
            color: #ff9800;
            font-weight: bold;
        }

        .status-belum {
            color: #f44336;
            font-weight: bold;
        }

        .riwayat-table {
            width: 100%;
            border-collapse: collapse;
        }

        .riwayat-table th,
        .riwayat-table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }

        .riwayat-table th {
            background: #f9f9f9;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>YAYASAN BINA SAMPURNA SUTISNA SEJAHTERA</h1>
        <h2>Laporan Pembayaran Siswa</h2>
        <p>Periode: {{ $periode }}</p>
    </div>

    <div class="info-box">
        <strong>Orang Tua:</strong> {{ $user->name }}<br>
        <strong>Email:</strong> {{ $user->email }}<br>
        <strong>Tanggal Cetak:</strong> {{ now()->format('d/m/Y H:i') }}
    </div>

    @foreach ($siswa as $anak)
        <div class="siswa-section">
            <div class="siswa-header">
                <strong>{{ $anak->nama }}</strong> (NIS: {{ $anak->nis }}) - Kelas: {{ $anak->kelas->nama_kelas }}
            </div>

            <h4>Status Pembayaran</h4>
            <table class="pembayaran-table">
                <thead>
                    <tr>
                        <th>Jenis Pembayaran</th>
                        <th>Tipe</th>
                        <th>Total Tagihan</th>
                        <th>Dibayar</th>
                        <th>Sisa</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $jenisPembayaran = \App\Models\JenisPembayaran::all()->filter(function ($jenis) use ($anak) {
                            return $jenis->isApplicableForSiswa($anak);
                        });
                    @endphp
                    @foreach ($jenisPembayaran as $jenis)
                        @php
                            if ($jenis->tipe == 'bulanan') {
                                $totalBayar = $anak
                                    ->pembayaran()
                                    ->where('id_jenis', $jenis->id)
                                    ->whereMonth('tanggal_bayar', $bulan)
                                    ->whereYear('tanggal_bayar', $tahun)
                                    ->sum('jumlah_bayar');
                            } else {
                                $totalBayar = $anak
                                    ->pembayaran()
                                    ->where('id_jenis', $jenis->id)
                                    ->whereYear('tanggal_bayar', $tahun)
                                    ->sum('jumlah_bayar');
                            }

                            $persentase = $jenis->total_tagihan > 0 ? ($totalBayar / $jenis->total_tagihan) * 100 : 0;
                            $sisa = $jenis->total_tagihan - $totalBayar;

                            if ($persentase >= 100) {
                                $status = 'Lunas';
                                $statusClass = 'status-lunas';
                            } elseif ($totalBayar > 0) {
                                $status = 'Cicilan';
                                $statusClass = 'status-cicilan';
                            } else {
                                $status = 'Belum Bayar';
                                $statusClass = 'status-belum';
                            }
                        @endphp
                        <tr>
                            <td>{{ $jenis->nama }}</td>
                            <td>{{ ucfirst($jenis->tipe) }}</td>
                            <td>Rp {{ number_format($jenis->total_tagihan, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($totalBayar, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format(max($sisa, 0), 0, ',', '.') }}</td>
                            <td class="{{ $statusClass }}">{{ $status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h4>Riwayat Pembayaran Periode Ini</h4>
            @php
                $riwayatPeriode = $anak
                    ->pembayaran()
                    ->with('jenisPembayaran')
                    ->where(function ($query) use ($bulan, $tahun) {
                        $query->whereMonth('tanggal_bayar', $bulan)->whereYear('tanggal_bayar', $tahun);
                    })
                    ->orderBy('tanggal_bayar', 'desc')
                    ->get();
            @endphp

            @if ($riwayatPeriode->count() > 0)
                <table class="riwayat-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis Pembayaran</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayatPeriode as $pembayaran)
                            <tr>
                                <td>{{ $pembayaran->tanggal_bayar->format('d/m/Y') }}</td>
                                <td>{{ $pembayaran->jenisPembayaran->nama }}</td>
                                <td>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                                <td>{{ $pembayaran->keterangan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Tidak ada pembayaran di periode ini.</p>
            @endif
        </div>
    @endforeach

    <div class="footer">
        <p>Laporan ini dicetak secara otomatis dari sistem Yayasan Bina Sampurna</p>
    </div>
</body>

</html>
