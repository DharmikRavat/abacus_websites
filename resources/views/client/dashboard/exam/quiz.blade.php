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
        MAIN SCREEN
    ========================== */

        .practice-screen {
            max-width: 850px;
            margin: auto;
        }

        /* =========================
        TOP BOX
    ========================== */

        .top-box {
            background: #f3f7f8;
            border-radius: 15px;
            padding: 24px 30px;
            border: 0.5px solid #111827;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            /* box-shadow: 0 10px 30px rgba(0, 0, 0, .08); */
        }

        .timer-wrap {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 2.3rem;
            font-weight: 700;
            color: #111827;
        }

        .timer-wrap i {
            color: #f59e0b;
            font-size: 2rem;
        }

        .sound-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #59c34d;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 2rem;
            cursor: pointer;
            transition: .25s ease;
        }

        .sound-btn:hover {
            transform: scale(1.05);
        }

        /* =========================
        PROGRESS
    ========================== */

        .progress-wrap {
            width: 100%;
            height: 10px;
            background: rgba(255, 255, 255, .25);
            border-radius: 40px;
            overflow: hidden;
            margin-bottom: 34px;
        }

        .progress-bar-custom {
            width: 75%;
            height: 100%;
            background: #ffe600;
            border-radius: 40px;
        }

        /* =========================
        QUESTION CARD
    ========================== */

        .question-card {
            background: #f3f7f8;
            border-radius: 20px;
            border: 0.5px solid #111827;
            padding: 20px 20px;
            text-align: center;
            margin-bottom: 34px;
            /* box-shadow: 0 12px 30px rgba(0, 0, 0, .08); */
        }

        .question-title {
            font-size: 1rem;
            font-weight: 700;
            color: #2196f3;
            margin-bottom: 40px;
        }

        /* HORIZONTAL QUESTION */

        .question-numbers {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .question-numbers div {
            font-size: 2rem;
            font-weight: 700;
            color: #111827;
            min-width: 100px;
        }

        /* =========================
        ANSWERS
    ========================== */

        .answer-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            margin-bottom: 40px;
        }

        .answer-card {
            height: 100px;
            background: #f8f8f8;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            font-weight: 700;
            color: #111827;
            cursor: pointer;
            transition: .25s ease;
            border: 0.5px solid #111827;
            /* box-shadow: 0 8px 20px rgba(0, 0, 0, .05); */
        }

        .answer-card:hover {
            transform: translateY(-4px);
            background: #fff;
        }

        /* =========================
        ACTION BUTTONS
    ========================== */

        .action-wrap {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 24px;
        }

        .action-btn {
            height: 50px;
            border: none;
            border-radius: 20px;
            color: #fff;
            font-size: 1rem;
            font-weight: 700;
        }

        .prev-btn {
            background: #2892f0;
        }

        .next-btn {
            background: #57be4d;
        }

        /* =========================
        FINISH
    ========================== */

        .finish-btn {
            width: 100%;
            height: 50px;
            border: none;
            border-radius: 20px;
            background: #ff5722;
            color: #fff;
            font-size: 1rem;
            font-weight: 700;
        }

        /* =========================
        MOBILE
    ========================== */

        @media(max-width:768px) {

            .practice-screen {
                max-width: 100%;
            }

            .top-box {
                padding: 18px;
                border-radius: 24px;
            }

            .timer-wrap {
                font-size: 1.8rem;
            }

            .timer-wrap i {
                font-size: 1.6rem;
            }

            .sound-btn {
                width: 65px;
                height: 65px;
                font-size: 1.6rem;
            }

            .question-card {
                padding: 34px 16px;
            }

            .question-title {
                font-size: 1.7rem;
            }

            .question-numbers {
                gap: 18px;
            }

            .question-numbers div {
                font-size: 2.4rem;
                min-width: 60px;
            }

            .answer-card {
                height: 110px;
                font-size: 2.5rem;
                border-radius: 22px;
            }

            .action-btn,
            .finish-btn {
                height: 78px;
                font-size: 1.5rem;
                border-radius: 20px;
            }

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


            {{-- CONTENT --}}
            <div class="practice-screen">

                {{-- TOP BAR --}}
                <div class="top-box">

                    <div class="timer-wrap">
                        <i class="fa fa-clock-o"></i>
                        <span>02:59</span>
                    </div>

                    <div class="sound-btn" onclick="speakQuestion()">
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
                        Question 1
                    </h3>

                    <div class="question-numbers" id="questionText">
                        <div>+4</div>
                        <div>-3</div>
                        <div>-1</div>
                    </div>

                </div>

                {{-- ANSWERS --}}
                <div class="answer-grid">

                    <div class="answer-card">0</div>
                    <div class="answer-card">2</div>
                    <div class="answer-card">1</div>
                    <div class="answer-card">3</div>

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


@endsection



@section('script')


<script>

    /* ======================================
        DUMMY QUESTIONS
    ====================================== */

    const questions = [

        {
            question: ["+4", "-3", "-1"],
            answers: [0, 2, 1, 3],
            correct: 0
        },

        {
            question: ["+5", "+2", "-4"],
            answers: [1, 3, 5, 7],
            correct: 3
        },

        {
            question: ["+8", "-2", "-1"],
            answers: [5, 7, 8, 6],
            correct: 5
        },

        {
            question: ["+9", "-5", "+1"],
            answers: [3, 4, 5, 6],
            correct: 5
        },

        {
            question: ["+7", "-2", "-2"],
            answers: [1, 2, 3, 5],
            correct: 3
        }

    ];

    /* ======================================
        VARIABLES
    ====================================== */

    let currentQuestion = 0;

    let totalTime = 180; // 3 minutes
    let timeLeft = totalTime;

    /* ======================================
        LOAD QUESTION
    ====================================== */

    function loadQuestion() {

        let q = questions[currentQuestion];

        // Question Number
        $('.question-title').text(
            'Question ' + (currentQuestion + 1)
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

            answerHtml += `
                <div class="answer-card">
                    ${answer}
                </div>
            `;

        });

        $('.answer-grid').html(answerHtml);

        // Progress
        updateQuestionProgress();

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

        const timer = setInterval(() => {

            if (timeLeft <= 0) {

                clearInterval(timer);

                alert('Time Finished');

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
        NEXT BUTTON
    ====================================== */

    $('.next-btn').on('click', function () {

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

        alert('Practice Finished');

    });

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