<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate – {{ $certification->student_name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Cinzel:wght@400;700&family=EB+Garamond:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <style>

        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #d6c9a4;
            font-family: 'EB Garamond', Georgia, serif;
            padding: 40px 20px;
        }

        .cert-outer {
            width: 1050px;
            max-width: 100%;
            margin: auto;
            position: relative;
        }

        .cert-frame {
            background: linear-gradient(135deg, #c9a227 0%, #f5e07a 30%, #b8860b 55%, #f5e07a 75%, #c9a227 100%);
            padding: 14px;
            border-radius: 4px;
        }

        .cert-inner {
            background: #fdfbf5;
            position: relative;
            padding: 44px 70px 36px;
            overflow: hidden;
            min-height: 680px;
        }

        .cert-inner::before {
            content: '';
            position: absolute;
            inset: 10px;
            border: 1.5px solid #c9a227;
            pointer-events: none;
            z-index: 0;
        }

        .corner {
            position: absolute;
            width: 28px;
            height: 28px;
            border: 3px solid #c9a227;
            z-index: 1;
        }
        .corner-tl { top: 18px; left: 18px; border-right: none; border-bottom: none; }
        .corner-tr { top: 18px; right: 18px; border-left: none; border-bottom: none; }
        .corner-bl { bottom: 18px; left: 18px; border-right: none; border-top: none; }
        .corner-br { bottom: 18px; right: 18px; border-left: none; border-top: none; }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 340px;
            height: 340px;
            opacity: 0.045;
            border-radius: 50%;
            border: 30px solid #8b6914;
            z-index: 0;
        }

        .content { position: relative; z-index: 1; }

        /* Top row */
        .top-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .logo-seal { width: 110px; text-align: center; }

        .logo-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 6px solid #c9a227;
            object-fit: contain;
            box-shadow: 0 0 0 3px #e5c84d;
            background: #fff8e7;
            display: block;
            margin: auto;
        }

        .logo-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 6px solid #c9a227;
            background: #fff8e7;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: auto;
            box-shadow: 0 0 0 3px #e5c84d;
        }

        .logo-initials {
            font-family: 'Cinzel', serif;
            font-size: 20px;
            font-weight: 700;
            color: #8b5e00;
            line-height: 1;
        }

        .logo-sub {
            font-size: 8px;
            color: #9a7200;
            font-family: 'Cinzel', serif;
            text-align: center;
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .title-area { flex: 1; text-align: center; padding: 0 20px; }

        .cert-script-title {
            font-family: 'Great Vibes', cursive;
            font-size: 72px;
            color: #8b5e00;
            line-height: 1;
            letter-spacing: 1px;
        }

        .certify-text {
            font-family: 'EB Garamond', serif;
            font-style: italic;
            font-size: 18px;
            color: #555;
            margin-top: 6px;
            letter-spacing: 1px;
        }

        .right-badge { width: 110px; text-align: center; }

        .badge-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 5px solid #c9a227;
            background: linear-gradient(145deg, #f5e07a, #c9a227);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: auto;
            box-shadow: 0 0 0 3px #8b6914;
        }

        .badge-text {
            font-family: 'Cinzel', serif;
            font-size: 9px;
            font-weight: 700;
            color: #3a2800;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1.5;
        }

        /* Student name */
        .student-name {
            text-align: center;
            font-family: 'EB Garamond', serif;
            font-size: 40px;
            font-weight: 600;
            color: #1a1a1a;
            margin-top: 4px;
            letter-spacing: 0.5px;
        }

        .name-underline {
            width: 500px;
            height: 1px;
            background: #bbb;
            margin: 4px auto 0;
        }

        /* Body rows */
        .cert-body { margin-top: 14px; }

        .cert-row {
            display: flex;
            align-items: flex-end;
            justify-content: center;
            gap: 0;
            margin-top: 10px;
            font-size: 20px;
            color: #333;
        }

        .cert-label {
            font-style: italic;
            color: #555;
            white-space: nowrap;
            padding-right: 8px;
        }

        .cert-value {
            font-weight: 600;
            color: #111;
            border-bottom: 1px solid #aaa;
            min-width: 240px;
            text-align: center;
            padding: 0 10px 2px;
        }

        .cert-value-sm {
            font-weight: 600;
            color: #111;
            border-bottom: 1px solid #aaa;
            min-width: 160px;
            text-align: center;
            padding: 0 10px 2px;
        }

        .cert-label-after {
            font-style: italic;
            color: #555;
            padding-left: 8px;
            white-space: nowrap;
        }

        .grade-badge {
            display: inline-block;
            background: #fff8e0;
            border: 1px solid #c9a227;
            color: #7a5200;
            font-size: 14px;
            font-weight: 600;
            padding: 1px 10px;
            border-radius: 3px;
            margin-left: 10px;
            vertical-align: middle;
            font-style: normal;
        }

        /* Marks note */
        .marks-row {
            text-align: center;
            margin-top: 10px;
            font-size: 17px;
            color: #555;
            font-style: italic;
        }

        .marks-row strong {
            color: #333;
            font-style: normal;
        }

        /* Competition title */
        .competition-title {
            text-align: center;
            margin-top: 18px;
            font-family: 'EB Garamond', serif;
            font-style: italic;
            font-size: 23px;
            color: #1a1a1a;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        /* Held / issue dates */
        .held-on {
            text-align: center;
            margin-top: 6px;
            font-family: 'EB Garamond', serif;
            font-style: italic;
            font-size: 20px;
            color: #444;
        }

        .date-of-issue {
            text-align: center;
            font-style: italic;
            font-size: 15px;
            color: #888;
            margin-top: 4px;
        }

        /* Signatures */
        .signatures {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 22px;
        }

        .sign-block { width: 220px; text-align: center; }

        .sign-cursive {
            font-family: 'Great Vibes', cursive;
            font-size: 40px;
            color: #222;
            line-height: 1;
            height: 52px;
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }

        .sign-line {
            width: 100%;
            height: 1px;
            background: #888;
            margin: 5px 0 4px;
        }

        .sign-name {
            font-family: 'EB Garamond', serif;
            font-size: 15px;
            font-weight: 600;
            color: #111;
        }

        .sign-role {
            font-size: 12px;
            color: #666;
            font-style: italic;
            margin-top: 2px;
            line-height: 1.4;
        }

        /* Seal */
        .center-seal { text-align: center; width: 110px; }

        .seal-ring {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            border: 3px dashed #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
        }

        .seal-ring-inner {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            border: 2px solid #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            color: #aaa;
            font-style: italic;
            text-align: center;
            line-height: 1.3;
        }

        /* Flags row */
        .flags-row {
            margin-top: 14px;
            border-top: 1px solid #d4a800;
            border-bottom: 1px solid #d4a800;
            padding: 5px 0;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 3px 5px;
        }

        .flag-item { font-size: 17px; line-height: 1; }

        /* Footer */
        .cert-footer {
            margin-top: 7px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #666;
        }

        .footer-org { font-size: 12px; color: #333; text-align: center; flex: 1; }
        .cert-id-text { font-size: 12px; color: #999; white-space: nowrap; }

        /* Print */
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #1a1a2e;
            color: white;
            border: none;
            padding: 12px 22px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            z-index: 999;
            font-family: Arial, sans-serif;
        }

        sup { font-size: 0.6em; vertical-align: super; }

        @media print {
            body { background: white; padding: 0; }
            .print-btn { display: none; }
            .cert-outer { width: 100%; }
        }

    </style>
</head>
<body>

<button class="print-btn" onclick="window.print()">🖨 Print / Save PDF</button>

<div class="cert-outer">
    <div class="cert-frame">
        <div class="cert-inner">

            <div class="corner corner-tl"></div>
            <div class="corner corner-tr"></div>
            <div class="corner corner-bl"></div>
            <div class="corner corner-br"></div>
            <div class="watermark"></div>

            <div class="content">

                {{-- ── Top row: Logo | Title | Badge ── --}}
                <div class="top-row">

                    <div class="logo-seal">
                        @if(!empty($settings->company_logo))
                            <img class="logo-img"
                                 src="{{ asset('storage/' . $settings->company_logo) }}"
                                 alt="{{ $settings->company_name }}">
                        @else
                            <div class="logo-circle">
                                @php
                                    $words = explode(' ', $settings->company_name ?? 'Indian Abacus Academy');
                                    $initials = strtoupper(implode('', array_map(fn($w) => $w[0], array_slice($words, 0, 3))));
                                @endphp
                                <div class="logo-initials">{{ $initials }}</div>
                                <div class="logo-sub">{{ $settings->company_name ?? 'Indian Abacus Academy' }}</div>
                            </div>
                        @endif
                    </div>

                    <div class="title-area">
                        <div class="cert-script-title">Certificate</div>
                        <div class="certify-text">This is to certify that</div>
                    </div>

                    <div class="right-badge">
                        <div class="badge-circle">
                            <div class="badge-text">
                                International<br>
                                Competition<br>
                                {{ \Carbon\Carbon::parse($certification->exam_date)->format('Y') }}
                            </div>
                        </div>
                    </div>

                </div>

                {{-- ── Student name ── --}}
                <div class="student-name">{{ $certification->student_name }}</div>
                <div class="name-underline"></div>

                {{-- ── Body rows ── --}}
                <div class="cert-body">

                    {{-- "of [Academy Name] — [Centre] Centre" --}}
                    <div class="cert-row">
                        <span class="cert-label">of</span>
                        <span class="cert-value">{{ $settings->company_name ?? 'Indian Abacus Academy' }}</span>
                        @php $centre = trim($certification->centre ?? '', ', '); @endphp
                        @if($centre)
                            <span class="cert-label-after">&emsp;</span>
                            <span class="cert-value-sm">{{ $centre }}</span>
                            <span class="cert-label-after">Centre</span>
                        @endif
                    </div>

                    {{-- "from India" --}}
                    <div class="cert-row">
                        <span class="cert-label">from</span>
                        <span class="cert-value">India</span>
                    </div>

                    {{-- "is [Level] [Grade] in the" --}}
                    <div class="cert-row">
                        <span class="cert-label">is</span>
                        <span class="cert-value">
                            {{ $certification->level }}
                            <span class="grade-badge">{{ $certification->grade }}</span>
                        </span>
                        <span class="cert-label-after">in the</span>
                    </div>

                </div>

                {{-- ── Marks note ── --}}
                <div class="marks-row">
                    with a score of <strong>{{ $certification->marks }} marks</strong>
                    in the examination held on
                    {!! \Carbon\Carbon::parse($certification->exam_date)->format('j<sup>S</sup> F Y') !!}
                </div>

                {{-- ── Competition title ── --}}
                <div class="competition-title">
                    {!! $certification->competition_title
                        ?? ($settings->competition_title
                            ?? ($settings->company_name . ' — Abacus Certification Program')) !!}
                </div>

                {{-- ── Exam date ── --}}
                <div class="held-on">
                    held on {!! \Carbon\Carbon::parse($certification->exam_date)->format('j<sup>S</sup> F Y') !!}.
                </div>

                {{-- ── Certificate issue date ── --}}
                <div class="date-of-issue">
                    Date of issue: {{ \Carbon\Carbon::parse($certification->certificate_date)->format('d M Y') }}
                </div>

                {{-- ── Signatures ── --}}
                <div class="signatures">

                    {{-- Left: Trainer (trainer_name column) --}}
                    <div class="sign-block">
                        <div class="sign-cursive">{{ $certification->trainer_name }}</div>
                        <div class="sign-line"></div>
                        <div class="sign-name">{{ $certification->trainer_name }}</div>
                        <div class="sign-role">
                            Certified Trainer<br>
                            {{ $settings->company_name ?? 'Indian Abacus Academy' }}
                        </div>
                    </div>

                    {{-- Center: Seal --}}
                    <div class="center-seal">
                        <div class="seal-ring">
                            <div class="seal-ring-inner">Seal</div>
                        </div>
                    </div>

                    {{-- Right: Academy Director --}}
                    <div class="sign-block">
                        <div class="sign-cursive">Director</div>
                        <div class="sign-line"></div>
                        <div class="sign-name">Academy Director</div>
                        <div class="sign-role">
                            Director<br>
                            {{ $settings->company_name ?? 'Indian Abacus Academy' }}
                        </div>
                    </div>

                </div>

                {{-- ── Country flags ── --}}
                <div class="flags-row">
                    <span class="flag-item" title="India">🇮🇳</span>
                    <span class="flag-item" title="USA">🇺🇸</span>
                    <span class="flag-item" title="UK">🇬🇧</span>
                    <span class="flag-item" title="Canada">🇨🇦</span>
                    <span class="flag-item" title="Australia">🇦🇺</span>
                    <span class="flag-item" title="UAE">🇦🇪</span>
                    <span class="flag-item" title="Malaysia">🇲🇾</span>
                    <span class="flag-item" title="Singapore">🇸🇬</span>
                    <span class="flag-item" title="Germany">🇩🇪</span>
                    <span class="flag-item" title="France">🇫🇷</span>
                    <span class="flag-item" title="Japan">🇯🇵</span>
                    <span class="flag-item" title="China">🇨🇳</span>
                    <span class="flag-item" title="South Korea">🇰🇷</span>
                    <span class="flag-item" title="Brazil">🇧🇷</span>
                    <span class="flag-item" title="South Africa">🇿🇦</span>
                    <span class="flag-item" title="New Zealand">🇳🇿</span>
                    <span class="flag-item" title="Italy">🇮🇹</span>
                    <span class="flag-item" title="Spain">🇪🇸</span>
                    <span class="flag-item" title="Poland">🇵🇱</span>
                    <span class="flag-item" title="Netherlands">🇳🇱</span>
                </div>

                {{-- ── Footer ── --}}
                <div class="cert-footer">

                    <div class="cert-id-text">
                        <strong>Cert ID:</strong> {{ $certification->tracking_no ?? 'CERT-' . $certification->id }}
                    </div>

                    <div class="footer-org">
                        <strong>{{ $settings->company_name ?? 'Indian Abacus Academy' }}</strong><br>
                        <span style="font-size:11px;color:#999;">
                            {{ $settings->company_address ?? '' }}
                            @if(!empty($settings->company_website))
                                &nbsp;|&nbsp; {{ $settings->company_website }}
                            @endif
                        </span>
                    </div>

                    <div class="cert-id-text">
                        {{ \Carbon\Carbon::parse($certification->certificate_date)->format('d M Y') }}
                    </div>

                </div>

            </div>{{-- .content --}}
        </div>{{-- .cert-inner --}}
    </div>{{-- .cert-frame --}}
</div>{{-- .cert-outer --}}

</body>
</html>