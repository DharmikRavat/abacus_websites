<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        {{-- <div class="logo-mark"> --}}

            <img src="{{ asset('storage/' . $settings->company_logo) }}" alt="Logo"
                style="height:40px; width:auto; object-fit:contain;">

            {{--
        </div> --}}
        <span class="logo-text">{{ $settings->company_name }}</span>
        {{-- <span class="logo-chip">{{ Auth::user()->role ?? "" }}</span> --}}
    </div>

    <nav class="nav-scroll">
        <div class="nav-section">
            <div class="nav-label">Overview</div>
    <div class="nav-item 
        {{ request()->routeIs(auth()->user()->role == 'teacher' ? 'teacher.dashboard' : 'admin.dashboard') ? 'active' : '' }}"
        
        onclick="window.location='{{ auth()->user()->role == 'teacher' 
            ? route('teacher.dashboard') 
            : route('admin.dashboard') }}'" 
        
        style="cursor: pointer;">

                <svg viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7" rx="1" />
                    <rect x="14" y="3" width="7" height="7" rx="1" />
                    <rect x="3" y="14" width="7" height="7" rx="1" />
                    <rect x="14" y="14" width="7" height="7" rx="1" />
                </svg>
                Dashboard
            </div>
        </div>
        <!-- Content Management Section -->
        @if(!in_array(Auth::user()->role, ['teacher', 'student']))
            <div class="nav-section">
                <div class="nav-label">Content Management</div>
                <!-- Global Presence -->
<div class="nav-item {{ request()->routeIs('admin.global-presences.*') ? 'active' : '' }}"
     onclick="window.location='{{ route('admin.global-presences.index') }}'"
     style="cursor: pointer;">

    <svg viewBox="0 0 24 24">
        <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 2c1.8 0 3.4.5 4.8 1.4H7.2A7.96 7.96 0 0112 4zm-6 8c0-.7.1-1.4.3-2h11.4c.2.6.3 1.3.3 2s-.1 1.4-.3 2H6.3c-.2-.6-.3-1.3-.3-2zm1.2 4h9.6A7.96 7.96 0 0112 20a7.96 7.96 0 01-4.8-1.6zm10.6-10.6A7.96 7.96 0 0120 12c0 2.1-.8 4-2.2 5.4A15.5 15.5 0 0018.5 12c0-2-.3-3.9-.7-5.6zM6.2 6.6A15.5 15.5 0 005.5 12c0 2 .3 3.9.7 5.4A7.96 7.96 0 014 12c0-2.1.8-4 2.2-5.4z"/>
    </svg>

    Global Presence
</div>

<!-- Statistics -->
<div class="nav-item {{ request()->routeIs('admin.statistics.*') ? 'active' : '' }}"
     onclick="window.location='{{ route('admin.statistics.index') }}'"
     style="cursor: pointer;">

    <svg viewBox="0 0 24 24">
        <path d="M3 13h4v8H3v-8z"/>
        <path d="M10 9h4v12h-4V9z"/>
        <path d="M17 5h4v16h-4V5z"/>
    </svg>

    Statistics
</div>
                <!-- Academy Programs -->
                <div class="nav-item {{ request()->routeIs('admin.academy-programs.*') ? 'active' : '' }}"
                    onclick="window.location='{{ route('admin.academy-programs.index') }}'" style="cursor: pointer;">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 3L2 8l10 5 10-5-10-5z" />
                        <path d="M6 12v5c0 2 3 4 6 4s6-2 6-4v-5" />
                    </svg>
                    Academy Programs
                </div>
<!-- Program Writeup -->
<div class="nav-item {{ request()->routeIs('admin.program-writeup.*') ? 'active' : '' }}"
    onclick="window.location='{{ route('admin.program-writeup.index') }}'"
    style="cursor: pointer;">

    <svg viewBox="0 0 24 24">
        <path d="M5 4h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/>
        <path d="M8 8h8"/>
        <path d="M8 12h8"/>
        <path d="M8 16h5"/>
    </svg>

    Program Writeup

