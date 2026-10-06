@extends('admin.layout.app')

@section('page-title', 'Dashboard')

@section('style')
<style>
.chart-grid{
    display:grid;
    grid-template-columns:1fr 2fr;
    gap:20px;
    margin-top:24px;
}

.chart-box{
    position:relative;
    width:100%;
    height:320px;
}

@media(max-width:992px){
    .chart-grid{
        grid-template-columns:1fr;
    }

    .chart-box{
        height:280px;
    }
}
/* FULL WIDTH RECENT ATTENDANCE */
.row2{
    width:100%;
    display:block;
    margin-top:20px;
}

.row2 .panel{
    width:100%;
}

/* SUMMARY + WEEKLY SECTION */
.summary-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
    margin-top:20px;
    align-items:start;
}

/* SMALL HEIGHT CARDS */
.summary-grid .panel{
    min-height:260px;
    max-height:260px;
    overflow:hidden;
}

/* COMPACT SUMMARY ITEMS */
.health-list{
    padding: 10px;
}

.health-item{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:6px 0;
    border-bottom:1px solid #f1f1f1;
    font-size:12px;
}

.health-item:last-child{
    border-bottom:none;
}

/* COMPACT WEEKLY SECTION */
.chart-wrap{
    padding: 20px;
    font-size: 12px;

}

.chart-wrap > div{
    margin-bottom:10px !important;
}

.simple-days{
    padding:16px 20px;
    display:flex;
    flex-wrap:wrap;
    gap:10px;
}

.day-item{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    padding:8px 12px;
    background:#f8fafc;
    border:1px solid #edf2f7;
    border-radius:10px;
    min-width:90px;
}

.day-label{
    font-size:12px;
    color:#64748b;
}

.day-value{
    width:24px;
    height:24px;
    border-radius:6px;
    background:#185FA5;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:11px;
    font-weight:600;
}

/* RESPONSIVE */
@media(max-width:992px){

    .summary-grid{
        grid-template-columns:1fr;
    }

    .summary-grid .panel{
        min-height:auto;
        max-height:none;
    }

}
</style>

@endsection

@section('content')

@php

    $hour = now()->format('H');

    if ($hour < 12) {
        $greeting = 'Good Morning';
    } elseif ($hour < 17) {
        $greeting = 'Good Afternoon';
    } else {
        $greeting = 'Good Evening';
    }

@endphp

<!-- GREETING -->
<div>

    <div class="greet-text">
        {{ $greeting }}, {{ auth()->user()->name }}
    </div>

    <div class="greet-sub">
        Here's what's happening across your platform today —
        {{ now()->format('F d, Y') }}.
    </div>


</div>

{{-- Dashboard Section --}}

<!-- STAT CARDS -->
<div class="stat-grid">

    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-icon si-blue">
                <svg viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <span class="trend-pill t-up">Students</span>
        </div>
        <div>
            <div class="stat-val">{{ $totalStudents ?? 0 }}</div>
            <div class="stat-lbl">Total Students</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-icon si-amber">
                <svg viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 00-3-3.87"/>
                </svg>
            </div>
            <span class="trend-pill t-up">Teachers</span>
        </div>
        <div>
            <div class="stat-val">{{ $totalTeachers ?? 0 }}</div>
            <div class="stat-lbl">Total Teachers</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-icon si-green">
                <svg viewBox="0 0 24 24">
                    <path d="M9 11l3 3L22 4"/>
                    <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
                </svg>
            </div>
            <span class="trend-pill t-up">Attendance</span>
        </div>
        <div>
            <div class="stat-val">{{ $totalAttendance ?? 0 }}</div>
            <div class="stat-lbl">Total Attendance</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-icon si-purple">
                <svg viewBox="0 0 24 24">
                    <path d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <span class="trend-pill t-up">Today</span>
        </div>
        <div>
            <div class="stat-val">{{ $presentToday ?? 0 }}</div>
            <div class="stat-lbl">Present Today</div>
        </div>
    </div>

</div>

<!-- CHART SECTION -->
<div class="chart-grid">

    <!-- Attendance Pie Chart -->
    <div class="panel">
        <div class="panel-hdr">
            <span class="panel-title">Attendance Distribution</span>
        </div>

        <div class="chart-box">
            <canvas id="attendancePieChart"></canvas>
        </div>
    </div>

    <!-- Weekly Attendance Graph -->
    <div class="panel">
        <div class="panel-hdr">
            <span class="panel-title">Weekly Attendance Trend</span>
        </div>

        <div class="chart-box">
            <canvas id="attendanceLineChart"></canvas>
        </div>
    </div>

</div>

