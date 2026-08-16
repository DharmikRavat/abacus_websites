<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Monthly Attendance -
        {{ $startDate->format('F Y') }}
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, Helvetica, sans-serif;
            background: white;
            color: #111;
        }

        .report-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .report-title,
        .report-trainer,
        .report-month {
            display: inline-block;
            background: #4472c4;
            color: white;
            padding: 10px 40px;
            margin-bottom: 7px;
            font-weight: bold;
        }

        .report-title {
            font-size: 24px;
            text-decoration: underline;
        }

        .report-trainer {
            font-size: 20px;
        }

        .report-month {
            font-size: 20px;
            color: red;
            text-decoration: underline;
        }

        .toolbar {
            text-align: right;
            margin-bottom: 10px;
        }

        .toolbar button {
            background: #4472c4;
            color: white;
            border: 0;
            padding: 9px 18px;
            margin-left: 5px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            border-collapse: collapse;
            width: max-content;
            min-width: 100%;
            font-size: 11px;
        }

        th,
        td {
            border: 1px solid white;
            padding: 5px;
            text-align: center;
            white-space: nowrap;
        }

        th {
            background: #e8ebf4;
            font-weight: bold;
        }

        td {
            background: #f0f2f8;
        }

        .student {
            min-width: 150px;
            text-align: left;
            font-weight: bold;
        }

        .mobile {
            min-width: 120px;
        }

        .date {
            min-width: 27px;
            width: 27px;
        }

        .weekend {
            background: red !important;
            color: white;
            font-weight: bold;
        }

        .present {
            font-weight: bold;
        }

        .absent {
            background: red !important;
            color: white;
            font-weight: bold;
        }

        .holiday {
            background: red !important;
            color: white;
            font-weight: bold;
        }

        .extra {
            background: #d9ead3 !important;
            font-weight: bold;
        }

        .leave {
            background: #f4cccc !important;
            font-weight: bold;
        }

        .money {
            min-width: 90px;
        }

        .legend {
            margin-top: 15px;
            background: #4472c4;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }

        @media print {

            @page {
                size: landscape;
                margin: 5mm;
            }

            body {
                padding: 0;
            }

            .toolbar {
                display: none;
            }

            table {
                font-size: 8px;
            }

            th,
            td {
                padding: 3px;
            }

            .report-title {
                font-size: 18px;
            }

            .report-trainer,
            .report-month {
                font-size: 15px;
            }

        }

    </style>

</head>

<body>

<div class="report-header">

    <div class="report-title">
        Monthly Attendance Details of Students
    </div>

    <br>

    <div class="report-trainer">
        Abacus Trainer's Name
    </div>

    <br>

    <div class="report-month">
        Month :- {{ $startDate->format('F Y') }}
    </div>

</div>


<div class="toolbar">

<button onclick="downloadMonthlyPdf()">
        📄 Generate PDF
    </button>

</div>


<div class="table-wrapper">

    <table>

        <thead>

        <tr>

            <th rowspan="3">
                S.N
            </th>

            <th rowspan="3"
                class="student">
                STUDENT FULL NAME
            </th>

            <th rowspan="3"
                class="mobile">
                Mobile No.
            </th>

            <th rowspan="3">
                Joining Date
            </th>

            <th colspan="{{ $dates->count() }}">
                Date
            </th>

            <th rowspan="3">
                Fee Amount<br>
                Per Month
            </th>

            <th rowspan="3">
                Monthly<br>
                Classes
            </th>

            <th rowspan="3">
                Days<br>
                Absent
            </th>

            <th rowspan="3">
                Days<br>
                Presents
            </th>

            <th rowspan="3">
                Pay<br>
                Per Class
            </th>

            <th rowspan="3">
                Pay<br>
                Per Month
            </th>

            <th rowspan="3">
                Region
            </th>

        </tr>


        {{-- DATE NUMBERS --}}
        <tr>

            @foreach($dates as $date)

                <th class="date
                    {{ $date->isWeekend() ? 'weekend' : '' }}">

                    {{ $date->format('j') }}

                </th>

            @endforeach

        </tr>


        {{-- DAY LETTER --}}
        <tr>

            @foreach($dates as $date)

                <th class="date
                    {{ $date->isWeekend() ? 'weekend' : '' }}">

                    {{ strtoupper($date->format('D')[0]) }}

                </th>

            @endforeach

        </tr>

        </thead>


        <tbody>

        @foreach($reportStudents as $index => $item)

            <tr>

                <td>
                    {{ $index + 1 }}
                </td>


                <td class="student">

                    {{ $item['student']->name }}

                </td>


                <td class="mobile">

                    {{ $item['student']->mobile
                        ?? $item['student']->phone
                        ?? '—' }}

                </td>


                <td>

                    @if($item['student']->created_at)

                        {{ \Carbon\Carbon::parse(
                            $item['student']->created_at
                        )->format('d-M-y') }}

                    @else

                        —

                    @endif

                </td>


                {{-- ATTENDANCE --}}
                @foreach($dates as $date)

                    @php

                        $dateString =
                            $date->format('Y-m-d');

                        $attendance =
                            $item['attendance'][$dateString]
                            ?? null;

                        $status =
                            $attendance['status']
                            ?? null;

                        $class = '';

                        if ($date->isWeekend()) {

                            $class = 'weekend';

                        } elseif ($status === 'P') {

                            $class = 'present';

                        } elseif ($status === 'A') {

                            $class = 'absent';

                        } elseif ($status === 'H') {

                            $class = 'holiday';

                        } elseif ($status === 'E') {

                            $class = 'extra';

                        } elseif ($status === 'L') {

                            $class = 'leave';

                        }

                    @endphp

                    <td class="{{ $class }}">

                        {{ $status ?? '-' }}

                    </td>

                @endforeach


                {{-- FEE --}}
                <td class="money">

                    ₹{{ number_format(
                        $item['monthly_fee'],
                        0
                    ) }}

                </td>


                {{-- MONTHLY CLASSES --}}
                <td>

                    {{ $item['monthly_classes'] }}

                </td>


                {{-- ABSENT --}}
                <td>

                    {{ $item['absent_days'] }}

                </td>


                {{-- PRESENT --}}
                <td>

                    {{ $item['present_days'] }}

                </td>


                {{-- PAY PER CLASS --}}
                <td class="money">

                    ₹{{ number_format(
                        $item['pay_per_class'],
                        0
                    ) }}

                </td>


                {{-- PAY PER MONTH --}}
                <td class="money">

                    ₹{{ number_format(
                        $item['pay_per_month'],
                        0
                    ) }}

                </td>


                {{-- REGION --}}
                <td>

                    {{ $item['student']->region ?? 'India' }}

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>


<div class="legend">

    Full Form:

    P = Present &nbsp;&nbsp;

    A = Absent &nbsp;&nbsp;

    E = Extra Class &nbsp;&nbsp;

    H = Holiday &nbsp;&nbsp;

    L = Leave

</div>


<script>

function downloadMonthlyPdf() {

    const startDate = @json($startDate->format('Y-m-d'));
    const endDate   = @json($endDate->format('Y-m-d'));

    const url =
        "{{ route('admin.attendance.monthly-report.pdf') }}" +
        "?start_date=" + encodeURIComponent(startDate) +
        "&end_date=" + encodeURIComponent(endDate);

    // Open Laravel generated PDF
    window.open(url, '_blank');
}

</script>

</body>

</html>