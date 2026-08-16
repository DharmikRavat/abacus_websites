<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>
        Monthly Attendance -
        {{ $startDate->format('F Y') }}
    </title>

    <style>

        @page {
            size: A3 landscape;
            margin: 7mm;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: DejaVu Sans, Arial, Helvetica, sans-serif;
            font-size: 7px;
            color: #111;
            background: #fff;
        }

        /* =====================================================
           HEADER
        ===================================================== */

        .report-header {
            width: 100%;
            text-align: center;
            margin-bottom: 8px;
        }

        .report-title {
            display: inline-block;
            background: #4472c4;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
            padding: 7px 25px;
            margin-bottom: 4px;
        }

        .report-trainer {
            display: inline-block;
            background: #4472c4;
            color: #fff;
            font-size: 12px;
            font-weight: bold;
            padding: 6px 25px;
            margin-bottom: 4px;
        }

        .report-month {
            display: inline-block;
            background: #4472c4;
            color: red;
            font-size: 12px;
            font-weight: bold;
            text-decoration: underline;
            padding: 6px 25px;
        }

        /* =====================================================
           TABLE
        ===================================================== */

        .table-wrapper {
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 0.5px solid #ffffff;
            padding: 3px 2px;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
        }

        th {
            background: #e8ebf4;
            font-weight: bold;
        }

        td {
            background: #f0f2f8;
        }

        /* =====================================================
           COLUMN WIDTHS
        ===================================================== */

        .sn {
            width: 3%;
        }

        .student {
            width: 12%;
            text-align: left;
            font-weight: bold;
        }

        .mobile {
            width: 8%;
        }

        .joining {
            width: 7%;
        }

        /*
        |--------------------------------------------------------------------------
        | Date columns
        |--------------------------------------------------------------------------
        */

        .date {
            width: 1.75%;
            font-size: 6px;
            padding-left: 1px;
            padding-right: 1px;
        }

        /*
        |--------------------------------------------------------------------------
        | Financial / summary columns
        |--------------------------------------------------------------------------
        */

        .fee {
            width: 5%;
        }

        .classes {
            width: 4%;
        }

        .days {
            width: 4%;
        }

        .pay-class {
            width: 5%;
        }

        .pay-month {
            width: 5%;
        }

        .region {
            width: 5%;
        }

        /* =====================================================
           ATTENDANCE COLORS
        ===================================================== */

        .weekend {
            background: #ff0000 !important;
            color: #ffffff !important;
            font-weight: bold;
        }

        .present {
            background: #f0f2f8 !important;
            color: #111111;
            font-weight: bold;
        }

        .absent {
            background: #ff0000 !important;
            color: #ffffff !important;
            font-weight: bold;
        }

        .holiday {
            background: #ff0000 !important;
            color: #ffffff !important;
            font-weight: bold;
        }

        .extra {
            background: #d9ead3 !important;
            color: #111111 !important;
            font-weight: bold;
        }

        .leave {
            background: #f4cccc !important;
            color: #111111 !important;
            font-weight: bold;
        }

        /* =====================================================
           LEGEND
        ===================================================== */

        .legend {
            width: 100%;
            margin-top: 8px;
            background: #4472c4;
            color: #111;
            padding: 7px;
            text-align: center;
            font-size: 9px;
            font-weight: bold;
        }

        /* =====================================================
           PAGE BREAK
        ===================================================== */

        thead {
            display: table-header-group;
        }

        tbody {
            display: table-row-group;
        }

        tr {
            page-break-inside: avoid;
        }

    </style>
</head>

<body>

{{-- =========================================================
     REPORT HEADER
========================================================= --}}

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


{{-- =========================================================
     REPORT TABLE
========================================================= --}}

