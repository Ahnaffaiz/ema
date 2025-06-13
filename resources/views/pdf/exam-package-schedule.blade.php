<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $package->name }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .letterhead {
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            display: table;
        }
        .logo-container {
            display: table-cell;
            vertical-align: middle;
            width: 15%;
        }
        .logo-square {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }
        .school-info {
            display: table-cell;
            vertical-align: middle;
            width: 85%;
            padding-left: 15px;
            text-align: center;
        }
        .school-name {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .school-name p {
            margin: 0;
            padding: 0;
        }
        .school-details {
            font-size: 11px;
        }
        .school-details p {
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            margin-top: 20px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: middle;
        }
        th {
            font-weight: bold;
        }
        .no-sessions {
            margin-top: 5px;
            color: #777;
            font-style: italic;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            padding: 5px 0;
            border-top: 1px solid #ddd;
        }
        .session-date-time {
            font-size: 11px;
            color: #555;
        }
        .signature-section {
            width: 100%;
            margin-top: 30px;
            margin-bottom: 60px;
        }
        .signature-right {
            float: right;
            width: 30%;
            text-align: left;
        }
        .signature-line {
            margin-top: 40px;
            width: 80%;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>
    @php
        $bulanIndonesia = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        // Get settings
        $settings = \App\Models\Setting::getSettings();
        $settingsSchoolName = $settings['school_name'] ?? 'Nama Sekolah';
        $settingsAddress = $settings['address'] ?? 'Alamat Sekolah';

        // Use rich text fields from component if available, otherwise use settings
        $schoolName = $school_name ?? $settingsSchoolName;
        $address = $address ?? $settingsAddress;

        $phone = $settings['phone'] ?? '';
        $email = $settings['email'] ?? '';
        $logo = $settings['logo'] ?? '';
        $chairman = $settings['chairman'] ?? 'Kepala Sekolah';
        $nip = $settings['nip'] ?? '';
        $city = $settings['city'] ?? '';
    @endphp

    <div class="letterhead">
        <div class="logo-container">
            @if(!empty($logo))
                <img src="{{ public_path('storage/'.$logo) }}" alt="School Logo" class="logo-square">
            @else
                <div style="height: 80px; width: 80px; border: 1px dashed #ccc; text-align: center; line-height: 80px;">Logo</div>
            @endif
        </div>
        <div class="school-info">
            <div class="school-name">{!! $schoolName !!}</div>
            <div class="school-details">
                {!! $address !!}<br>
                @if(!empty($phone)) Telp: {{ $phone }} @endif
                @if(!empty($email)) | Email: {{ $email }} @endif
            </div>
        </div>
    </div>

    <div class="header">
        <div class="title">{{ $package->name }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Mata Pelajaran</th>
                <th width="20%">Sesi</th>
                <th width="20%">Pengawas</th>
                <th width="20%">Ruangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $examCount = 0;
                $hasNoSessions = false;
            @endphp

            @foreach($exams as $exam)
                @php $examCount++; @endphp

                @if(isset($examSessions[$exam->id]) && $examSessions[$exam->id]->count() > 0)
                    @php $sessionCount = $examSessions[$exam->id]->count(); @endphp

                    @foreach($examSessions[$exam->id] as $index => $session)
                        <tr>
                            @if($index === 0)
                                <td rowspan="{{ $sessionCount }}">{{ $examCount }}</td>
                                <td rowspan="{{ $sessionCount }}">{{ $exam->title }}</td>
                            @endif
                            <td>
                                {{ $session->title }}
                                <div class="session-date-time">
                                    @php
                                        $date = \Carbon\Carbon::parse($session->date);
                                        $time = substr($session->time, 0, 5); // Get just HH:MM part
                                        $tanggal = $date->day;
                                        $bulan = $bulanIndonesia[$date->month];
                                        $tahun = $date->year;
                                    @endphp
                                    {{ $time }}
                                    <br>
                                    {{ $tanggal }} {{ $bulan }} {{ $tahun }}
                                </div>
                            </td>
                            <td>{{ $session->observer ? $session->observer->name : 'Belum ditentukan' }}</td>
                            <td>{{ $session->room ? $session->room->name : 'Belum ditentukan' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>{{ $examCount }}</td>
                        <td>{{ $exam->title }}</td>
                        <td colspan="3" class="no-sessions">Belum ada sesi ujian terjadwal</td>
                    </tr>
                @endif
            @endforeach

            @if(count($exams) === 0)
                <tr>
                    <td colspan="5" class="no-sessions">Tidak ada ujian dalam paket ini</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="clearfix signature-section">
        <div class="signature-right">
            @php
                $currentDate = \Carbon\Carbon::now();
                $day = $currentDate->day;
                $month = $bulanIndonesia[$currentDate->month];
                $year = $currentDate->year;
            @endphp
            @if(!empty($city)){{ $city }}, @endif{{ $day }} {{ $month }} {{ $year }}<br>
            Kepala Sekolah<br><br><br><br><br>
            <div class="signature-line"></div>
            <strong>{{ $chairman }}</strong><br>
            @if (!empty($nip))
                NIP. {{ $nip }}
            @endif
        </div>
    </div>

    <div class="footer">
        @php
            $now = \Carbon\Carbon::now();
            $nowDate = $now->day;
            $nowMonth = $bulanIndonesia[$now->month];
            $nowYear = $now->year;
            $nowTime = $now->format('H:i');
        @endphp
        Jadwal dihasilkan pada: {{ $nowDate }} {{ $nowMonth }} {{ $nowYear }} {{ $nowTime }}
    </div>
</body>
</html>