</div>
<!-- Franchise Page -->
<div class="nav-item {{ request()->routeIs('admin.franchise-page.*') ? 'active' : '' }}"
    onclick="window.location='{{ route('admin.franchise-page.index') }}'"
    style="cursor: pointer;">

    <svg viewBox="0 0 24 24">
        <path d="M4 4h16v16H4z"/>
        <path d="M8 8h8"/>
        <path d="M8 12h8"/>
        <path d="M8 16h5"/>
    </svg>

    Franchise Page

</div>
                <!-- FAQ's -->
                <div class="nav-item {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}"
                    onclick="window.location='{{ route('admin.faqs.index') }}'" style="cursor: pointer;">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9" />
                        <path d="M9.5 9a2.5 2.5 0 115 0c0 1.5-2.5 2-2.5 4" />
                        <circle cx="12" cy="17" r="1" />
                    </svg>
                    FAQ's
                </div>

                <!-- Slider Images -->
                <div class="nav-item {{ request()->routeIs('admin.slider-images.*') ? 'active' : '' }}"
                    onclick="window.location='{{ route('admin.slider-images.index') }}'" style="cursor: pointer;">
                    <svg viewBox="0 0 24 24">
                        <rect x="3" y="5" width="18" height="14" rx="2" />
                        <circle cx="8" cy="10" r="2" />
                        <path d="M21 15l-5-5L5 21" />
                    </svg>
                    Slider Images
                </div>

                <!-- About Us -->
                <div class="nav-item {{ request()->routeIs('admin.about-us.*') ? 'active' : '' }}"
                    onclick="window.location='{{ route('admin.about-us.index') }}'" style="cursor: pointer;">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 16v-4" />
                        <path d="M12 8h.01" />
                    </svg>
                    About Us
                </div>

                <!-- Privacy Policy -->
                <div class="nav-item {{ request()->routeIs('admin.privacy-policy.*') ? 'active' : '' }}"
                    onclick="window.location='{{ route('admin.privacy-policy.index') }}'" style="cursor: pointer;">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2l7 4v6c0 5-3.5 9-7 10-3.5-1-7-5-7-10V6l7-4z" />
                        <path d="M9 12l2 2 4-4" />
                    </svg>
                    Privacy Policy
                </div>

                <!-- Terms & Conditions -->
                <div class="nav-item {{ request()->routeIs('admin.terms-conditions.*') ? 'active' : '' }}"
                    onclick="window.location='{{ route('admin.terms-conditions.index') }}'" style="cursor: pointer;">
                    <svg viewBox="0 0 24 24">
                        <rect x="4" y="3" width="16" height="18" rx="2" />
                        <path d="M8 7h8M8 11h8M8 15h5" />
                    </svg>
                    Terms & Conditions
                </div>

                <!-- Gallery -->
                <div class="nav-item {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}"
                    onclick="window.location='{{ route('admin.gallery.index') }}'" style="cursor: pointer;">
                    <svg viewBox="0 0 24 24">
                        <rect x="3" y="5" width="18" height="14" rx="2" />
                        <circle cx="8" cy="10" r="2" />
                        <path d="M21 15l-5-5L5 21" />
                    </svg>
                    Gallery
                </div>
                <!-- Feedback -->
                <div class="nav-item {{ request()->routeIs('admin.feedbacks.*') ? 'active' : '' }}"
                    onclick="window.location='{{ route('admin.feedbacks.index') }}'" style="cursor: pointer;">
                    <svg viewBox="0 0 24 24">
                        <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                    </svg>
                    Feedback
                </div>
            </div>
        @endif

@if(!in_array(Auth::user()->role, ['teacher', 'student']))
    <!-- Admission Details Section -->
    <div class="nav-section">
        <div class="nav-label">Admission Details</div>

     <!-- Students Admission -->
<div class="nav-item {{ request()->routeIs('admin.student-fees.*') ? 'active' : '' }}"
    onclick="window.location='{{ route('admin.student-fees.index') }}'"
    style="cursor: pointer;">

    <svg viewBox="0 0 24 24">
        <path d="M12 12a5 5 0 100-10 5 5 0 000 10z" />
        <path d="M4 22a8 8 0 0116 0" />
    </svg>

    Students Admission
</div>

     <!-- Teachers Admission -->
