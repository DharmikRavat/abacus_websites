@extends('client.layout.app')

@section('style')

    <style>
        .dash {
            padding: 30px 0 80px;
            min-height: 100vh;
            background: #f8fafc;
        }

        /* =========================
                PAGE HEADER
            ========================== */

        .page-header {
            margin-bottom: 24px;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 800;
            color: #111827;
            margin-bottom: 6px;
        }

        .page-subtitle {
            color: #6b7280;
            font-size: .95rem;
            margin: 0;
        }

        /* =========================
                CARD
            ========================== */

        .form-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(15, 23, 42, .06);
            border: 1px solid #edf2f7;
            overflow: hidden;
        }

        /* =========================
                BUTTONS
            ========================== */

        .btn-submit {
            height: 50px;
            padding: 0 22px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            color: #fff !important;
            font-weight: 700;
            font-size: .92rem;
            transition: .25s ease;
            box-shadow: 0 12px 25px rgba(37, 99, 235, .18);
            text-decoration: none;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 35px rgba(37, 99, 235, .25);
        }

        .btn-cancel {
            height: 50px;
            padding: 0 22px;
            border: 1px solid #2563eb;
            border-radius: 12px;
            background: transparent;
            color: #2563eb !important;
            font-weight: 700;
            font-size: .92rem;
            transition: .25s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-cancel:hover {
            background: #2563eb;
            color: #fff !important;
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(37, 99, 235, .18);
        }

        /* =========================
                TABLE
            ========================== */

        .table-responsive {
            overflow-x: auto;
        }

        .student-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .student-table thead {
            background: #f8fafc;
        }

        .student-table thead th {
            padding: 18px 20px;
            font-size: .82rem;
            font-weight: 700;
            color: #64748b;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .student-table tbody td {
            padding: 18px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            font-size: .92rem;
            color: #334155;
        }

        .student-table tbody tr {
            transition: .2s ease;
        }

        .student-table tbody tr:hover {
            background: #f8fbff;
        }

        /* =========================
                PROFILE IMAGE
            ========================== */

        .student-img {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: 0 5px 18px rgba(0, 0, 0, .08);
        }

        /* =========================
                BADGES
            ========================== */

        .badge {
            padding: 8px 14px;
            border-radius: 30px;
            font-size: .72rem;
            font-weight: 700;
        }

        .bg-success {
            background: #dcfce7 !important;
            color: #166534 !important;
        }

        .bg-danger {
            background: #fee2e2 !important;
            color: #991b1b !important;
        }

        /* =========================
                ACTION BUTTONS
            ========================== */

        .action-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: .2s ease;
            text-decoration: none;
        }

        .edit-btn {
            border: 1px solid #2563eb;
            color: #2563eb;
            background: #fff;
        }

        .edit-btn:hover {
            background: #2563eb;
            color: #fff;
        }

        .delete-btn {
            border: 1px solid #ef4444;
            color: #ef4444;
            background: #fff;
        }

        .delete-btn:hover {
            background: #ef4444;
            color: #fff;
        }


        .login-btn {
            height: 40px;
            padding: 0 18px;
            border-radius: 10px;
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            color: #fff !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: .85rem;
            font-weight: 600;
            text-decoration: none;
            transition: .2s ease;
            box-shadow: 0 8px 20px rgba(37, 99, 235, .15);
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(37, 99, 235, .25);
        }
        .practice-btn{
    display: flex;
    justify-content: center;
    align-items: center;
}

.practice-btn a{
    margin-top: 40px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    padding: 14px 28px;
    background: linear-gradient(135deg,#2563eb,#4f46e5);
    color: #fff;
    text-decoration: none;
    font-size: 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    transition: 0.3s ease;
    width: 100%;
}

.practice-btn a:hover{
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(37,99,235,0.25);
}


        /* =========================
                EMPTY STATE
            ========================== */

        .empty-state {
            padding: 60px 20px;
            text-align: center;
            
        }

        .empty-state img {
            width: 90px;
            margin-bottom: 16px;
            opacity: .85;
        }

        .empty-state h6 {
            font-size: 1rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 6px;
        }

        .empty-state p {
            color: #6b7280;
            margin: 0;
        }

        /* =========================
                MOBILE
            ========================== */

        @media(max-width:768px) {

            .dash {
                padding: 20px 0 60px;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .student-table thead th,
            .student-table tbody td {
                padding: 14px;
                font-size: .84rem;
            }

            .student-img {
                width: 42px;
                height: 42px;
            }

            .btn-submit {
                width: 100%;
                justify-content: center;
                margin-top: 15px;
            }

        }

        /* =========================
            SECTION
        ========================== */

        .content-area {
            padding: 35px 0 0;
        }

        .section-title {
            font-size: 1.9rem;
            font-weight: 700;
            color: #111;
            margin-bottom: 24px;
        }

        /* =========================
            MODE GRID
        ========================== */

        .mode-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 45px;
        }

        .mode-card {
            height: 50px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            font-weight: 700;
            cursor: pointer;
            transition: .25s ease;
            background: #fff;
        }

        .mode-card:hover {
            transform: translateY(-3px);
        }

        .mode-card.easy {
            /* background: #69c36d; */
            color: #fff;
            /* box-shadow: 0 10px 22px rgba(105, 195, 109, .25); */
        }

        .mode-card.medium {
            border: 3px solid #f4b13d;
            color: #f4b13d;
        }

        .mode-card.hard {
            border: 3px solid #e05a5a;
            color: #e05a5a;
        }

        /* =========================
            LEVEL GRID
        ========================== */

        .level-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
        }

        .level-card {
            height: 80px;
            border-radius: 24px;
            border: 3px solid #69c36d;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: .25s ease;
            cursor: pointer;
        }

        .level-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(105, 195, 109, .15);
        }

        .level-text {
            font-size: 1.7rem;
            font-weight: 700;
            color: #69c36d;
        }

        /* =========================
            MOBILE
        ========================== */

        @media(max-width:768px) {

            .top-header {
                padding: 18px 16px 65px;
            }

            .screen-title {
                font-size: 1.8rem;
            }

            .hero-card {
                border-radius: 24px;
                padding: 28px 18px;
            }

            .hero-title {
                font-size: 1.8rem;
            }

            .hero-subtitle {
                font-size: .95rem;
            }

            .section-title {
                font-size: 1.7rem;
            }

            .mode-grid {
                gap: 14px;
            }

            .mode-card {
                height: 82px;
                font-size: 1.5rem;
                border-radius: 20px;
            }

            .level-grid {
                gap: 16px;
            }

            .level-card {
                height: 125px;
                border-radius: 20px;
            }

            .level-text {
                font-size: 1.4rem;
            }
            .practice-btn a{
                font-size: 1.rem;
            }

        }
    /* =========================
    MODE CARD
========================== */

