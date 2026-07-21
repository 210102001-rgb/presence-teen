<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<table border="1" style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 11pt;">
    {{-- Title Row --}}
    <tr>
        <td colspan="9" style="background-color: #005f2d; color: #ffffff; font-size: 13pt; font-weight: bold; padding: 10px; text-align: center;">
            DATA SISWA — {{ auth()->user()->name }}
        </td>
    </tr>
    <tr>
        <td colspan="9" style="padding: 4px 10px; color: #555555; font-size: 10pt;">
            Diekspor pada: {{ now()->translatedFormat('d F Y, H:i') }} WIB
        </td>
    </tr>
    <tr><td colspan="9"></td></tr>

    {{-- Header Row --}}
    <tr style="background-color: #0e7a3d; color: #ffffff; font-weight: bold; text-align: center;">
        <td style="padding: 8px 12px;">No</td>
        <td style="padding: 8px 12px;">Nama Siswa</td>
        <td style="padding: 8px 12px;">NIS</td>
        <td style="padding: 8px 12px;">Email</td>
        <td style="padding: 8px 12px;">Kelas</td>
        <td style="padding: 8px 12px;">Mata Pelajaran</td>
        <td style="padding: 8px 12px;">Total Sesi</td>
        <td style="padding: 8px 12px;">Hadir</td>
        <td style="padding: 8px 12px;">Kehadiran (%)</td>
        <td style="padding: 8px 12px;">Status Perangkat</td>
    </tr>

    {{-- Data Rows --}}
    @forelse($rows as $i => $row)
        <tr style="background-color: {{ $i % 2 === 0 ? '#f6fafe' : '#ffffff' }};">
            <td style="padding: 6px 12px; text-align: center;">{{ $i + 1 }}</td>
            <td style="padding: 6px 12px; font-weight: bold;">{{ $row['nama'] }}</td>
            <td style="padding: 6px 12px; text-align: center;">{{ $row['nis'] }}</td>
            <td style="padding: 6px 12px;">{{ $row['email'] }}</td>
            <td style="padding: 6px 12px; text-align: center;">{{ $row['kelas'] }}</td>
            <td style="padding: 6px 12px; text-align: center;">{{ $row['mapel'] }}</td>
            <td style="padding: 6px 12px; text-align: center;">{{ $row['total_sesi'] }}</td>
            <td style="padding: 6px 12px; text-align: center;">{{ $row['hadir'] }}</td>
            <td style="padding: 6px 12px; text-align: center; font-weight: bold;
                color: {{ (int)$row['hadir'] >= $row['total_sesi'] * 0.9 ? '#005f2d' : ((int)$row['hadir'] >= $row['total_sesi'] * 0.75 ? '#b45309' : '#ba1a1a') }};">
                {{ $row['kehadiran'] }}
            </td>
            <td style="padding: 6px 12px; text-align: center;
                color: {{ $row['status'] === 'Aktif' ? '#005f2d' : '#ba1a1a' }}; font-weight: bold;">
                {{ $row['status'] }}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="9" style="padding: 12px; text-align: center; color: #888888;">
                Tidak ada data siswa.
            </td>
        </tr>
    @endforelse

    {{-- Summary Row --}}
    <tr>
        <td colspan="9" style="padding: 4px;"></td>
    </tr>
    <tr style="background-color: #eaeef2; font-weight: bold;">
        <td colspan="2" style="padding: 6px 12px;">Total Siswa</td>
        <td style="padding: 6px 12px; text-align: center;">{{ $rows->count() }}</td>
        <td colspan="7"></td>
    </tr>

    {{-- Per Kelas Summary --}}
    <tr><td colspan="9" style="padding: 6px;"></td></tr>
    <tr style="background-color: #0e7a3d; color: #ffffff; font-weight: bold;">
        <td colspan="9" style="padding: 8px 12px;">RINGKASAN PER KELAS</td>
    </tr>
    <tr style="background-color: #f0fdf4; font-weight: bold;">
        <td style="padding: 6px 12px;">No</td>
        <td colspan="2" style="padding: 6px 12px;">Nama Kelas</td>
        <td colspan="2" style="padding: 6px 12px;">Mata Pelajaran</td>
        <td colspan="2" style="padding: 6px 12px;">Tahun Ajaran</td>
        <td colspan="2" style="padding: 6px 12px; text-align: center;">Jumlah Siswa</td>
    </tr>
    @foreach($kelas as $i => $k)
        <tr style="background-color: {{ $i % 2 === 0 ? '#f6fafe' : '#ffffff' }};">
            <td style="padding: 6px 12px; text-align: center;">{{ $i + 1 }}</td>
            <td colspan="2" style="padding: 6px 12px; font-weight: bold;">{{ $k->nama_kelas }}</td>
            <td colspan="2" style="padding: 6px 12px;">{{ $k->mata_pelajaran }}</td>
            <td colspan="2" style="padding: 6px 12px;">{{ $k->tahun_ajaran ?? '-' }}</td>
            <td colspan="2" style="padding: 6px 12px; text-align: center; font-weight: bold; color: #005f2d;">
                {{ $k->siswa->count() }}
            </td>
        </tr>
    @endforeach
</table>
</body>
</html>
