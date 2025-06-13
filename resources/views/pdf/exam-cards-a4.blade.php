<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Ujian - {{ $examPackage->title }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 5mm;
        }
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            font-size: 10pt;
            background-color: #fff;
            line-height: 1.0;
        }
        .page-break {
            page-break-after: always;
        }
        .cards-container {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .exam-card-container {
            width: calc(100% - 2mm);
            height: calc(48% - 5mm);
            padding: 1mm;
            position: relative;
            box-sizing: border-box;
            border: 2px solid #000;
            margin: 0 auto 5mm auto;
        }
        .exam-card-container:last-child {
            margin-bottom: 0;
        }
        .exam-card {
            padding: 3mm;
            position: relative;
            box-sizing: border-box;
            height: 100%;
        }
        .header {
            border-bottom: 1px solid #333;
            padding-bottom: 3px;
            margin-bottom: 5px;
            width: 100%;
            display: table;
        }
        .logo-container {
            display: table-cell;
            vertical-align: middle;
            width: 15%;
        }
        .logo-square {
            width: 75px;
            height: 75px;
            object-fit: contain;
        }
        .school-info {
            vertical-align: middle;
            width: 85%;
            padding-left: 3px;
            text-align: center;
        }
        .school-name {
            font-size: 11pt;
            font-weight: bold;
            margin: 0;
            padding: 0;
            line-height: 0.2;
        }
        .school-details {
            font-size: 8pt;
            margin: 1px 0;
            line-height: 0.2;
        }
        .card-title {
            font-size: 13pt;
            font-weight: bold;
            text-align: center;
            margin: 5px 0;
        }
        .student-info-row {
            width: 100%;
        }
        .student-info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .student-info-table td {
            padding: 2px;
            font-size: 10pt;
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
            padding-left: 5px;
            vertical-align: middle;
        }
        .exam-code {
            font-size: 10pt;
            font-weight: bold;
            text-align: center;
            border: 2px solid #333;
            padding: 3px;
        }
        .qr-code {
            text-align: center;
            margin: 3px 0;
        }
        .schedule {
            margin-top: 5px;
            margin-bottom: 5px;
        }
        .schedule h3 {
            margin-top: 4px;
            margin-bottom: 2px;
            font-size: 10pt;
        }
        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }
        .schedule-table th, .schedule-table td {
            border: 1px solid #333;
            padding: 2px;
            text-align: left;
        }
        .schedule-table th {
            background-color: #f0f0f0;
        }
        .two-column-container {
            margin-top: 0;
            width: 100%;
        }
        .columns-wrapper {
            width: 100%;
        }
        .column {
            width: 49%;
            float: left;
        }
        .column:first-child {
            margin-right: 2%;
        }
        .column-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7.5pt;
        }
        .column-table th, .column-table td {
            border: 1px solid #333;
            padding: 1px;
            text-align: left;
        }
        .column-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            font-size: 7.5pt;
        }
        .note {
            margin-top: 10px;
            clear: both;
            text-align: center;
            font-size: 8pt;
            padding-top: 1px;
        }
        .note p {
            margin: 1px 0;
        }
        .signature-section {
            width: 100%;
            margin-top: 3px;
            display: flex;
            justify-content: space-between;
        }
        .signature-left {
            float: left;
            width: 30%;
            text-align: center;
        }
        .signature-right {
            float: right;
            width: 40%;
            text-align: center;
            font-size: 9pt;
            line-height: 1.1;
        }
        .signature-line {
            margin-top: 15px;
            width: 100%;
        }
        .small-qr-code {
            text-align: center;
            margin: 3px auto;
        }
        .small-qr-code img {
            width: 60px;
            height: 60px;
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

        // Get settings from the Settings model
        $settings = \App\Models\Setting::getSettings();

        // Retrieve the chairman, city, and NIP from settings
        $chairman = $settings['chairman'] ?? 'Kepala Sekolah';
        $city = $settings['city'] ?? '';
        $nip = $settings['nip'] ?? '';

        // Get additional settings for the header
        $settingsSchoolName = $settings['school_name'] ?? 'Nama Sekolah';
        $address = $settings['address'] ?? 'Alamat Sekolah';
        $phone = $settings['phone'] ?? '';
        $email = $settings['email'] ?? '';
        $logo = $settings['logo'] ?? '';

        // Group students into pairs for A4 pages (2 per page)
        // Check if $students is a collection or an array and handle accordingly
        if (is_object($students) && method_exists($students, 'chunk')) {
            // It's a collection, we can use chunk
            $studentPairs = $students->chunk(2);
        } else {
            // It's an array, use array_chunk
            $studentPairs = collect(array_chunk($students, 2));
        }
    @endphp

    @foreach($studentPairs as $pair)
    <div class="cards-container">
        @foreach($pair as $student)
        <div class="exam-card-container">
            <div class="exam-card">
                <div class="header">
                    <div class="logo-container">
                        @if(!empty($logo))
                            <img src="{{ public_path('storage/'.$logo) }}" alt="School Logo" class="logo-square">
                        @elseif(file_exists(public_path('assets/images/logo.png')))
                            <img src="{{ public_path('assets/images/logo.png') }}" alt="Logo Sekolah" class="logo-square">
                        @else
                            <div style="height: 35px; width: 35px; border: 1px dashed #ccc; text-align: center; line-height: 35px; font-size: 7pt;">Logo</div>
                        @endif
                    </div>
                    <div class="school-info">
                        <div class="school-name">{!! $settingsSchoolName !!}</div>
                        <div class="school-details">
                            {!! $address !!}
                            @if(!empty($phone) || !empty($email))
                                <br>
                                @if(!empty($phone)) Telp: {{ $phone }} @endif
                                @if(!empty($email)) | Email: {{ $email }} @endif
                            @endif
                        </div>
                    </div>
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

                    @php
                        $examCount = count($student->examSessions);
                    @endphp

                    @if($examCount > 6)
                    <!-- Two-column layout using HTML tables for layout -->
                    <div class="two-column-container">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="49%" valign="top">
                                    <!-- First column -->
                                    <table class="column-table">
                                        <thead>
                                            <tr>
                                                <th>Mata Ujian</th>
                                                <th>Tanggal</th>
                                                <th>Waktu</th>
                                                <th>Ruangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php $half = ceil($examCount / 2); $counter = 0; @endphp
                                        @foreach($student->examSessions as $session)
                                            @if($counter < $half)
                                            <tr>
                                                <td>{{ $session->exam_title }}</td>
                                                <td>
                                                    @php
                                                        $sessionDate = \Carbon\Carbon::parse($session->date);
                                                        $sessionDay = $sessionDate->day;
                                                        $sessionMonth = $bulanIndonesia[$sessionDate->month];
                                                        echo "{$sessionDay} {$sessionMonth}";
                                                    @endphp
                                                </td>
                                                <td>{{ date('H:i', strtotime($session->time)) }}</td>
                                                <td>{{ $session->room_name ?? 'Belum ditentukan' }}</td>
                                            </tr>
                                            @php $counter++; @endphp
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </td>
                                <td width="2%"></td>
                                <td width="49%" valign="top">
                                    <!-- Second column -->
                                    <table class="column-table">
                                        <thead>
                                            <tr>
                                                <th>Mata Ujian</th>
                                                <th>Tanggal</th>
                                                <th>Waktu</th>
                                                <th>Ruangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php $counter = 0; @endphp
                                        @foreach($student->examSessions as $session)
                                            @php $counter++; @endphp
                                            @if($counter > $half)
                                            <tr>
                                                <td>{{ $session->exam_title }}</td>
                                                <td>
                                                    @php
                                                        $sessionDate = \Carbon\Carbon::parse($session->date);
                                                        $sessionDay = $sessionDate->day;
                                                        $sessionMonth = $bulanIndonesia[$sessionDate->month];
                                                        echo "{$sessionDay} {$sessionMonth}";
                                                    @endphp
                                                </td>
                                                <td>{{ date('H:i', strtotime($session->time)) }}</td>
                                                <td>{{ $session->room_name ?? 'Belum ditentukan' }}</td>
                                            </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    @else
                    <!-- Default single-column layout -->
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
                                <td>
                                    @php
                                        $sessionDate = \Carbon\Carbon::parse($session->date);
                                        $sessionDay = $sessionDate->day;
                                        $sessionMonth = $bulanIndonesia[$sessionDate->month];
                                        $sessionYear = $sessionDate->year;
                                        echo "{$sessionDay} {$sessionMonth} {$sessionYear}";
                                    @endphp
                                </td>
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
                    @endif

                    <div class="note">
                        <p>Catatan: Kartu ujian ini wajib dibawa saat ujian berlangsung.</p>
                        <p>© {{ date('Y') }} Sistem Ujian Berbasis Komputer</p>
                    </div>
                </div>

                <div class="clearfix signature-section">
                    <div class="signature-left">
                        <div class="small-qr-code">
                            @php
                                $examDetailUrl = route('student.exam.detail', ['examCode' => $student->examCard->exam_code]);
                            @endphp
                            <img src="data:image/png;base64,{{ base64_encode(QrCode::size(60)->generate($examDetailUrl)) }}" alt="QR Code">
                            <div style="font-size: 7pt; text-align: center; margin-top: 2px;">Scan untuk detail ujian</div>
                        </div>
                    </div>
                    <div class="signature-right">
                        @php
                            $currentDate = \Carbon\Carbon::now();
                            $day = $currentDate->day;
                            $month = $bulanIndonesia[$currentDate->month];
                            $year = $currentDate->year;
                        @endphp
                        @if(!empty($city)){{ $city }}, @endif{{ $day }} {{ $month }} {{ $year }}<br>
                        Kepala Sekolah<br><br>
                        <div class="signature-line"></div>
                        <strong>{{ $chairman }}</strong><br>
                        @if (!empty($nip))
                            NIP. {{ $nip }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if(!$loop->last)
    <div class="page-break"></div>
    @endif
    @endforeach
</body>
</html>
