@extends('client.layout.app')

@section('style')

    <style>
        .dash {
            height: 100vh;
            min-height: 100vh;
            padding: 12px 16px;
            background: url("{{ asset('client/img/quiz-bg.png') }}") center bottom / cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
            overflow: hidden;
        }

        /* =========================
            HIDE GLOBAL NAV FOR EXAM MODE
        ========================== */
        header, footer, .header-banner, .header-logo-menu, .app-download-area, .floating-whatsapp {
            display: none !important;
        }

        .dash .container {
            max-width: 680px;
            margin: 0 auto;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* =========================
            PAGE HEADER
        ========================== */
        .page-header {
            margin-bottom: 8px;
            text-align: center;
        }

        .page-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 2px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
        }

        .page-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.82rem;
            margin: 0;
        }

        /* =========================
            PRACTICE SCREEN
        ========================== */
        .practice-screen {
            width: 100%;
            max-width: 620px;
            margin: 0 auto;
            background-color: #0b0f19 !important;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
            border-radius: 18px;
            padding: 18px 24px;
            box-sizing: border-box;
        }

        /* =========================
            TOP BOX
        ========================== */
        .top-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .exit-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .exit-btn:hover {
            background: #ef4444;
            border-color: #ef4444;
            color: #ffffff !important;
            transform: scale(1.06);
        }

        .timer-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.6rem;
            font-weight: 800;
            color: #ffffff;
        }

        .timer-wrap i {
            color: #f59e0b;
            font-size: 1.35rem;
        }

        .sound-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #22c55e;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.15rem;
            cursor: pointer;
            transition: .2s ease;
        }

        .sound-btn:hover {
            transform: scale(1.06);
        }

        /* =========================
            PROGRESS
        ========================== */
        .progress-wrap {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 12px;
        }

        .progress-bar-custom {
            width: 75%;
            height: 100%;
            background: #facc15;
            border-radius: 20px;
        }

        /* =========================
            QUESTION CARD
        ========================== */
        .question-card {
            background: transparent;
            text-align: center;
            margin-bottom: 12px;
            position: relative;
        }

        .question-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #94a3b8;
            margin-bottom: 8px;
        }

        .question-center-wrap {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 4px 10px;
        }

        .question-numbers {
            display: inline-flex;
            flex-direction: column;
            align-items: flex-end;
            margin: 0 auto;
        }

        .question-numbers div {
            font-size: 1.85rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.3;
            letter-spacing: 0.05em;
        }

        /* =========================
            ANSWERS
        ========================== */
        .answers-title {
            color: #94a3b8;
            font-size: 0.95rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 10px;
        }

        .answer-grid {
            display: flex;
            justify-content: center;
            gap: 14px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .answer-card {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1.35rem;
            font-weight: 700;
            color: #ffffff;
            cursor: pointer;
            transition: .2s ease;
            padding: 8px 16px;
            border-radius: 10px;
            border: 1.5px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.05);
            user-select: none;
        }

        .answer-card:hover {
            border-color: rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.1);
        }

        .answer-card .checkbox {
            width: 20px;
            height: 20px;
            border: 2px solid #ffffff;
            border-radius: 4px;
            background: transparent;
            display: inline-block;
        }

        .answer-card.active-answer {
            border-color: #22c55e;
            background: rgba(34, 197, 94, 0.2);
        }

        .answer-card.active-answer .checkbox {
            background: #22c55e;
            border-color: #22c55e;
        }

        /* =========================
            ACTION BUTTONS
        ========================== */
        .action-wrap {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 8px;
            max-width: 360px;
            margin-left: auto;
            margin-right: auto;
            width: 100%;
        }

        .action-btn {
            height: 42px;
            border: none;
            color: #fff;
            font-size: 0.95rem;
            font-weight: 700;
            text-transform: uppercase;
            cursor: pointer;
            border-radius: 10px;
            transition: .2s ease;
            letter-spacing: 0.03em;
        }

        .action-btn:hover {
            filter: brightness(1.1);
            transform: translateY(-1px);
        }

        .prev-btn {
            background: #3b82f6;
        }

        .next-btn {
            background: #10b981;
        }

        /* =========================
            FINISH BUTTON
        ========================== */
        .finish-btn {
            width: 100%;
            max-width: 360px;
            height: 42px;
            border: none;
            background: #f97316;
            color: #fff;
            font-size: 0.95rem;
            font-weight: 700;
            text-transform: uppercase;
            margin: 0 auto;
            display: block;
            cursor: pointer;
            border-radius: 10px;
            transition: .2s ease;
            letter-spacing: 0.03em;
        }

        .finish-btn:hover {
            filter: brightness(1.1);
            transform: translateY(-1px);
        }

        /* =========================
            MOBILE
        ========================== */
        @media (max-width: 768px) {
            .dash {
                padding: 10px 12px;
            }

            .practice-screen {
                padding: 14px 16px;
                border-radius: 14px;
            }

            .page-title {
                font-size: 1.15rem;
            }

            .question-numbers div {
                font-size: 1.6rem;
            }

            .answer-card {
                padding: 6px 12px;
                font-size: 1.2rem;
            }

            .action-btn,
            .finish-btn {
                height: 38px;
                font-size: 0.88rem;
            }
        }
    </style>

