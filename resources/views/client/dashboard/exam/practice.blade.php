@extends('client.layout.app')

@section('style')

    <style>
        .dash {
            padding: 20px 0 35px;
            min-height: calc(100vh - 160px);
            background: #f8fafc;
            display: flex;
            align-items: center;
        }

        .practice-wrapper {
            max-width: 780px;
            width: 100%;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 20px;
            padding: 24px 30px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05), 0 1px 3px rgba(0, 0, 0, 0.03);
            border: 1px solid #eef2f6;
        }

        /* PAGE HEADER */
        .page-header {
            margin-bottom: 24px;
        }

        .back-arrow-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #334155;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            flex-shrink: 0;
        }

        .back-arrow-btn:hover {
            background: #2563eb;
            border-color: #2563eb;
            color: #ffffff !important;
            transform: translateX(-3px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        .page-title {
            font-size: 1.55rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 2px;
            letter-spacing: -0.02em;
        }

        .page-subtitle {
            color: #64748b;
            font-size: 0.88rem;
            margin: 0;
        }

        /* SECTION TITLES */
        .section-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title::before {
            content: "";
            display: inline-block;
            width: 4px;
            height: 16px;
            background: #2563eb;
            border-radius: 4px;
        }

        .practice-section {
            margin-bottom: 15px;
        }

        .practice-section:last-of-type {
            margin-bottom: 18px;
        }

        /* MODE GRID */
        .mode-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .mode-card {
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            background: #fff;
            border: 2px solid transparent;
            user-select: none;
        }

        .mode-card:hover {
            transform: translateY(-2px);
        }

        /* EASY */
        .mode-card.easy {
            border-color: #22c55e;
            color: #16a34a;
            background: #f0fdf4;
        }
        .mode-card.easy:hover {
            background: #dcfce7;
        }
        .mode-card.easy.active {
            background: #22c55e;
            color: #fff;
            border-color: #22c55e;
            box-shadow: 0 4px 14px rgba(34, 197, 94, 0.35);
        }

        /* MEDIUM */
        .mode-card.medium {
            border-color: #f59e0b;
            color: #d97706;
            background: #fffbeb;
        }
        .mode-card.medium:hover {
            background: #fef3c7;
        }
        .mode-card.medium.active {
            background: #f59e0b;
            color: #fff;
            border-color: #f59e0b;
            box-shadow: 0 4px 14px rgba(245, 158, 11, 0.35);
        }

        /* HARD */
        .mode-card.hard {
            border-color: #ef4444;
            color: #dc2626;
            background: #fef2f2;
        }
        .mode-card.hard:hover {
            background: #fee2e2;
        }
        .mode-card.hard.active {
            background: #ef4444;
            color: #fff;
            border-color: #ef4444;
            box-shadow: 0 4px 14px rgba(239, 68, 68, 0.35);
        }

        /* LEVEL GRID - 6 columns so levels 0-10 fit in only 2 compact rows! */
        .level-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 10px;
        }

        .level-card {
            height: 44px;
            border-radius: 12px;
            border: 2px solid #22c55e;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            user-select: none;
        }

        .level-card:hover {
            transform: translateY(-2px);
            background: #f0fdf4;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.2);
        }

        .level-card.active {
            background: #22c55e;
            border-color: #22c55e;
            box-shadow: 0 4px 14px rgba(34, 197, 94, 0.35);
        }

        .level-text {
            font-size: 1.15rem;
            font-weight: 700;
            color: #16a34a;
            transition: color 0.2s ease;
        }

        .level-card.active .level-text {
            color: #ffffff;
        }

        /* DURATION GRID */
        .duration-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .time-card {
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eef2ff;
            color: #4338ca;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            user-select: none;
        }

        .time-card:hover {
            transform: translateY(-2px);
            background: #e0e7ff;
        }

        .time-card.active {
            background: #3730a3 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(55, 48, 163, 0.3);
        }

        /* PRACTICE SUBMIT BUTTON */
        .practice-btn a {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 48px;
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            color: #ffffff;
            text-decoration: none;
            font-size: 1.1rem;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.25s ease;
            width: 100%;
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.25);
            letter-spacing: 0.01em;
        }

        .practice-btn a:hover:not(.disabled-btn) {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.35);
            color: #ffffff;
        }

        .disabled-btn {
            opacity: 0.45;
            pointer-events: none;
            cursor: not-allowed;
            box-shadow: none !important;
        }

        @media (max-width: 768px) {
            .dash {
                padding: 16px 12px 25px;
                display: block;
            }

            .practice-wrapper {
                padding: 20px 16px;
                border-radius: 16px;
            }

            .page-title {
                font-size: 1.35rem;
            }

            .level-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 8px;
            }

            .mode-card {
                height: 40px;
                font-size: 0.92rem;
            }

            .level-card {
                height: 40px;
            }

            .level-text {
                font-size: 1.05rem;
            }

            .time-card {
                height: 38px;
                font-size: 0.88rem;
            }

            .practice-btn a {
                height: 44px;
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .level-grid {
                grid-template-columns: repeat(3, 1fr);
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
                            Start Practice
                        </h1>
                        <p class="page-subtitle">
                            Select the appropriate level
                        </p>
                    </div>
                </div>

            <div class="practice-wrapper">

                {{-- CONTENT --}}
                <div class="content-area">
                    {{-- MODE --}}
                    <div class="practice-section">
                        <h3 class="section-title">Choose Mode</h3>
                        <div class="mode-grid">
                            @foreach($modes as $mode)
                                <div class="mode-card {{ strtolower($mode->name) }}" data-mode="{{ $mode->id }}" data-name="{{ strtolower($mode->name) }}">
                                    {{ $mode->name }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- LEVEL --}}
                    <div class="practice-section">
                        <h3 class="section-title">Choose Level</h3>
                        <div class="level-grid" id="levelGrid">
                            @foreach($levels as $level)
                                <div class="level-card" data-level="{{ $level->id }}" data-difficulty="{{ strtolower($level->difficulty) }}" @if(strtolower($level->difficulty) !== 'easy') style="display: none;" @endif>
                                    <div class="level-text">
                                        {{ $level->level }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- DURATION --}}
                    <div class="practice-section">
                        <h3 class="section-title">Choose Duration</h3>
                        <div class="duration-grid" id="durationGrid">
                            @foreach($durations as $duration)
                                <div class="time-card" data-time="{{ $duration->duration_minutes }}">
                                    {{ $duration->duration_minutes }} Minutes
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Next Button --}}
                <div class="practice-btn">
                    <a href="javascript:void(0)" id="startPracticeBtn" class="disabled-btn">
                        Start Practice
                    </a>
                </div>

            </div>

        </div>

    </div>

