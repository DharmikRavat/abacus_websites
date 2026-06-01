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
        <div class="page-header">

            <h1 class="page-title">
                Score
            </h1>

            <p class="page-subtitle">
                View all exams and test scores.
            </p>

        </div>

        {{-- SCORE CARD --}}
        <div class="score-card">

            {{-- TABS --}}
            <div class="score-tabs">

                <button class="score-tab active" data-tab="practice">
                    Practice Score
                </button>

                <button class="score-tab" data-tab="test">
                    Online Test Score
                </button>

                <button class="score-tab" data-tab="exam">
                    Online Exam Score
                </button>

            </div>

            {{-- FILTERS --}}
            <div class="filter-wrap">

                <div class="filter-box">

                    <label class="filter-label">
                        Filter By Mode
                    </label>

                    <select class="filter-control" id="modeFilter">

                        <option value="">
                            All Modes
                        </option>

                        <option value="Easy">
                            Easy
                        </option>

                        <option value="Medium">
                            Medium
                        </option>

                        <option value="Hard">
                            Hard
                        </option>

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

        practice: [

            {
                type: 'Practice Score',
                mode: 'Easy',
                level: 'Level 0',
                date: '29 May 2026',
                total: 50,
                correct: 42,
                wrong: 5,
                skipped: 3
            },

            {
                type: 'Practice Score',
                mode: 'Medium',
                level: 'Level 1',
                date: '27 May 2026',
                total: 60,
                correct: 48,
                wrong: 8,
                skipped: 4
            }

        ],

        test: [

            {
                type: 'Online Test Score',
                mode: 'Easy',
                level: 'Level 2',
                date: '24 May 2026',
                total: 80,
                correct: 70,
                wrong: 6,
                skipped: 4
            },

            {
                type: 'Online Test Score',
                mode: 'Hard',
                level: 'Level 3',
                date: '20 May 2026',
                total: 100,
                correct: 78,
                wrong: 14,
                skipped: 8
            }

        ],

        exam: [

            {
                type: 'Online Exam Score',
                mode: 'Medium',
                level: 'Level 4',
                date: '15 May 2026',
                total: 150,
                correct: 120,
                wrong: 20,
                skipped: 10
            },

            {
                type: 'Online Exam Score',
                mode: 'Hard',
                level: 'Level 5',
                date: '10 May 2026',
                total: 200,
                correct: 160,
                wrong: 25,
                skipped: 15
            }

        ]

    };

    let currentTab = 'practice';

    const tableBody = document.getElementById('scoreTableBody');

    const tabs = document.querySelectorAll('.score-tab');

    const modeFilter = document.getElementById('modeFilter');

    const levelFilter = document.getElementById('levelFilter');

    function renderTable(){

        let data = scoreData[currentTab];

        const selectedMode = modeFilter.value;

        const selectedLevel = levelFilter.value;

        data = data.filter(item => {

            return (
                (selectedMode === '' || item.mode === selectedMode) &&
                (selectedLevel === '' || item.level === selectedLevel)
            );

        });

        if(data.length === 0){

            tableBody.innerHTML = `
                <tr>
                    <td colspan="8">
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

            tableBody.innerHTML += `

                <tr>

                    <td>
                        <span class="badge badge-type">
                            ${item.type}
                        </span>
                    </td>

                    <td>
                        <span class="badge badge-mode">
                            ${item.mode}
                        </span>
                    </td>

                    <td>
                        <span class="badge badge-level">
                            ${item.level}
                        </span>
                    </td>

                    <td>${item.date}</td>

                    <td>
                        <strong>${item.total}</strong>
                    </td>

                    <td class="correct">
                        ${item.correct}
                    </td>

                    <td class="wrong">
                        ${item.wrong}
                    </td>

                    <td class="skip">
                        ${item.skipped}
                    </td>

                </tr>

            `;

        });

    }

    tabs.forEach(tab => {

        tab.addEventListener('click', function(){

            tabs.forEach(btn => btn.classList.remove('active'));

            this.classList.add('active');

            currentTab = this.dataset.tab;

            modeFilter.value = '';
            levelFilter.value = '';

            renderTable();

        });

    });

    modeFilter.addEventListener('change', renderTable);

    levelFilter.addEventListener('change', renderTable);

    renderTable();

</script>

@endsection