@endsection


@section('content')

    <div class="dash">

        <div class="container">

            {{-- PAGE HEADER --}}
            <div class="page-header">

                <div>

                    <h1 class="page-title">
                        @if(isset($schedule) && $schedule)
                            @if(strtolower($schedule->test_type) == 'test')
                                Start Online Test
                            @else
                                Start Online Exam
                            @endif
                        @else
                            Start Practice
                        @endif
                    </h1>

                    <p class="page-subtitle">
                        @if(isset($schedule) && $schedule)
                            {{ ucwords(str_replace('_', ' ', $schedule->schedule_exam_type)) }} - {{ $schedule->exam_level }}
                        @else
                            Select the appropriate level
                        @endif
                    </p>

                </div>

            </div>


            {{-- CONTENT --}}
            <div class="practice-screen">

                {{-- TOP BAR --}}
                <div class="top-box">

                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('dashboard.index') }}" class="exit-btn" onclick="return confirm('Are you sure you want to exit to Dashboard?');" title="Back to Dashboard">
                            <i class="fa fa-arrow-left"></i>
                        </a>

                        <div class="timer-wrap">
                            <i class="fa fa-clock"></i>
                            <span id="timerDisplay">{{ str_pad($minutes ?? 3, 2, '0', STR_PAD_LEFT) }}:00</span>
                        </div>
                    </div>

                    <div class="sound-btn" onclick="speakQuestion()" title="Speak Question">
                        <i class="fa fa-volume-up"></i>
                    </div>

                </div>

                {{-- PROGRESS --}}
                <div class="progress-wrap">
                    <div class="progress-bar-custom"></div>
                </div>

                {{-- QUESTION CARD --}}
                <div class="question-card">

                    <h3 class="question-title">
                        Question: 1
                    </h3>

                    <div class="question-center-wrap">

                        <div class="question-numbers" id="questionText">
                            <div>+4</div>
                            <div>-3</div>
                            <div>-1</div>
                        </div>

                    </div>

                </div>

                <div class="answers-title">Answers :</div>

                {{-- ANSWERS --}}
                <div class="answer-grid">

                    <div class="answer-card"><div class="checkbox"></div> 0</div>
                    <div class="answer-card"><div class="checkbox"></div> 2</div>
                    <div class="answer-card"><div class="checkbox"></div> 1</div>
                    <div class="answer-card"><div class="checkbox"></div> 3</div>

                </div>

                {{-- ACTION BUTTONS --}}
                <div class="action-wrap">

                    <button class="action-btn prev-btn">
                        PREVIOUS
                    </button>

                    <button class="action-btn next-btn">
                        NEXT
                    </button>

                </div>

                {{-- FINISH --}}
                <button class="finish-btn">
                    FINISH
                </button>

            </div>


        </div>

    </div>

