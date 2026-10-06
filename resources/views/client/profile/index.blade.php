@extends('client.layout.app')

@section('style')
<style>
    .profile-dash {
        padding: 30px 0 80px;
        min-height: 100vh;
        background: #f8fafc;
    }
    .page-header {
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
    .profile-card {
        background: #fff;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 25px rgba(0,0,0,.05);
        display: flex;
        align-items: center;
        gap: 24px;
    }
    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: #eef2ff;
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
    }
    .profile-info h3 {
        margin: 0 0 8px 0;
        font-size: 1.5rem;
        color: #111827;
    }
    .profile-info p {
        margin: 0 0 4px 0;
        color: #4b5563;
        font-size: 1rem;
    }
</style>
@endsection

@section('content')
<div class="profile-dash">
    <div class="container">
        <div class="page-header d-flex align-items-center gap-3">
            <a href="{{ route('dashboard.index') }}" class="back-arrow-btn" title="Back to Dashboard">
                <i class="fa fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="page-title">My Profile</h1>
                <p class="page-subtitle">Manage your account details and information.</p>
            </div>
        </div>

        <div class="profile-card">
            <div style="display: flex; gap: 24px; align-items: center; flex: 1;">
                <div class="profile-avatar">
                    <i class="fa fa-user"></i>
                </div>
                <div class="profile-info">
                    <h3>{{ $user->name ?? 'Student Name' }}</h3>
                    <p><strong>Enrollment No:</strong> {{ $user->student_enrollment_id ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $user->email ?? 'N/A' }}</p>
                    <p><strong>Phone:</strong> {{ $user->mobile ?? 'N/A' }}</p>
                    <p><strong>Class/Level:</strong> Level 2</p>
                </div>
            </div>
            <div>
                <a href="{{ route('profile.edit') }}" style="display: inline-block; padding: 10px 20px; background: #4f46e5; color: #fff; text-decoration: none; border-radius: 8px; font-weight: 600;">
                    <i class="fa fa-edit"></i> Edit Profile
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