@endsection



@section('script')

<script>

    let selectedMode = '';
    let selectedModeName = '';
    let selectedLevel = '';
    let selectedTime = '';

    // SELECT MODE
    $('.mode-card').on('click', function () {

        $('.mode-card').removeClass('active');
        $(this).addClass('active');

        selectedMode = $(this).data('mode');
        selectedModeName = $(this).data('name');

        // Reset level selection
        $('.level-card').removeClass('active');
        selectedLevel = '';

        // Reset time selection
        $('.time-card').removeClass('active');
        selectedTime = '';

        // Hide all levels first
        $('.level-card').hide();

        // Show only the levels matching the selected mode
        $('.level-card[data-difficulty="'+selectedModeName+'"]').show();

        checkSelection();

    });

    // SELECT LEVEL
    $('.level-card').on('click', function () {

        $('.level-card').removeClass('active');
        $(this).addClass('active');

        selectedLevel = $(this).data('level');

        // Reset time selection
        $('.time-card').removeClass('active');
        selectedTime = '';

        checkSelection();

    });

    // SELECT TIME
    $('.time-card').on('click', function () {
        $('.time-card').removeClass('active');
        $(this).addClass('active');

        selectedTime = $(this).data('time');

        checkSelection();
    });

    // ENABLE BUTTON IF ALL SELECTED
    function checkSelection() {

        if (selectedMode !== '' && selectedLevel !== '' && selectedTime !== '') {
            $('#startPracticeBtn').removeClass('disabled-btn');
        } else {
            $('#startPracticeBtn').addClass('disabled-btn');
        }

    }

    // START PRACTICE CLICK
    $('#startPracticeBtn').on('click', function () {

        if (selectedMode === '' || selectedLevel === '' || selectedTime === '') {
            alert('Please select Mode, Level, and Duration');
            return;
        }

        // Redirect with query parameters
        window.location.href = "/exam-sheet?mode=" + selectedMode + "&level=" + selectedLevel + "&time=" + selectedTime;

    });

</script>
@endsection