<div class="table-wrapper">

    <table>

        <thead>

            {{-- =================================================
                 MAIN HEADER
            ================================================== --}}

            <tr>

                <th rowspan="3" class="sn">
                    S.N
                </th>

                <th rowspan="3" class="student">
                    STUDENT FULL NAME
                </th>

                <th rowspan="3" class="mobile">
                    Mobile No.
                </th>

                <th rowspan="3" class="joining">
                    Joining Date
                </th>

                <th colspan="{{ $dates->count() }}">
                    Date
                </th>

                <th rowspan="3" class="fee">
                    Fee Amount<br>
                    Per Month
                </th>

                <th rowspan="3" class="classes">
                    Monthly<br>
                    Classes
                </th>

                <th rowspan="3" class="days">
                    Days<br>
                    Absent
                </th>

                <th rowspan="3" class="days">
                    Days<br>
                    Presents
                </th>

                <th rowspan="3" class="pay-class">
                    Pay<br>
                    Per Class
                </th>

                <th rowspan="3" class="pay-month">
                    Pay<br>
                    Per Month
                </th>

                <th rowspan="3" class="region">
                    Region
                </th>

            </tr>


            {{-- =================================================
                 DATE NUMBERS
            ================================================== --}}

            <tr>

                @foreach($dates as $date)

                    <th class="date
                        {{ $date->isWeekend() ? 'weekend' : '' }}">

                        {{ $date->format('j') }}

                    </th>

                @endforeach

            </tr>


            {{-- =================================================
                 DAY LETTERS
            ================================================== --}}

            <tr>

                @foreach($dates as $date)

                    <th class="date
                        {{ $date->isWeekend() ? 'weekend' : '' }}">

                        {{ strtoupper($date->format('D')[0]) }}

                    </th>

                @endforeach

            </tr>

        </thead>


        {{-- =====================================================
             STUDENTS
        ====================================================== --}}

        <tbody>

        @foreach($reportStudents as $index => $item)

            <tr>

                {{-- S.N --}}
                <td class="sn">

                    {{ $index + 1 }}

                </td>


                {{-- STUDENT --}}
                <td class="student">

                    {{ $item['student']->name ?? '—' }}

                </td>


                {{-- MOBILE --}}
                <td class="mobile">

                    {{ $item['student']->mobile
                        ?? $item['student']->phone
                        ?? '—' }}

                </td>


                {{-- JOINING DATE --}}
                <td class="joining">

                    @if($item['student']->created_at)

                        {{ \Carbon\Carbon::parse(
                            $item['student']->created_at
                        )->format('d-M-y') }}

                    @else

                        —

                    @endif

                </td>


                {{-- =================================================
                     DAILY ATTENDANCE
                ================================================== --}}

                @foreach($dates as $date)

                    @php

                        $dateString = $date->format('Y-m-d');

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

                    <td class="date {{ $class }}">

                        {{ $status ?? '-' }}

                    </td>

                @endforeach


                {{-- =================================================
                     MONTHLY FEE
                ================================================== --}}

                <td class="fee">

                    ₹{{ number_format(
                        $item['monthly_fee'] ?? 0,
                        0
                    ) }}

                </td>


                {{-- =================================================
                     MONTHLY CLASSES
                ================================================== --}}

                <td class="classes">

                    {{ $item['monthly_classes'] ?? 0 }}

                </td>


                {{-- =================================================
                     ABSENT
                ================================================== --}}

                <td class="days">

                    {{ $item['absent_days'] ?? 0 }}

                </td>


                {{-- =================================================
                     PRESENT
                ================================================== --}}

                <td class="days">

                    {{ $item['present_days'] ?? 0 }}

                </td>


                {{-- =================================================
                     PAY PER CLASS
                ================================================== --}}

                <td class="pay-class">

                    ₹{{ number_format(
                        $item['pay_per_class'] ?? 0,
                        0
                    ) }}

                </td>


                {{-- =================================================
                     PAY PER MONTH
                ================================================== --}}

                <td class="pay-month">

                    ₹{{ number_format(
                        $item['pay_per_month'] ?? 0,
                        0
                    ) }}

                </td>


                {{-- =================================================
                     REGION
                ================================================== --}}

                <td class="region">

                    {{ $item['student']->region ?? 'India' }}

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>


{{-- =========================================================
     LEGEND
========================================================= --}}

<div class="legend">

    Full Form:

    P = Present
    &nbsp;&nbsp;&nbsp;

    A = Absent
    &nbsp;&nbsp;&nbsp;

    E = Extra Class
    &nbsp;&nbsp;&nbsp;

    H = Holiday
    &nbsp;&nbsp;&nbsp;

    L = Leave

</div>

</body>
</html>