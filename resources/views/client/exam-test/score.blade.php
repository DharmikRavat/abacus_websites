@extends('client.layout.app')

@section('style')
    <style>
        .score-board-area {
            background: #f7f8fc;
        }

        /* HEADER */
        .score-header h2 {
            font-size: 32px;
            font-weight: 700;
            color: #222;
            margin-bottom: 15px;
        }

        .score-header p {
            color: #666;
            font-size: 17px;
        }

        /* CARD */
        .score-table-card {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            /* box-shadow: 0 15px 40px rgba(0, 0, 0, 0.05); */
        }

        /* TOP */
        .score-table-top {
            background: linear-gradient(90deg, #38b6d9, #43c3df);
            padding: 25px 35px;
        }

        .score-table-top h3 {
            color: #fff;
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }

        /* TABLE */
        .score-table {
            margin: 0;
        }

        .score-table thead {
            background: #f5f7fb;
        }

        .score-table thead th {
            border: none;
            padding: 22px 18px;
            font-size: 17px;
            font-weight: 700;
            color: #222;
            white-space: nowrap;
        }

        .score-table tbody td {
            padding: 22px 18px;
            vertical-align: middle;
            border-top: 1px solid #edf1f7;
            font-size: 16px;
            color: #444;
            white-space: nowrap;
        }

        .score-table tbody tr {
            transition: .3s;
        }

        .score-table tbody tr:hover {
            background: #f9fbff;
        }

        /* SCORE */
        .score-badge {
            display: inline-block;
            min-width: 45px;
            height: 45px;
            line-height: 45px;
            border-radius: 50%;
            text-align: center;
            background: #0d6efd;
            color: #fff;
            font-weight: 700;
            font-size: 16px;
        }

        /* STATUS */
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
        }

        .success-badge {
            background: #dff5e5;
            color: #1d9b42;
        }

        .warning-badge {
            background: #fff4dd;
            color: #f39c12;
        }

        .danger-badge {
            background: #ffe3e3;
            color: #dc3545;
        }

        /* EMPTY */
        .empty-score {
            text-align: center;
            padding: 70px 20px;
        }

        .empty-score img {
            width: 100px;
            margin-bottom: 20px;
        }

        .empty-score h4 {
            font-size: 28px;
            margin-bottom: 10px;
            color: #222;
        }

        .empty-score p {
            color: #777;
            margin: 0;
        }

        /* MOBILE */
        @media(max-width:991px) {

            .score-header h2 {
                font-size: 36px;
            }

            .score-table-top h3 {
                font-size: 26px;
            }

        }

        @media(max-width:767px) {

            .score-header h2 {
                font-size: 30px;
            }

            .score-table thead th,
            .score-table tbody td {
                font-size: 14px;
                padding: 16px 12px;
            }

            .score-badge {
                min-width: 38px;
                height: 38px;
                line-height: 38px;
                font-size: 14px;
            }

        }
    </style>

@endsection
@section('content')


    <!--Breadcrumb Banner Area Start-->
    <div class="breadcrumb-banner-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-text">
                        <h1 class="text-center">Score</h1>
                        <div class="breadcrumb-bar">
                            <ul class="breadcrumb text-center">
                                <li><a href="index.html">Home</a></li>
                                <li>Score</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End of Breadcrumb Banner Area-->

    <!--Score Area Start-->
    <div class="score-board-area pt-80 pb-80">
        <div class="container">

            <!-- HEADER -->
            <div class="score-header text-center mb-50">

                <h2>
                    Practice Score Board
                </h2>

                <p>
                    View all practice, test and exam results with performance history.
                </p>

            </div>

            <!-- SCORE CARD -->
            <div class="score-table-card">

                <!-- TOP BAR -->
                <div class="score-table-top">

                    <h3>
                        Score History
                    </h3>

                </div>

                <!-- TABLE -->
                <div class="table-responsive">

                    <table class="table score-table">

                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Level</th>
                                <th>Time</th>
                                <th>Total Questions</th>
                                <th>Wrong Answers</th>
                                <th>Question Skipped</th>
                                <th>Score</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            @php

                                $dummyScores = [
                                    (object) [
                                        'student_name' => 'Sahil Kamble',
                                        'level' => 0,
                                        'time_taken' => '00:14',
                                        'total_questions' => 50,
                                        'wrong_answers' => 0,
                                        'question_skipped' => 48,
                                        'score' => 2,
                                        'created_at' => now(),
                                    ],

                                    (object) [
                                        'student_name' => 'Varsha',
                                        'level' => 1,
                                        'time_taken' => '00:15',
                                        'total_questions' => 90,
                                        'wrong_answers' => 9,
                                        'question_skipped' => 75,
                                        'score' => 6,
                                        'created_at' => now(),
                                    ],

                                    (object) [
                                        'student_name' => 'Rahul',
                                        'level' => 2,
                                        'time_taken' => '01:04',
                                        'total_questions' => 90,
                                        'wrong_answers' => 0,
                                        'question_skipped' => 90,
                                        'score' => 0,
                                        'created_at' => now(),
                                    ],
                                ];

                                $scores = $scores ?? $dummyScores;

                            @endphp

                            @forelse ($scores as $key => $score)

                                @php
                                    $percentage =
                                        ($score->total_questions ?? 0) > 0
                                        ? (($score->score ?? 0) / $score->total_questions) * 100
                                        : 0;
                                @endphp

                                <tr>

                                    <td>
                                        {{ $key + 1 }}
                                    </td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($score->created_at ?? now())->format('d-m-Y') }}
                                    </td>

                                    <td>
                                        {{ $score->student_name ?? 'Student Name' }}
                                    </td>

                                    <td>
                                        Level {{ $score->level ?? 0 }}
                                    </td>

                                    <td>
                                        {{ $score->time_taken ?? '00:00' }}
                                    </td>

                                    <td>
                                        {{ $score->total_questions ?? 0 }}
                                    </td>

                                    <td class="text-danger">
                                        {{ $score->wrong_answers ?? 0 }}
                                    </td>

                                    <td class="text-warning">
                                        {{ $score->question_skipped ?? 0 }}
                                    </td>

                                    <td>

                                        <span class="score-badge">

                                            {{ $score->score ?? 0 }}

                                        </span>

                                    </td>

                                    <td>

                                        @if ($percentage >= 80)

                                            <span class="status-badge success-badge">
                                                Excellent
                                            </span>

                                        @elseif($percentage >= 50)

                                            <span class="status-badge warning-badge">
                                                Good
                                            </span>

                                        @else

                                            <span class="status-badge danger-badge">
                                                Improve
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="10">

                                        <div class="empty-score">

                                            <h4>
                                                No Score Found
                                            </h4>

                                            <p>
                                                No test or practice score available yet.
                                            </p>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>
                    </table>

                </div>

            </div>

        </div>
    </div>
    <!--Score Area End-->


@endsection

@section('script')

@endsection