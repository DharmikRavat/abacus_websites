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

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.65);
    }
    .modal-content {
        background-color: #fff;
        margin: 8% auto;
        padding: 25px;
        width: 90%;
        max-width: 450px;
        border-radius: 12px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    .modal-header h3 { margin: 0; }
    .close {
        font-size: 32px;
        font-weight: bold;
        cursor: pointer;
        color: #999;
    }
    .close:hover { color: #e74c3c; }
    .modal-footer {
        margin-top: 25px;
        text-align: right;
    }
    .modal-footer button {
        padding: 10px 20px;
        margin-left: 10px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }
    .btn-secondary { background: #6c757d; color: white; }
    .btn-danger { background: #e74c3c; color: white; }

    @media(max-width: 768px){
        .action-grid{ grid-template-columns: repeat(3,1fr); gap: 10px; }
        .action-card{ padding: 16px 8px; border-radius: 18px; }
        .action-icon{ width: 46px; height: 46px; font-size: 1rem; border-radius: 14px; }
        .action-card strong{ font-size: .7rem; }
        .action-card small{ display: none; }
    }


    .bg-red {
    background: #fee2e2;
    color: #dc2626;
}
.bg-orange {
    background: #ffedd5;
    color: #c2410c;
}
.bg-indigo {
    background: #e0e7ff;
    color: #4f46e5;
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

        <a href="{{ route('online.assessment', ['type' => 'test']) }}" class="action-card">
            <div class="action-icon bg-violet">
                <i class="fa fa-file-text"></i>
            </div>

            <strong>Online Test</strong>
            <small>Start Test</small>
        </a>

        <a href="{{ route('online.assessment', ['type' => 'exam']) }}" class="action-card">
            <div class="action-icon bg-blue">
                <i class="fa fa-graduation-cap"></i>
            </div>

            <strong>Online Exam</strong>
            <small>Attend Exam</small>
        </a>


        <a href="{{ route('score-sheet', ['tab' => 'practice']) }}" class="action-card">
            <div class="action-icon bg-amber">
                <i class="fa fa-trophy"></i>
            </div>
            <strong>Practice Score</strong>
            <small>View Results</small>
        </a>

        <a href="{{ route('score-sheet', ['tab' => 'test']) }}" class="action-card">
            <div class="action-icon bg-amber">
                <i class="fa fa-trophy"></i>
            </div>
            <strong>Online Test Score</strong>
            <small>View Results</small>
        </a>

        <a href="{{ route('score-sheet', ['tab' => 'exam']) }}" class="action-card">
            <div class="action-icon bg-amber">
                <i class="fa fa-trophy"></i>
            </div>
            <strong>Online Exam Score</strong>
            <small>View Results</small>
        </a>

        <a href="{{ route('choose-user') }}" class="action-card">
            <div class="action-icon bg-orange">
                <i class="fa fa-users"></i>
            </div>
            <strong>Choose User</strong>
            <small>Switch User</small>
        </a>

        <a href="{{ route('profile') }}" class="action-card">
            <div class="action-icon bg-indigo">
                <i class="fa fa-user"></i>
            </div>
            <strong>View Profile</strong>
            <small>Manage Account</small>
        </a>

        <a href="{{ route('add-user') }}" class="action-card">
            <div class="action-icon bg-lime">
                <i class="fa fa-user-plus"></i>
            </div>

            <strong>Add User</strong>
            <small>New Profile</small>
        </a>

        <a href="{{ route('products.index') }}" class="action-card">
            <div class="action-icon bg-blue">
                <i class="fa fa-shopping-bag"></i>
            </div>
            <strong>View Products</strong>
            <small>Browse items</small>
        </a>

        <a href="{{ route('feedbacks.create') }}" class="action-card">
            <div class="action-icon bg-emerald">
                <i class="fa fa-comments"></i>
            </div>
            <strong>Submit Feedback</strong>
            <small>Share your thoughts</small>
        </a>

    </div>
 {{-- SETTINGS SECTION --}}
        <div class="section-title mt-4">Setting</div>

<div class="action-grid">

    <!-- Reset Profiles -->
    <a href="#" onclick="showResetModal('profile')" class="action-card">
        <div class="action-icon bg-violet">
                <i class="fa fa-trophy"></i>
            </div>
        <strong>Reset Profiles</strong>
        <small>Clear User Data</small>
    </a>

    <!-- Reset Scores -->
    <a href="#" onclick="showResetModal('score')" class="action-card">
        <div class="action-icon bg-orange">
            <i class="fa fa-trophy"></i>
        </div>
        <strong>Reset Scores</strong>
        <small>Delete Practice Data Only</small>
    </a>

    <!-- Tricks & Formula -->
    <a href="{{ route('tricks-formula') }}" class="action-card">
         <div class="action-icon bg-violet">
                <i class="fa fa-trophy"></i>
            </div>
        <strong>Tricks & Formula</strong>
        <small>Quick Tips</small>
    </a>

</div>

        <!-- Reset Modal -->
        <div id="resetModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="modalTitle">Confirm Reset</h3>
                    <span class="close" onclick="closeModal()">&times;</span>
                </div>
                <div class="modal-body">
                    <p id="modalMessage"></p>
                </div>
                <div class="modal-footer">
                    <button onclick="closeModal()" class="btn btn-secondary">Cancel</button>
                    <button id="confirmBtn" class="btn btn-danger">Yes, Reset</button>
                </div>
            </div>
        </div>

    </div>
</div>



</div>
</div>


@endsection
@section('script')
<script>
let currentResetType = '';

function showResetModal(type) {
    currentResetType = type;
    const modal = document.getElementById('resetModal');
    const title = document.getElementById('modalTitle');
    const message = document.getElementById('modalMessage');
    const confirmBtn = document.getElementById('confirmBtn');

    if (type === 'profile') {
        title.textContent = 'Reset Profiles';
        message.innerHTML = 'Are you sure you want to reset all profiles?<br><strong>This action cannot be undone.</strong>';
    } else if (type === 'score') {
        title.textContent = 'Reset Scores';
        message.innerHTML = 'This will delete <strong>ONLY practice data</strong>.<br><br>Are you sure you want to proceed?<br><strong>This action cannot be undone.</strong>';
    }

    modal.style.display = 'block';

    confirmBtn.onclick = function() {
        performReset(currentResetType);
    };
}

function closeModal() {
    document.getElementById('resetModal').style.display = 'none';
}

function performReset(type) {
    closeModal();

    if (type === 'profile') {
        alert('✅ Profiles reset successfully!');

    } else if (type === 'score') {
        fetch('{{ route("reset-practice-scores") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ Practice data reset successfully!\n(Only practice scores hidden)');
            } else {
                alert('⚠️ Could not reset scores: ' + data.message);
            }
        })
        .catch(err => {
            alert('⚠️ Unable to process reset request.');
        });
    }
}

// Close when clicking outside modal
window.onclick = function(event) {
    const modal = document.getElementById('resetModal');
    if (event.target === modal) closeModal();
};
</script>