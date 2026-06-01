@extends('client.layout.app')

@section('style')

<style>


    body{
        background: #f3f6fb;
    }

    .dash{
        padding: 20px 0 100px;
        min-height: 100vh;
    }

    /* =========================
        HERO CARD
    ========================== */
    .hero-card{
        background: linear-gradient(135deg,#2563eb,#7c3aed);
        border-radius:20px;
        padding: 28px;
        color: #fff;
        position: relative;
        overflow: hidden;
        margin-bottom: 22px;
        box-shadow: 0 15px 40px rgba(37,99,235,.20);
    }

    .hero-card::before{
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(255,255,255,.08);
        top: -60px;
        right: -40px;
    }

    .hero-card::after{
        content: "";
        position: absolute;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,.06);
        bottom: -40px;
        left: -30px;
    }

    .hero-top{
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        z-index: 2;
    }

    .hero-card h1{
        font-size: 1.7rem;
        font-weight: 800;
        margin-bottom: 6px;
        color: #fff;
    }

    .hero-card p{
        margin: 0;
        opacity: .9;
        font-size: .92rem;
    }

    .hero-avatar{
        width: 68px;
        height: 68px;
        border-radius: 20px;
        background: rgba(255,255,255,.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        backdrop-filter: blur(10px);
    }

    /* =========================
        STATS
    ========================== */
    .stats-grid{
        display: grid;
        grid-template-columns: repeat(4,1fr);
        gap: 14px;
        margin-bottom: 24px;
    }

    .stat-card{
        background: #fff;
        border-radius: 22px;
        padding: 18px;
        box-shadow: 0 4px 20px rgba(0,0,0,.04);
        border: 1px solid #edf0f7;
    }

    .stat-card h3{
        margin: 0;
        font-size: 1.6rem;
        font-weight: 800;
        color: #111827;
    }

    .stat-card p{
        margin: 6px 0 0;
        color: #6b7280;
        font-size: .82rem;
        font-weight: 500;
    }

    /* =========================
        SECTION TITLE
    ========================== */
    .section-title{
        font-size: .78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .12em;
        color: #94a3b8;
        margin-bottom: 14px;
    }

    /* =========================
        QUICK ACTIONS
    ========================== */
    .action-grid{
        display: grid;
        grid-template-columns: repeat(3,1fr);
        gap: 14px;
        margin-bottom: 26px;
    }

    .action-card{
        background: #fff;
        border-radius: 22px;
        padding: 20px 12px;
        text-decoration: none;
        color: inherit;
        text-align: center;
        border: 1px solid #edf0f7;
        transition: .25s ease;
        box-shadow: 0 5px 18px rgba(0,0,0,.03);
    }

    .action-card:hover{
        transform: translateY(-4px);
        box-shadow: 0 14px 35px rgba(0,0,0,.08);
        text-decoration: none;
        color: inherit;
    }

    .action-icon{
        width: 58px;
        height: 58px;
        margin: auto;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        margin-bottom: 12px;
    }

    .action-card strong{
        display: block;
        font-size: .84rem;
        font-weight: 700;
        color: #111827;
        line-height: 1.4;
    }

    .action-card small{
        color: #94a3b8;
        font-size: .72rem;
    }

    /* =========================
        REGISTER CARDS
    ========================== */
    .register-grid{
        display: grid;
        grid-template-columns: repeat(3,1fr);
        gap: 14px;
    }

    .register-card{
        background: #fff;
        border-radius: 24px;
        padding: 22px;
        text-decoration: none;
        color: inherit;
        border: 1px solid #edf0f7;
        transition: .25s ease;
        box-shadow: 0 4px 18px rgba(0,0,0,.03);
    }

    .register-card:hover{
        transform: translateY(-4px);
        text-decoration: none;
        color: inherit;
        box-shadow: 0 14px 35px rgba(0,0,0,.08);
    }

    .register-top{
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
    }

    .register-icon{
        width: 56px;
        height: 56px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
    }

    .register-arrow{
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
    }

    .register-card h4{
        margin: 0 0 6px;
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
    }

    .register-card p{
        margin: 0;
        font-size: .82rem;
        color: #64748b;
        line-height: 1.5;
    }

    /* =========================
        COLORS
    ========================== */
    .bg-violet{
        background: #ede9fe;
        color: #6d28d9;
    }

    .bg-blue{
        background: #dbeafe;
        color: #1d4ed8;
    }

    .bg-emerald{
        background: #d1fae5;
        color: #047857;
    }

    .bg-amber{
        background: #fef3c7;
        color: #b45309;
    }

    .bg-rose{
        background: #ffe4e6;
        color: #be123c;
    }

    .bg-cyan{
        background: #cffafe;
        color: #0e7490;
    }

    .bg-orange{
        background: #ffedd5;
        color: #c2410c;
    }

    .bg-lime{
        background: #ecfccb;
        color: #4d7c0f;
    }

    /* =========================
        BOTTOM NAV
    ========================== */
    .bottom-nav{
        position: fixed;
        bottom: 18px;
        left: 50%;
        transform: translateX(-50%);
        width: calc(100% - 30px);
        max-width: 500px;
        background: rgba(255,255,255,.95);
        backdrop-filter: blur(12px);
        border-radius: 24px;
        padding: 14px 10px;
        display: flex;
        justify-content: space-around;
        box-shadow: 0 10px 40px rgba(0,0,0,.12);
        z-index: 999;
    }

    .bottom-nav a{
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        font-size: 1.2rem;
        text-decoration: none;
        transition: .2s ease;
    }

    .bottom-nav a.active,
    .bottom-nav a:hover{
        background: #2563eb;
        color: #fff;
    }

    /* =========================
        MOBILE
    ========================== */
    @media(max-width: 768px){

        .stats-grid{
            grid-template-columns: repeat(2,1fr);
        }

        .action-grid{
            grid-template-columns: repeat(3,1fr);
            gap: 10px;
        }

        .action-card{
            padding: 16px 8px;
            border-radius: 18px;
        }

        .action-icon{
            width: 46px;
            height: 46px;
            font-size: 1rem;
            border-radius: 14px;
        }

        .action-card strong{
            font-size: .7rem;
        }

        .action-card small{
            display: none;
        }

        .register-grid{
            grid-template-columns: 1fr;
        }

        .hero-card{
            padding: 22px;
        }

        .hero-card h1{
            font-size: 1.4rem;
        }

    }
</style>
@endsection

@section('content')

<div class="dash">
<div class="container">

    {{-- HERO --}}
    <div class="hero-card">
        <div class="hero-top">

            <div>
                <h1>
                    Welcome Back 👋
                </h1>

                <p>
                    {{ session('student_name') }} — Ready to continue learning today?
                </p>
            </div>

            <div class="hero-avatar">
                <i class="fa fa-user"></i>
            </div>

        </div>
    </div>

    {{-- STATS --}}
    {{-- <div class="stats-grid">

        <div class="stat-card">
            <h3>12</h3>
            <p>Total Tests</p>
        </div>

        <div class="stat-card">
            <h3>08</h3>
            <p>Online Exams</p>
        </div>

        <div class="stat-card">
            <h3>92%</h3>
            <p>Average Score</p>
        </div>

        <div class="stat-card">
            <h3>#5</h3>
            <p>Leaderboard Rank</p>
        </div>

    </div> --}}


    {{-- REGISTER SECTION --}}
    <div class="section-title mt-10">
        Register For Classes
    </div>

    <div class="register-grid">

        {{-- DEMO --}}
        <a target="_blank"
           href="https://docs.google.com/forms/d/e/1FAIpQLSe0a0tQ95QjKLkLctXB29shwSOLbD__x666tqKgbBjLti-iNA/viewform"
           class="register-card">

            <div class="register-top">

                <div class="register-icon bg-violet">
                    <i class="fa fa-pencil"></i>
                </div>

                <div class="register-arrow">
                    <i class="fa fa-arrow-right"></i>
                </div>

            </div>

            <h4>Demo Registration</h4>

            <p>
                Register for a free demo class and experience our learning platform.
            </p>

        </a>

        {{-- ADMISSION --}}
        <a target="_blank"
           href="https://docs.google.com/forms/d/e/1FAIpQLSftide7sN1hbKSKkNJZWauvf2xGm0qZ6Ix9vtRGDrk_oZvjnw/viewform"
           class="register-card">

            <div class="register-top">

                <div class="register-icon bg-blue">
                    <i class="fa fa-graduation-cap"></i>
                </div>

                <div class="register-arrow">
                    <i class="fa fa-arrow-right"></i>
                </div>

            </div>

            <h4>Admission Registration</h4>

            <p>
                Complete your admission process and join our academy today.
            </p>

        </a>

        {{-- OLYMPIAD --}}
        <a target="_blank"
           href="https://docs.google.com/forms/d/e/1FAIpQLSfOxx723zZVFXvsaixBvH5W1r3ZHllI6NjnpPoVbZ5IfA_3Qg/closedform"
           class="register-card">

            <div class="register-top">

                <div class="register-icon bg-amber">
                    <i class="fa fa-trophy"></i>
                </div>

                <div class="register-arrow">
                    <i class="fa fa-arrow-right"></i>
                </div>

            </div>

            <h4>Olympiad Registration</h4>

            <p>
                Participate in olympiad competitions and improve your ranking.
            </p>

        </a>

    </div>

    {{-- QUICK ACTIONS --}}
    <div class="section-title mt-4">
        Quick Actions
    </div>

    <div class="action-grid">
        <a href="{{ route('free-practice') }}" class="action-card">
            <div class="action-icon bg-emerald">
                <i class="fa fa-play"></i>
            </div>

            <strong>Practice</strong>
            <small>Start Learning</small>
        </a>

        <a href="#" class="action-card">
            <div class="action-icon bg-violet">
                <i class="fa fa-file-text"></i>
            </div>

            <strong>Online Test</strong>
            <small>Start Test</small>
        </a>

        <a href="#" class="action-card">
            <div class="action-icon bg-blue">
                <i class="fa fa-graduation-cap"></i>
            </div>

            <strong>Online Exam</strong>
            <small>Attend Exam</small>
        </a>


        <a href="{{ route('score-sheet') }}" class="action-card">
            <div class="action-icon bg-amber">
                <i class="fa fa-trophy"></i>
            </div>

            <strong>Scores</strong>
            <small>View Results</small>
        </a>


        <a href="{{ route('choose-user') }}" class="action-card">
            <div class="action-icon bg-orange">
                <i class="fa fa-users"></i>
            </div>

            <strong>Choose User</strong>
            <small>Switch User</small>
        </a>

        <a href="{{ route('add-user') }}" class="action-card">
            <div class="action-icon bg-lime">
                <i class="fa fa-user-plus"></i>
            </div>

            <strong>Add User</strong>
            <small>New Profile</small>
        </a>

    </div>


</div>
</div>


@endsection