<div class="nav-item {{ request()->routeIs('admin.teacher-fees.*') ? 'active' : '' }}"
    onclick="window.location='{{ route('admin.teacher-fees.index') }}'"
    style="cursor: pointer;">

    <svg viewBox="0 0 24 24">
        <path d="M12 12a5 5 0 100-10 5 5 0 000 10z" />
        <path d="M4 22a8 8 0 0116 0" />
    </svg>

    Teacher Admission
</div>

<!-- Student Lead -->
<div class="nav-item {{ request()->routeIs('admin.student-leads.*') ? 'active' : '' }}"
    onclick="window.location='{{ route('admin.student-leads.index') }}'"
    style="cursor: pointer;">

    <svg viewBox="0 0 24 24">
        <path d="M12 12a5 5 0 100-10 5 5 0 000 10z" />
        <path d="M4 22a8 8 0 0116 0" />
    </svg>

    Student Lead
</div>
    </div>
@endif
        <!-- Academic Section -->
        <div class="nav-section">
            <div class="nav-label">Academics</div>
<!-- Students -->
<div class="nav-item 
    {{ request()->routeIs(Auth::user()->role == 'teacher' 
        ? 'teacher.students.*' 
        : 'admin.students.*') ? 'active' : '' }}"

    onclick="window.location='{{ Auth::user()->role == 'teacher' 
        ? route('teacher.students.index') 
        : route('admin.students.index') }}'"

    style="cursor: pointer;">

    <svg viewBox="0 0 24 24">
        <path d="M12 12a5 5 0 100-10 5 5 0 000 10z" />
        <path d="M4 22a8 8 0 0116 0" />
    </svg>

    Students
</div>

<!-- Teachers -->
@if(!in_array(Auth::user()->role, ['teacher', 'student']))
    <div class="nav-item {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}"
        onclick="window.location='{{ route('admin.teachers.index') }}'"
        style="cursor: pointer;">

        <svg viewBox="0 0 24 24">
            <path d="M12 3L2 8l10 5 10-5-10-5z" />
            <path d="M6 12v5c0 2 3 4 6 4s6-2 6-4v-5" />
        </svg>

        Teachers
    </div>
@endif

<!-- Attendance -->
<div class="nav-item 
    {{ request()->routeIs(Auth::user()->role == 'teacher' 
        ? 'teacher.attendance.*' 
        : 'admin.attendance.*') ? 'active' : '' }}"

    onclick="window.location='{{ Auth::user()->role == 'teacher' 
        ? route('teacher.attendance.index') 
        : route('admin.attendance.index') }}'"

    style="cursor: pointer;">

    <svg viewBox="0 0 24 24">
        <rect x="3" y="4" width="18" height="18" rx="2" />
        <path d="M8 2v4M16 2v4" />
        <path d="M8 12l2 2 4-4" />
    </svg>

    Attendance
