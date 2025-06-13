<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Ujian - {{ $examPackage->title }}</title>
    <style>
        @page {
            size: A5 landscape;
            margin: 5mm;
        }
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            font-size: 9pt;
            background-color: #fff;
        }
        .page-break {
            page-break-after: always;
        }
        .exam-card-container {
            width: calc(100% - 2mm);
            height: calc(95% - 2mm);
            padding: 1mm;
            position: relative;
            box-sizing: border-box;
            border: 2px solid #000;
            margin: 0 auto;
        }
        .exam-card {
            padding: 5mm;
            position: relative;
            box-sizing: border-box;
        }
        .header {
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
            margin-bottom: 8px;
            text-align: center;
        }
        .logo {
            max-height: 45px;
            margin-bottom: 3px;
        }
        .school-name {
            font-size: 12pt;
            font-weight: bold;
            margin: 3px 0;
        }
        .card-title {
            font-size: 14pt;
            font-weight: bold;
            text-align: center;
            margin: 10px 0;
        }
        .student-info-row {
            width: 100%;
        }
        .student-info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .student-info-table td {
            padding: 3px;
            font-size: 9pt;
            vertical-align: top;
        }
        .label {
            font-weight: bold;
            width: 22%;
        }
        .value {
            width: 48%;
        }
        .exam-code-cell {
            width: 30%;
            padding-left: 10px;
            vertical-align: middle;
        }
        .exam-code {
            font-size: 11pt;
            font-weight: bold;
            text-align: center;
            border: 2px solid #333;
            padding: 4px;
        }
        .qr-code {
            text-align: center;
            margin: 5px 0;
        }
        .schedule {
            margin-top: 8px;
            margin-bottom: 20px;
        }
        .schedule h3 {
            margin-top: 8px;
            margin-bottom: 5px;
        }
        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }
        .schedule-table th, .schedule-table td {
            border: 1px solid #333;
            padding: 4px;
            text-align: left;
        }
        .schedule-table th {
            background-color: #f0f0f0;
        }
        .note {
            margin-top: 10px;
            text-align: center;
            font-size: 8pt;
            border-top: 1px solid #ccc;
            padding-top: 3px;
        }
        .note p {
            margin: 2px 0;
        }
        /* Footer style can be removed if no longer needed */
        .footer {
            margin-top: 5px;
            text-align: center;
            font-size: 8pt;
            border-top: 1px solid #ccc;
            padding-top: 3px;
            position: absolute;
            bottom: 10mm;
            left: 5mm;
            right: 5mm;
        }
    </style>
</head>
<body>
    @foreach($students as $student)
    <div class="exam-card-container">
        <div class="exam-card">
            <div class="header">
                @if(file_exists(public_path('assets/images/logo.png')))
                    <img src="{{ public_path('assets/images/logo.png') }}" alt="Logo Sekolah" class="logo">
                @endif
                <div class="school-name">Sistem Ujian Berbasis Komputer</div>
                <div>{{ $examPackage->title }}</div>
            </div>

            <div class="card-title">KARTU UJIAN</div>

            <div class="student-info-row">
                <table class="student-info-table">
                    <tr>
                        <td class="label">Nama Siswa:</td>
                        <td class="value">{{ $student->name }}</td>
                        <td class="exam-code-cell" rowspan="4">
                            <div class="exam-code">
                                Kode Ujian:<br>{{ $student->examCard->exam_code }}
                            </div>
                            @if(file_exists(public_path('assets/images/qrcode.png')))
                            <div class="qr-code">
                                <img src="{{ public_path('assets/images/qrcode.png') }}" alt="QR Code" style="width: 65px;">
                            </div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Nomor Siswa:</td>
                        <td class="value">{{ $student->id }}</td>
                    </tr>
                    <tr>
                        <td class="label">Kelas:</td>
                        <td class="value">{{ $student->class_name ?? 'Belum Ditentukan' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Email:</td>
                        <td class="value">{{ $student->email }}</td>
                    </tr>
                </table>
            </div>

            <div class="schedule">
                <h3>Jadwal Ujian</h3>
                <table class="schedule-table">
                    <thead>
                        <tr>
                            <th>Mata Ujian</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Ruangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($student->examSessions as $session)
                        <tr>
                            <td>{{ $session->exam_title }}</td>
                            <td>{{ date('d M Y', strtotime($session->date)) }}</td>
                            <td>{{ date('H:i', strtotime($session->time)) }}</td>
                            <td>{{ $session->room_name ?? 'Belum Ditentukan' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center;">Belum ada jadwal ujian yang terjadwal</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="note">
                    <p>Catatan: Kartu ujian ini wajib dibawa saat ujian berlangsung.</p>
                    <p>© {{ date('Y') }} Sistem Ujian Berbasis Komputer</p>
                </div>
            </div>
        </div>
    </div>

    @if(!$loop->last)
    <div class="page-break"></div>
    @endif
    @endforeach
</body>
</html>