.mode-card{
    height: 50px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    font-weight: 700;
    cursor: pointer;
    transition: .25s ease;
    background: #fff;
    border: 3px solid transparent;
}

.mode-card:hover{
    transform: translateY(-3px);
}

/* EASY */
.mode-card.easy{
    border-color: #69c36d;
    color: #69c36d;
    
}

.mode-card.easy.active{
    background: #69c36d;
    color: #fff;
    box-shadow: 0 10px 22px rgba(105,195,109,.25);
}

/* MEDIUM */
.mode-card.medium{
    border-color: #f4b13d;
    color: #f4b13d;
}

.mode-card.medium.active{
    background: #f4b13d;
    color: #fff;
    box-shadow: 0 10px 22px rgba(244,177,61,.25);
}

/* HARD */
.mode-card.hard{
    border-color: #e05a5a;
    color: #e05a5a;
}

.mode-card.hard.active{
    background: #e05a5a;
    color: #fff;
    box-shadow: 0 10px 22px rgba(224,90,90,.25);
}

/* =========================
    ACTIVE LEVEL
========================== */

.level-card.active{
    background: #69c36d;
    border-color: #69c36d;
}

.level-card.active .level-text{
    color: #fff;
}

/* =========================
    DISABLED BUTTON
========================== */

.disabled-btn{
    opacity: .5;
    pointer-events: none;
    cursor: not-allowed;
}
    </style>

@endsection


@section('content')

    <div class="dash">

        <div class="container">

            {{-- PAGE HEADER --}}
            <div class="page-header d-flex justify-content-between align-items-center flex-wrap">

                <div>

                    <h1 class="page-title">
                        Start Practice
                    </h1>

                    <p class="page-subtitle">
                        Select the appropriate level
                    </p>

                </div>

            </div>

            {{-- Grid Level --}}
            {{-- CONTENT --}}
            <div class="content-area">
                <div class="container"> {{-- MODE --}}
<div class="mb-5">
    <h3 class="section-title">Choose Mode</h3>

    <div class="mode-grid">
        <div class="mode-card easy" data-mode="Easy">Easy</div>
        <div class="mode-card medium" data-mode="Medium">Medium</div>
        <div class="mode-card hard" data-mode="Hard">Hard</div>
    </div>
</div>
                    {{-- LEVEL --}}
<div>
    <h3 class="section-title">Choose Level</h3>

    <div class="level-grid">
        @for($i = 0; $i <= 10; $i++)
            <div class="level-card" data-level="{{ $i }}">
                <div class="level-text">
                    Level {{ $i }}
                </div>
            </div>
        @endfor
    </div>
</div>
                </div>
            </div>

            {{-- Next Button  --}}
<div class="practice-btn">
    <a href="javascript:void(0)" id="startPracticeBtn" class="disabled-btn">
        Start Practice
    </a>
</div>

        </div>

    </div>


@endsection



@section('script')

   
<script>

    let selectedMode = '';
    let selectedLevel = '';

    // SELECT MODE
    $('.mode-card').on('click', function () {

        $('.mode-card').removeClass('active');

        $(this).addClass('active');

        selectedMode = $(this).data('mode');

        checkSelection();

    });

    // SELECT LEVEL
    $('.level-card').on('click', function () {

        $('.level-card').removeClass('active');

        $(this).addClass('active');

        selectedLevel = $(this).data('level');

        checkSelection();

    });

    // ENABLE BUTTON IF BOTH SELECTED
    function checkSelection() {

        if (selectedMode !== '' && selectedLevel !== '') {

            $('#startPracticeBtn').removeClass('disabled-btn');

        } else {

            $('#startPracticeBtn').addClass('disabled-btn');

        }

    }

    // START PRACTICE CLICK
    $('#startPracticeBtn').on('click', function () {

        if (selectedMode === '' || selectedLevel === '') {

            alert('Please select Mode and Level');

            return;

        }

        alert(
            'Mode: ' + selectedMode +
            '\nLevel: ' + selectedLevel
        );
        window.location.href = "/exam-sheet";

        // Example redirect
        // window.location.href = "/practice?mode=" + selectedMode + "&level=" + selectedLevel;

    });

</script>
@endsection