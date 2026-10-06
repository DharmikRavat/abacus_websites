@extends('client.layout.app')

@section('style')

<style>

    .dash{
        padding: 30px 0 80px;
        min-height: 100vh;
        background: #f8fafc;
    }

    /* =========================
        PAGE HEADER
    ========================== */

    .page-header{
        margin-bottom: 24px;
    }

    .back-arrow-btn {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #334155;
        font-size: 1.05rem;
        text-decoration: none;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.05);
        flex-shrink: 0;
    }

    .back-arrow-btn:hover {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff !important;
        transform: translateX(-3px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    .page-title{
        font-size: 2rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 6px;
    }

    .page-subtitle{
        color: #6b7280;
        font-size: .95rem;
        margin: 0;
    }

    /* =========================
        CARD
    ========================== */

    .score-card{
        background: #fff;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 10px 25px rgba(0,0,0,.05);
    }

    /* =========================
        TABS
    ========================== */

    .score-tabs{
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .score-tab{
        border: none;
        padding: 12px 22px;
        border-radius: 12px;
        background: #eef2ff;
        color: #4338ca;
        font-weight: 700;
        cursor: pointer;
        transition: .2s ease;
    }

    .score-tab.active{
        background: linear-gradient(135deg,#2563eb,#4f46e5);
        color: #fff;
    }

    /* =========================
        FILTERS
    ========================== */

    .filter-wrap{
        display: flex;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .filter-box{
        min-width: 220px;
        flex: 1;
    }

    .filter-label{
        display: block;
        margin-bottom: 8px;
        font-size: .85rem;
        font-weight: 600;
        color: #6b7280;
    }

    .filter-control{
        width: 100%;
        height: 48px;
        border-radius: 12px;
        border: 1px solid #dbe3ef;
        padding: 0 14px;
        font-size: .92rem;
        outline: none;
        transition: .2s ease;
    }

    .filter-control:focus{
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79,70,229,.08);
    }

    /* =========================
        TABLE
    ========================== */

    .table-wrap{
        overflow-x: auto;
    }

    .score-table{
        width: 100%;
        border-collapse: collapse;
        min-width: 850px;
    }

    .score-table thead th{
        background: #f3f4f6;
        padding: 14px;
        font-size: .85rem;
        color: #6b7280;
        text-transform: uppercase;
        font-weight: 700;
    }

    .score-table tbody td{
        padding: 16px 14px;
        border-bottom: 1px solid #eef2f7;
        font-size: .92rem;
        color: #111827;
    }

    .badge{
        padding: 7px 14px;
        border-radius: 999px;
        font-size: .78rem;
        font-weight: 700;
        display: inline-block;
    }

    .badge-type{
        background: rgba(79,70,229,.12);
        color: #4f46e5;
    }

    .badge-mode{
        background: rgba(37,99,235,.10);
        color: #2563eb;
    }

    .badge-level{
        background: rgba(16,185,129,.12);
        color: #059669;
    }

    .correct{
        color: #16a34a;
        font-weight: 700;
    }

    .wrong{
        color: #dc2626;
        font-weight: 700;
    }

    .skip{
        color: #d97706;
        font-weight: 700;
    }

    .empty{
        text-align: center;
        padding: 30px;
        color: #6b7280;
        font-weight: 600;
    }

    @media(max-width:768px){

        .score-tab{
            width: 100%;
        }

        .filter-box{
            min-width: 100%;
        }

    }

</style>

@endsection


@section('content')

<div class="dash">

    <div class="container">

        {{-- PAGE HEADER --}}
        <div class="page-header d-flex align-items-center gap-3">
            <a href="{{ route('dashboard.index') }}" class="back-arrow-btn" title="Back to Dashboard">
                <i class="fa fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="page-title">
                    Score
                </h1>
                <p class="page-subtitle">
                    View all exams and test scores.
                </p>
            </div>
        </div>

        {{-- SCORE CARD --}}
        <div class="score-card">

            {{-- TABS --}}
            <div class="score-tabs">

                @if(request('tab', 'practice') == 'practice')
                <button class="score-tab active" data-tab="practice">
                    Practice Score
                </button>
                @endif

                @if(request('tab') == 'test')
                <button class="score-tab active" data-tab="test">
                    Online Test Score
                </button>
                @endif

                @if(request('tab') == 'exam')
                <button class="score-tab active" data-tab="exam">
                    Online Exam Score
                </button>
                @endif

            </div>

            {{-- FILTERS --}}
            <div class="filter-wrap">

                <div class="filter-box">

                    <label class="filter-label">
                        Filter By Mode
                    </label>

                    <select class="filter-control" id="modeFilter">

                        <option value="">All Modes</option>

                    </select>

                </div>

                <div class="filter-box">

                    <label class="filter-label">
                        Filter By Level
                    </label>

                    <select class="filter-control" id="levelFilter">

                        <option value="">
                            All Levels
                        </option>

                        <option value="Level 0">
                            Level 0
                        </option>

                        <option value="Level 1">
                            Level 1
                        </option>

                        <option value="Level 2">
                            Level 2
                        </option>

                        <option value="Level 3">
                            Level 3
                        </option>

                        <option value="Level 4">
                            Level 4
                        </option>

                        <option value="Level 5">
                            Level 5
                        </option>

                    </select>

                </div>

                <div class="filter-box">
                    <label class="filter-label">Filter By Date</label>
                    <input type="date" class="filter-control" id="dateFilter">
                </div>

            </div>

            {{-- TABLE --}}
            <div class="table-wrap">

                <table class="score-table">

                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Mode</th>
                            <th>Level</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Total</th>
                            <th>Correct</th>
                            <th>Wrong</th>
                            <th>Skipped</th>
                        </tr>
                    </thead>

                    <tbody id="scoreTableBody">

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection



@section('script')

<script>

    const scoreData = {
        practice: {!! json_encode($practiceArray ?? []) !!},
        test: {!! json_encode($testArray ?? []) !!},
        exam: {!! json_encode($examArray ?? []) !!}
    };

    let currentTab = "{{ request('tab', 'practice') }}";

    const tableBody = document.getElementById('scoreTableBody');

    const tabs = document.querySelectorAll('.score-tab');

    const modeFilter = document.getElementById('modeFilter');

    const levelFilter = document.getElementById('levelFilter');
    const dateFilter = document.getElementById('dateFilter');

    function renderTable(){

        let data = scoreData[currentTab];

        const selectedMode = modeFilter.value;
        const selectedLevel = levelFilter.value;
        const selectedDate = dateFilter.value;

        data = data.filter(item => {

            let itemDate = item.raw_date;
            if (!itemDate && item.date) {
                let d = new Date(item.date);
                if (!isNaN(d)) {
                    let month = '' + (d.getMonth() + 1);
                    let day = '' + d.getDate();
                    let year = d.getFullYear();
                    if (month.length < 2) month = '0' + month;
                    if (day.length < 2) day = '0' + day;
                    itemDate = [year, month, day].join('-');
                }
            }

            return (
                (selectedMode === '' || item.mode === selectedMode) &&
                (selectedLevel === '' || item.level === selectedLevel) &&
                (selectedDate === '' || itemDate === selectedDate)
            );

        });

        if(data.length === 0){
            tableBody.innerHTML = `
                <tr>
                    <td colspan="9">
                        <div class="empty">
                            No Data Found
                        </div>
                    </td>
                </tr>
            `;
            return;
        }

        tableBody.innerHTML = '';

        data.forEach(item => {
            if (item.is_pending) {
                tableBody.innerHTML += `
                    <tr>
                        <td colspan="9">
                            <div class="empty" style="color: #ea580c; background: #fff7ed; padding: 15px; border-radius: 8px;">
                                <i class="fa fa-clock" style="margin-right: 5px;"></i>
                                Result Pending<br>
                                <span style="font-size: 13px; color: #9a3412;">
                                    Your Online Exam was completed successfully.<br>
                                    Your result will be available on: <strong>${item.result_available_at}</strong>
                                </span>
                            </div>
                        </td>
                    </tr>
                `;
            } else {
                let total = item.is_visible == 0 ? '-' : item.total;
                let correct = item.is_visible == 0 ? '-' : item.correct;
                let wrong = item.is_visible == 0 ? '-' : item.wrong;
                let skipped = item.is_visible == 0 ? '-' : item.skipped;

                tableBody.innerHTML += `
                    <tr>
                        <td><span class="badge badge-type">${item.type}</span></td>
                        <td><span class="badge badge-mode">${item.mode}</span></td>
                        <td><span class="badge badge-level">${item.level}</span></td>
                        <td>${item.date}</td>
                        <td>${item.time ?? '-'}</td>
                        <td><strong>${total}</strong></td>
                        <td class="correct">${correct}</td>
                        <td class="wrong">${wrong}</td>
                        <td class="skip">${skipped}</td>
                    </tr>
                `;
            }
        });

    }

    function updateModeOptions() {
        let options = '<option value="">All Modes</option>';
        if (currentTab === 'practice') {
            options += '<option value="Easy">Easy</option>';
            options += '<option value="Medium">Medium</option>';
            options += '<option value="Hard">Hard</option>';
        } else if (currentTab === 'test') {
            options += '<option value="Weekly">Weekly</option>';
            options += '<option value="Monthly">Monthly</option>';
        } else if (currentTab === 'exam') {
            options += '<option value="Olympiad">Olympiad</option>';
            options += '<option value="Final Exam">Final Exam</option>';
        }
        modeFilter.innerHTML = options;
    }

    tabs.forEach(tab => {

        tab.addEventListener('click', function(){

            tabs.forEach(btn => btn.classList.remove('active'));

            this.classList.add('active');

            currentTab = this.dataset.tab;

            updateModeOptions();
            modeFilter.value = '';
            levelFilter.value = '';
            dateFilter.value = '';

            renderTable();

        });

    });

    modeFilter.addEventListener('change', renderTable);
    levelFilter.addEventListener('change', renderTable);
    dateFilter.addEventListener('change', renderTable);

    updateModeOptions();
    renderTable();

</script>

@endsection