</div>
            <!-- Fees -->
            {{-- <div class="nav-item {{ request()->routeIs('admin.fees.*') ? 'active' : '' }}"
                onclick="window.location='{{ route('admin.fees.index') }}'" style="cursor: pointer;">
                <svg viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9" />
                    <path d="M12 7v10" />
                    <path d="M9 10h6a2 2 0 010 4H9" />
                </svg>
                Fees
            </div> --}}

            <!-- Invoices -->
            {{-- <div class="nav-item {{ request()->routeIs('admin.invoices.*') ? 'active' : '' }}"
                onclick="window.location='{{ route('admin.invoices.index') }}'" style="cursor: pointer;">
                <svg viewBox="0 0 24 24">
                    <path d="M6 2h9l5 5v15H6z" />
                    <path d="M15 2v5h5" />
                    <path d="M9 13h6M9 17h6" />
                </svg>
                Invoices
            </div> --}}
            <!-- TimeTable -->
            {{-- <div class="nav-item {{ request()->routeIs('admin.timetable.*') ? 'active' : '' }}"
                onclick="window.location='{{ route('admin.timetable.index') }}'" style="cursor: pointer;">

                <svg viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" />
                    <path d="M8 2v4M16 2v4" />
                    <path d="M3 10h18" />
                    <path d="M8 14h3M13 14h3M8 18h3M13 18h3" />
                </svg>

                TimeTable
            </div> --}}

            <!-- Locate Center -->
            @if(!in_array(Auth::user()->role, ['teacher', 'student']))
                <div class="nav-item {{ request()->routeIs('admin.locate-centers.*') ? 'active' : '' }}"
                    onclick="window.location='{{ route('admin.locate-centers.index') }}'" style="cursor: pointer;">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 21s7-4.35 7-11a7 7 0 10-14 0c0 6.65 7 11 7 11z" />
                        <circle cx="12" cy="10" r="2.5" />
                    </svg>
                    Locate Center
                </div>
            @endif
        </div>

        <!-- Exam Section -->
        @if(!in_array(Auth::user()->role, ['teacher', 'student']))
            <div class="nav-section">
                <div class="nav-label">Exam</div>

                <!-- Level -->
                <div class="nav-item {{ request()->routeIs('admin.levels.*') ? 'active' : '' }}"
                    onclick="window.location='{{ route('admin.levels.index') }}'" style="cursor: pointer;">
                    <svg viewBox="0 0 24 24">
                        <path d="M3 17l6-6 4 4 8-8" />
                        <path d="M14 7h7v7" />
                    </svg>
                    Level
                </div>

                <!-- Question Type -->
                <div class="nav-item {{ request()->routeIs('admin.question-types.*') ? 'active' : '' }}"
                    onclick="window.location='{{ route('admin.question-types.index') }}'" style="cursor: pointer;">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9" />
                        <path d="M9.5 9a2.5 2.5 0 115 0c0 1.5-2.5 2-2.5 4" />
                        <circle cx="12" cy="17" r="1" />
                    </svg>
                    Question Type
                </div>

                <!-- Questions -->
                <div class="nav-item {{ request()->routeIs('admin.questions.*') ? 'active' : '' }}"
                    onclick="window.location='{{ route('admin.questions.index') }}'" style="cursor: pointer;">
                    <svg viewBox="0 0 24 24">
                        <rect x="4" y="3" width="16" height="18" rx="2" />
                        <path d="M8 7h8M8 11h8M8 15h5" />
                    </svg>
                    Questions
                </div>

                <!-- Manage Test/Exam -->
                <div class="nav-item {{ request()->routeIs('admin.manage-tests.*') ? 'active' : '' }}"
                    onclick="window.location='{{ route('admin.manage-tests.index') }}'" style="cursor: pointer;">
                    <svg viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="16" rx="2" />
                        <path d="M7 8h10M7 12h6" />
                        <path d="M17 16l2 2 4-4" />
                    </svg>
                    Manage Test/Exam
                </div>

                <!-- Score -->
                <div class="nav-item {{ request()->routeIs('admin.scores.*') ? 'active' : '' }}"
                    onclick="window.location='{{ route('admin.scores.index') }}'" style="cursor: pointer;">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 20V10" />
                        <path d="M18 20V4" />
                        <path d="M6 20v-6" />
                    </svg>
                    Score
                </div>

 
            </div>
        @endif
        @if(Auth::user()->role == 'teacher')
