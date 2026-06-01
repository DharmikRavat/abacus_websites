@extends('client.layout.app')

@section('style')
<style>
    .dash {
        padding: 2rem 0 4rem;
        background: #f8f9fc;
        min-height: 100vh;
    }

    /* ── Welcome ── */
    .dash-welcome {
        margin-bottom: 2rem;
    }

    .dash-welcome h1 {
        font-size: 1.6rem;
        font-weight: 700;
        color: #111827;
        margin: 0 0 .25rem;
    }

    .dash-welcome p {
        color: #6b7280;
        margin: 0;
        font-size: .95rem;
    }

    /* ── Section label ── */
    .dash-label {
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: #9ca3af;
        margin: 2rem 0 .85rem;
    }

    /* ── Register strip ── */
    .reg-strip {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }

    .reg-tile {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 1.1rem .75rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        color: inherit;
        transition: box-shadow .18s, transform .18s;
    }

    .reg-tile:hover {
        box-shadow: 0 6px 20px rgba(0,0,0,.08);
        transform: translateY(-2px);
        color: inherit;
        text-decoration: none;
    }

    .reg-dot {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }

    .reg-tile span {
        font-size: .8rem;
        font-weight: 600;
        color: #374151;
        text-align: center;
        line-height: 1.35;
    }

    /* ── Action grid ── */
    .action-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }

    .action-tile {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 1.1rem .5rem .9rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        color: inherit;
        transition: box-shadow .18s, transform .18s;
        cursor: pointer;
    }

    .action-tile:hover {
        box-shadow: 0 6px 20px rgba(0,0,0,.08);
        transform: translateY(-2px);
        text-decoration: none;
        color: inherit;
    }

    .action-dot {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .action-tile strong {
        font-size: .75rem;
        font-weight: 700;
        color: #1f2937;
        text-align: center;
        line-height: 1.3;
        display: block;
    }

    .action-tile small {
        font-size: .68rem;
        color: #9ca3af;
        display: block;
        text-align: center;
    }

    /* ── Explore list ── */
    .explore-list {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .explore-row {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: .85rem 1rem;
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        color: inherit;
        transition: box-shadow .18s, transform .18s;
    }

    .explore-row:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,.07);
        transform: translateY(-2px);
        text-decoration: none;
        color: inherit;
    }

    .explore-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .explore-row strong {
        font-size: .85rem;
        font-weight: 700;
        color: #111827;
        display: block;
    }

    .explore-row small {
        font-size: .75rem;
        color: #9ca3af;
        display: block;
    }

    .explore-chevron {
        margin-left: auto;
        color: #d1d5db;
        font-size: .8rem;
    }

    /* ── Account card ── */
    .account-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .account-info {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .account-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e5e7eb;
    }

    .account-name {
        font-size: 1.05rem;
        font-weight: 700;
        color: #111827;
        margin: 0 0 2px;
    }

    .account-email {
        font-size: .82rem;
        color: #6b7280;
        margin: 0;
    }

    .btn-profile {
        background: #2563eb;
        color: #fff;
        border: none;
        padding: .55rem 1.4rem;
        border-radius: 10px;
        font-size: .85rem;
        font-weight: 700;
        text-decoration: none;
        transition: background .18s;
    }

    .btn-profile:hover {
        background: #1d4ed8;
        color: #fff;
        text-decoration: none;
    }

    /* ── Colour tokens ── */
    .c-violet  { background: #ede9fe; color: #6d28d9; }
    .c-sky     { background: #e0f2fe; color: #0369a1; }
    .c-emerald { background: #d1fae5; color: #065f46; }
    .c-amber   { background: #fef3c7; color: #92400e; }
    .c-rose    { background: #ffe4e6; color: #9f1239; }
    .c-cyan    { background: #cffafe; color: #155e75; }
    .c-fuchsia { background: #fae8ff; color: #86198f; }
    .c-lime    { background: #ecfccb; color: #3a5c0e; }
    .c-orange  { background: #ffedd5; color: #9a3412; }
    .c-teal    { background: #ccfbf1; color: #0f766e; }

    /* ── Responsive ── */
    @media (max-width: 575px) {
        .action-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }

        .action-dot {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .action-tile strong { font-size: .68rem; }
        .action-tile small  { display: none; }

        .explore-list {
            grid-template-columns: 1fr 1fr;
        }

        .account-card {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .btn-profile {
            width: 100%;
            text-align: center;
            display: block;
        }
    }
</style>
@endsection


@section('content')
<div class="dash">
<div class="container">

    {{-- Welcome --}}
    <div class="dash-welcome">
        <h1>Welcome back, {{ session('student_name') }} 👋</h1>
        <p>Here's everything you need in one place.</p>
    </div>

    {{-- Register for Classes --}}
    <p class="dash-label">Register for Classes</p>
    <div class="reg-strip">
        <a  target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLSe0a0tQ95QjKLkLctXB29shwSOLbD__x666tqKgbBjLti-iNA/viewform" class="reg-tile">
            <div class="reg-dot c-violet"><i class="fa fa-pencil"></i></div>
            <span>Demo Registration</span>
        </a>
        <a  target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLSftide7sN1hbKSKkNJZWauvf2xGm0qZ6Ix9vtRGDrk_oZvjnw/viewform" class="reg-tile">
            <div class="reg-dot c-sky"><i class="fa fa-graduation-cap"></i></div>
            <span>Admission Registration</span>
        </a>
        <a  target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLSfOxx723zZVFXvsaixBvH5W1r3ZHllI6NjnpPoVbZ5IfA_3Qg/closedform" class="reg-tile">
            <div class="reg-dot c-amber"><i class="fa fa-trophy"></i></div>
            <span>Olympiad Registration</span>
        </a>
    </div>

    {{-- Quick Actions --}}
    <p class="dash-label">Quick Actions</p>
    <div class="action-grid">
        <a href="#" class="action-tile">
            <div class="action-dot c-violet"><i class="fa fa-file-text"></i></div>
            <strong>Online Test</strong>
            <small>Start test</small>
        </a>
        <a href="#" class="action-tile">
            <div class="action-dot c-sky"><i class="fa fa-graduation-cap"></i></div>
            <strong>Online Exam</strong>
            <small>Attend exam</small>
        </a>
        <a href="#" class="action-tile">
            <div class="action-dot c-emerald"><i class="fa fa-play"></i></div>
            <strong>Start Practice</strong>
            <small>Learn</small>
        </a>
        <a href="#" class="action-tile">
            <div class="action-dot c-amber"><i class="fa fa-trophy"></i></div>
            <strong>Score</strong>
            <small>View result</small>
        </a>
        <a href="#" class="action-tile">
            <div class="action-dot c-rose"><i class="fa fa-check-square-o"></i></div>
            <strong>Test Score</strong>
            <small>View score</small>
        </a>
        <a href="#" class="action-tile">
            <div class="action-dot c-cyan"><i class="fa fa-star-o"></i></div>
            <strong>Exam Score</strong>
            <small>View score</small>
        </a>
        <a href="#" class="action-tile">
            <div class="action-dot c-orange"><i class="fa fa-users"></i></div>
            <strong>Choose User</strong>
            <small>Switch</small>
        </a>
        <a href="{{ route('add-user') }}" class="action-tile">
            <div class="action-dot c-lime"><i class="fa fa-user-plus"></i></div>
            <strong>Add User</strong>
            <small>New profile</small>
        </a>
    </div>



</div>
</div>
@endsection