<!-- ROW 2: Table + Side -->
<!-- ROW 2 -->
<div class="row2">

    <!-- RECENT ATTENDANCE FULL WIDTH -->
    <div class="panel">
        <div class="panel-hdr">
            <span class="panel-title">Recent Attendance</span>
            <button class="view-all">View all →</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Status</th>
                    <th>Marked By</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>

                @forelse($recentAttendances as $attendance)
                <tr>

                    <td>
                        <div class="co-name">
                            {{ $attendance->student->name ?? 'N/A' }}
                        </div>
                    </td>

                    <td>
                        @if($attendance->status == 'P')
                            <span class="pill p-active">Present</span>
                        @elseif($attendance->status == 'A')
                            <span class="pill p-suspended">Absent</span>
                        @else
                            <span class="pill p-pending">Leave</span>
                        @endif
                    </td>

                    <td>
                        {{ $attendance->markedBy->name ?? 'Admin' }}
                    </td>

                    <td style="color:var(--faint)">
                        {{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d M Y') }}
                    </td>

                </tr>
                @empty

                <tr>
                    <td colspan="4" class="text-center">
                        No attendance records found
                    </td>
                </tr>

                @endforelse

            </tbody>
        </table>
    </div>

</div>

<!-- ROW 3 -->
<div class="summary-grid">

    <!-- ATTENDANCE SUMMARY -->
    <div class="panel">
        <div class="panel-hdr">
            <span class="panel-title">Attendance Summary</span>
        </div>

        <div class="health-list">

            <div class="health-item">
                <span>Total Present</span>
                <strong>{{ $presentCount ?? 0 }}</strong>
            </div>

            <div class="health-item">
                <span>Total Absent</span>
                <strong>{{ $absentCount ?? 0 }}</strong>
            </div>

            <div class="health-item">
                <span>On Leave</span>
                <strong>{{ $leaveCount ?? 0 }}</strong>
            </div>

            <div class="health-item">
                <span>Attendance Rate</span>
                <strong>{{ $attendancePercentage ?? 0 }}%</strong>
            </div>

        </div>
    </div>

    <!-- WEEKLY ATTENDANCE -->
    <div class="panel">
        <div class="panel-hdr">
            <span class="panel-title">Weekly Attendance</span>
        </div>

<div class="chart-wrap simple-days">

    @foreach($attendanceChartLabels as $key => $label)

        <div class="day-item">

            <span class="day-label">
                {{ $label }}
            </span>

            <span class="day-value">
                {{ $attendanceChartData[$key] }}
            </span>

        </div>

    @endforeach

</div>
    </div>

</div>

<!-- ROW 3: Activity + Quick Actions -->
<div class="row3">

    <div class="panel">
        <div class="panel-hdr">
            <span class="panel-title">Attendance Insights</span>
        </div>

        <div class="act-list">

            <div class="act-item">
                <strong>{{ $presentToday ?? 0 }}</strong>
                students are present today
            </div>

            <div class="act-item">
                <strong>{{ $absentCount ?? 0 }}</strong>
                total absent records found
            </div>

            <div class="act-item">
                Attendance rate is
                <strong>{{ $attendancePercentage ?? 0 }}%</strong>
            </div>

            <div class="act-item">
                Total attendance records:
                <strong>{{ $totalAttendance ?? 0 }}</strong>
            </div>

        </div>
    </div>

    <div class="panel">
        <div class="panel-hdr">
            <span class="panel-title">Quick Actions</span>
        </div>

        <div class="qa-grid">

            <a href="{{ route('admin.attendance.index') }}" class="qa-btn">
                <svg viewBox="0 0 24 24">
                    <path d="M5 13l4 4L19 7"/>
                </svg>
                Mark Attendance
            </a>

            <a  href="{{ route('admin.students.index') }}" class="qa-btn">
                <svg viewBox="0 0 24 24">
                    <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                    <circle cx="8.5" cy="7" r="4"/>
                </svg>
                Add Student
            </a>

            <a  href="{{ route('admin.teachers.index') }}" class="qa-btn">
                <svg viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                </svg>
                Add Teacher
            </a>

            <button class="qa-btn">
                <svg viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                </svg>
                Export Report
            </button>

            <a href="{{ route('admin.products.index') }}" class="qa-btn">
                <svg viewBox="0 0 24 24">
                    <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                View Products
            </a>

            <a href="{{ route('admin.feedbacks.index') }}" class="qa-btn">
                <svg viewBox="0 0 24 24">
                    <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
                </svg>
                View Feedbacks
            </a>

        </div>
    </div>

</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    // PIE CHART
    const pieCtx = document.getElementById('attendancePieChart');

    new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: ['Present', 'Absent', 'Leave'],
            datasets: [{
                data: [
                    {{ $presentCount ?? 0 }},
                    {{ $absentCount ?? 0 }},
                    {{ $leaveCount ?? 0 }}
                ],
                backgroundColor: [
                    '#22c55e',
                    '#ef4444',
                    '#f59e0b'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // LINE CHART
    const lineCtx = document.getElementById('attendanceLineChart');

    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: @json($attendanceChartLabels),
            datasets: [{
                label: 'Attendance',
                data: @json($attendanceChartData),
                borderColor: '#185FA5',
                backgroundColor: 'rgba(24,95,165,0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#185FA5'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,

            scales: {
                y: {
                    beginAtZero: true
                }
            },

            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

</script>

@endsection