<div class="nav-section">
    <div class="nav-label">Exam</div>

    <!-- Score -->
    <div class="nav-item 
        {{ request()->routeIs(Auth::user()->role == 'teacher' 
            ? 'teacher.scores.*' 
            : 'admin.scores.*') ? 'active' : '' }}"

        onclick="window.location='{{ Auth::user()->role == 'teacher' 
            ? route('teacher.scores.index') 
            : route('admin.scores.index') }}'"

        style="cursor: pointer;">

        <svg viewBox="0 0 24 24">
            <path d="M12 20V10" />
            <path d="M18 20V4" />
            <path d="M6 20v-6" />
        </svg>

        Score
    </div>

    <!-- Manage Test / Exam -->
    <div class="nav-item 
        {{ request()->routeIs(Auth::user()->role == 'teacher' 
            ? 'teacher.manage-tests.*' 
            : 'admin.manage-tests.*') ? 'active' : '' }}"

        onclick="window.location='{{ Auth::user()->role == 'teacher' 
            ? route('teacher.manage-tests.index') 
            : route('admin.manage-tests.index') }}'"

        style="cursor: pointer;">

        <svg viewBox="0 0 24 24">
            <rect x="3" y="4" width="18" height="16" rx="2" />
            <path d="M7 8h10M7 12h6" />
            <path d="M17 16l2 2 4-4" />
        </svg>

        Manage Test/Exam
    </div>

    <!-- Reports -->
    <div class="nav-item 
        {{ request()->routeIs(Auth::user()->role == 'teacher' 
            ? 'teacher.report.*' 
            : 'admin.report.*') ? 'active' : '' }}"

        onclick="window.location='{{ Auth::user()->role == 'teacher' 
            ? route('teacher.report.index') 
            : route('admin.report.index') }}'"

        style="cursor: pointer;">

        <svg viewBox="0 0 24 24">
            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
            <polyline points="14 2 14 8 20 8" />
            <line x1="16" y1="13" x2="8" y2="13" />
            <line x1="16" y1="17" x2="8" y2="17" />
            <line x1="10" y1="9" x2="8" y2="9" />
        </svg>

        Reports
    </div>

    <!-- Certificate -->
    <div class="nav-item 
        {{ request()->routeIs(Auth::user()->role == 'teacher' 
            ? 'teacher.certification.*' 
            : 'admin.certification.*') ? 'active' : '' }}"

        onclick="window.location='{{ Auth::user()->role == 'teacher' 
            ? route('teacher.certification.index') 
            : route('admin.certification.index') }}'"

        style="cursor: pointer;">

        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" 
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">

            <rect x="3" y="3" width="14" height="18" rx="2" />
            <path d="M6 7h8M6 10h8M6 13h6" />
            <circle cx="19" cy="15" r="2.5" />
            <path d="M19 17.5v3l-1.5-1-1.5 1v-3" />
        </svg>

        Certificate
    </div>
</div>
        @endif

        <!-- System Settings-->
        @if(!in_array(Auth::user()->role, ['teacher', 'student']))
            <div class="nav-section">
                <div class="nav-label">System</div>

                <!-- Create User -->
                {{-- <div class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                    onclick="window.location='{{ route('admin.users.index') }}'" style="cursor: pointer;">
                    <svg viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    Create User
                </div> --}}

                {{-- <div class="nav-item  {{ request()->routeIs('admin.role.*') ? 'active' : '' }}"
                    onclick="window.location='{{ route('admin.role.index') }}'" style="cursor: pointer;">
                    <svg viewBox="0 0 24 24">
                        <rect x="3" y="11" width="18" height="11" rx="2" />
                        <path d="M7 11V7a5 5 0 0110 0v4" />
                    </svg>
                    Roles &amp; Permissions
                </div> --}}

<div class="nav-item {{ request()->routeIs('admin.activity-log.*') ? 'active' : '' }}"
    onclick="window.location='{{ route('admin.activity-log.index') }}'"
    style="cursor: pointer;">

    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 2v4"></path>
        <path d="M12 12v4"></path>
        <circle cx="12" cy="12" r="8"></circle>
        <path d="M12 8v4l3 2"></path>
    </svg>

    Login Logs
</div>
                <div class="nav-item {{ request()->routeIs('admin.report.*') ? 'active' : '' }}"
                    onclick="window.location='{{ route('admin.report.index') }}'" style="cursor: pointer;">

                    <svg viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                        <line x1="10" y1="9" x2="8" y2="9" />
                    </svg>

                    Reports
                </div>
                <div class="nav-item  {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"
                    onclick="window.location='{{ route('admin.settings.index') }}'" style="cursor: pointer;">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="3" />
                        <path d="M19.07 4.93a10 10 0 010 14.14M4.93 19.07a10 10 0 010-14.14" />
                        <path d="M9 2.46A10 10 0 0115 2.46M15 21.54A10 10 0 019 21.54" />
                    </svg>
                    Settings
                </div>
                {{-- <div class="nav-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                    Audit Logs
                </div> --}}
            </div>
        @endif
    </nav>

    <div class="sidebar-footer">
        <div class="user-row">
            @php use Illuminate\Support\Str; @endphp
            <div class="avatar avatar-lg"> {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</div>
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->name ?? ""}}</div>
                <div class="user-role">{{ Auth::user()->role ?? "" }}</div>
                <div class="user-role">{{ Auth::user()->email ?? "admin123@gmail.com" }}</div>
            </div>
            <form id="logoutForm" action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="button" class="logout-btn" onclick="confirmLogout()" title="Logout">
                    <svg viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>