<!-- SUCCESS MODAL -->
<div id="successModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:99999; align-items:center; justify-content:center;">
    <div style="background:#fff; padding:30px; border-radius:15px; width:90%; max-width:400px; text-align:center; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
        @php
            $modalTitle = 'Practice Completed!';
            $examTypeToSave = 'practice';
            if (isset($schedule) && $schedule) {
                if (strtolower($schedule->test_type) == 'test') {
                    $modalTitle = 'Online Test Completed!';
                    $examTypeToSave = 'test';
                } else {
                    $modalTitle = 'Online Exam Completed!';
                    $examTypeToSave = 'exam';
                }
            }
        @endphp
        <h2 style="color:#2563eb; margin-bottom:20px;">{{ $modalTitle }}</h2>

        @if(isset($schedule) && $schedule)
            <div style="text-align:left; background:#f8fafc; padding:15px; border-radius:10px; margin-bottom:15px; font-size:14px; line-height:1.6;">
                <strong>Test:</strong> {{ ucfirst($schedule->test_type) }}<br>
                <strong>Level:</strong> {{ $schedule->exam_level }}<br>
                <strong>Exam Type:</strong> {{ ucwords(str_replace('_', ' ', $schedule->schedule_exam_type)) }}<br>
                <strong>Date:</strong> {{ \Carbon\Carbon::parse($schedule->schedule_date)->format('M d, Y') }}<br>
                <strong>Questions:</strong> {{ $schedule->no_of_questions }}<br>
                <strong>Duration:</strong> {{ intval($minutes) }} Minutes<br>
            </div>
        @endif

        <div style="text-align:left; background:#f8fafc; padding:15px; border-radius:10px; margin-bottom:20px; font-size:16px; line-height:1.8;">
            <strong>Total Questions:</strong> <span id="modalTotal"></span><br>
            <strong style="color:#16a34a;">Correct Answers:</strong> <span id="modalCorrect" style="color:#16a34a; font-weight:bold;"></span><br>
            <strong style="color:#dc2626;">Wrong Answers:</strong> <span id="modalWrong" style="color:#dc2626; font-weight:bold;"></span><br>
            <strong style="color:#d97706;">Skipped:</strong> <span id="modalSkipped" style="color:#d97706; font-weight:bold;"></span>
        </div>

        @php
            $redirectTab = 'practice';
            if (isset($schedule) && $schedule) {
                $redirectTab = strtolower($schedule->test_type);
            }
        @endphp
        <button onclick="window.location.href='/score-sheet?tab={{ $redirectTab }}'" style="background:#2563eb; color:#fff; border:none; padding:10px 20px; border-radius:8px; font-weight:bold; cursor:pointer; width:100%;">
            View Score Sheet
        </button>
    </div>
</div>

@endsection



@section('script')


<script>

    const questions = {!! json_encode($dynamicQuestions ?? []) !!};

    /* ======================================
        VARIABLES
    ====================================== */

    let currentQuestion = 0;

    let totalTime = ({{ $minutes ?? 3 }} * 60) + {{ $seconds ?? 0 }};
    let timeLeft = totalTime;

    /* ======================================
        LOAD QUESTION
    ====================================== */

    function loadQuestion() {

        if (questions.length === 0) {
            $('.question-title').text('No questions found');
            $('#questionText').html('<div style="text-align:center; padding: 20px;">No questions available.</div>');
            $('.answer-grid').html('');
            return;
        }

        let q = questions[currentQuestion];

        // Question Number
        $('.question-title').text(
            'Question: ' + (currentQuestion + 1)
        );

        // Question Values
        let questionHtml = '';

        q.question.forEach(item => {

            questionHtml += `
                <div>${item}</div>
            `;

        });

        $('#questionText').html(questionHtml);

        // Answers
        let answerHtml = '';

        q.answers.forEach(answer => {
            let activeClass = (q.user_answer !== undefined && q.user_answer == answer) ? 'active-answer' : '';
            answerHtml += `
                <div class="answer-card ${activeClass}">
                    <div class="checkbox"></div> ${answer}
                </div>
            `;

        });

        $('.answer-grid').html(answerHtml);

        // Progress
        updateQuestionProgress();

        // Buttons
        updateButtons();

    }

    /* ======================================
        QUESTION PROGRESS
    ====================================== */

    function updateQuestionProgress() {

        let progress =
            ((currentQuestion + 1) / questions.length) * 100;

        $('.progress-bar-custom').css(
            'width',
            progress + '%'
        );

    }

    /* ======================================
        TIMER
    ====================================== */

    function startTimer() {

        window.quizTimer = setInterval(() => {

            if (timeLeft <= 0) {

                clearInterval(window.quizTimer);

                alert('Time Finished');
                calculateScore();

                return;

            }

            timeLeft--;

            let minutes = Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;

            minutes = String(minutes).padStart(2, '0');
            seconds = String(seconds).padStart(2, '0');

            $('.timer-wrap span').text(
                `${minutes}:${seconds}`
            );

            // Reduce progress based on time
            let width = (timeLeft / totalTime) * 100;

            $('.progress-bar-custom').css(
                'width',
                width + '%'
            );

        }, 1000);

    }

    /* ======================================
        SPEAK QUESTION
    ====================================== */

    function speakQuestion() {

        let q = questions[currentQuestion];

        let text = q.question.join(' ... ');

        text = text
            .replaceAll('+', 'Plus ')
            .replaceAll('-', 'Minus ');

        let speech =
            new SpeechSynthesisUtterance(text);

        speech.lang = "en-US";
        speech.rate = 0.75;
        speech.pitch = 1.3;
        speech.volume = 1;

        let voices =
            window.speechSynthesis.getVoices();

        let femaleVoice = voices.find(voice =>
            voice.name.includes('Female') ||
            voice.name.includes('Samantha') ||
            voice.name.includes('Google UK English Female') ||
            voice.name.includes('Karen')
        );

        if (femaleVoice) {

            speech.voice = femaleVoice;

        }

        window.speechSynthesis.cancel();

        window.speechSynthesis.speak(speech);

    }

    /* ======================================
        ANSWER SELECTION
    ====================================== */

    // ================== CLICKS ================== //

    $(document).on('click', '.answer-card', function() {

        $('.answer-card').removeClass('active-answer');
        $(this).addClass('active-answer');

        // Ensure we only get the text of the answer, excluding the checkbox div
        let selectedValue = $(this).text().trim();
        questions[currentQuestion].user_answer = selectedValue;

        // Auto-next to the next question after a brief delay to show selection
        if (currentQuestion < questions.length - 1) {
            setTimeout(function() {
                $('.next-btn').click();
            }, 300);
        }
    });

    function updateButtons() {
        // PREVIOUS button state
        if (currentQuestion === 0) {
            $('.prev-btn').css({ opacity: 0.5, 'pointer-events': 'none' });
        } else {
            $('.prev-btn').css({ opacity: 1, 'pointer-events': 'auto' });
        }

        // NEXT and FINISH button state
        if (currentQuestion === questions.length - 1) {
            $('.next-btn').css({ opacity: 0.5, 'pointer-events': 'none' });
            $('.finish-btn').css({ opacity: 1, 'pointer-events': 'auto' });
        } else {
            $('.next-btn').css({ opacity: 1, 'pointer-events': 'auto' });
            $('.finish-btn').css({ opacity: 0.5, 'pointer-events': 'none' });
        }
    }

    /* ======================================
        NEXT BUTTON
    ====================================== */

    $('.next-btn').on('click', function () {
        if (questions[currentQuestion].user_answer === undefined) {
            alert('Please select an answer before proceeding.');
            return;
        }

        if (currentQuestion < questions.length - 1) {
            currentQuestion++;
            loadQuestion();
        }
    });

    /* ======================================
        PREVIOUS BUTTON
    ====================================== */

    $('.prev-btn').on('click', function () {
        if (currentQuestion > 0) {
            currentQuestion--;
            loadQuestion();
        }
    });

    /* ======================================
        FINISH BUTTON
    ====================================== */

    $('.finish-btn').on('click', function () {
        if (questions[currentQuestion].user_answer === undefined) {
            alert('Please select an answer for the last question.');
            return;
        }

        calculateScore();
    });

    function calculateScore() {
        clearInterval(window.quizTimer); // Stop the timer

        let correct = 0;
        let wrong = 0;
        let skipped = 0;

        questions.forEach(q => {
            if (q.user_answer === undefined) {
                skipped++;
            } else if (q.user_answer == q.correct) {
                correct++;
            } else {
                wrong++;
            }
        });

        let timeSpent = totalTime - timeLeft;

        $.ajax({
            url: '/submit-score',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                correct: correct,
                wrong: wrong,
                skipped: skipped,
                total: questions.length,
                time_spent: timeSpent,
                exam_type: '{{ $examTypeToSave }}',
                mode_id: '{{ $mode_id ?? "" }}',
                exam_level_id: '{{ $exam_level_id ?? "" }}',
                duration_id: '{{ $duration_id ?? "" }}',
                schedule_id: '{{ isset($schedule) && $schedule ? $schedule->id : "" }}'
            },
            success: function(response) {
                if (response.success) {
                    if (response.is_pending) {
                        $('#modalTotal').parent().html(`
                            <div style="text-align:center; padding:20px; font-size:16px; color:#ea580c; background:#fff7ed; border-radius:10px;">
                                <i class="fa fa-clock" style="font-size:24px; margin-bottom:10px;"></i><br>
                                <strong>Your exam has been submitted successfully.</strong><br><br>
                                Your result will be available on:<br>
                                <strong style="color:#9a3412;">${response.result_available_at}</strong>
                            </div>
                        `);
                        // Change button to redirect to dashboard
                        $('#successModal button').text('Back to Dashboard').attr('onclick', 'window.location.href="/dashboard"');
                    } else {
                        $('#modalTotal').text(questions.length);
                        $('#modalCorrect').text(correct);
                        $('#modalWrong').text(wrong);
                        $('#modalSkipped').text(skipped);
                    }
                    $('#successModal').css('display', 'flex');
                }
            },
            error: function(err) {
                console.error(err);
                alert("Failed to submit score. Please try again.");
            }
        });
    }

    /* ======================================
        INIT
    ====================================== */

    loadQuestion();
    startTimer();

    // Auto load voices
    window.speechSynthesis.onvoiceschanged = () => {
        window.speechSynthesis.getVoices();
    };

</script>
@endsection