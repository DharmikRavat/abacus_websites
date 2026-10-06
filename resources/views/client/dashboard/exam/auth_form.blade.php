@extends('client.layout.app')

@section('style')
<style>
    body {
        background: #f0f4fc;
    }
    .dash {
        padding: 40px 0;
        min-height: 100vh;
    }
    .auth-card {
        background: #fff;
        max-width: 450px;
        margin: auto;
        border-radius: 20px;
        padding: 30px 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .auth-header {
        background: #3b82f6;
        color: #fff;
        text-align: center;
        padding: 20px;
        border-radius: 12px 12px 0 0;
        margin: -30px -20px 25px -20px;
        position: relative;
    }
    .auth-header h2 {
        margin: 0;
        font-size: 1.4rem;
        font-weight: 700;
    }
    .back-btn {
        position: absolute;
        left: 20px;
        top: 22px;
        color: #fff;
        font-size: 1.2rem;
        text-decoration: none;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        font-weight: 700;
        color: #374151;
        font-size: .95rem;
        margin-bottom: 8px;
        display: block;
    }
    .form-control {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 1rem;
        width: 100%;
        color: #111827;
    }
    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, .15);
        outline: none;
    }
    #startBtn {
        background: #3b82f6;
        color: #fff;
        border: none;
        width: 100%;
        padding: 14px;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        transition: .25s;
    }
    #startBtn:disabled {
        background: #9ca3af;
        cursor: not-allowed;
    }
    #startBtn:hover:not(:disabled) {
        background: #2563eb;
    }
</style>
@endsection

@section('content')
<div class="dash">
    <div class="container">
        <div class="auth-card">

            <div class="auth-header">
                <a href="{{ route('dashboard.index') }}" class="back-btn"><i class="fa fa-arrow-left"></i></a>
                <h2>Online {{ ucfirst($type) }}</h2>
            </div>

            @if(session('error'))
                <div style="color: red; margin-bottom: 15px; text-align: center;">{{ session('error') }}</div>
            @endif

            <form action="{{ route('online.assessment.start') }}" method="POST" id="authForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="exam_type" value="{{ $type }}">


                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="student_name" value="" placeholder="Enter Your Full Name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Center Name</label>
                    <select name="center_id" class="form-control" required>
                        <option value="">Select Center Name</option>
                        @foreach($centers as $c)
                            <option value="{{ $c->id }}">{{ $c->center_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" style="position: relative;">
                    <label>Password</label>
                    <input type="password" name="password" id="authPasswordInput" class="form-control" placeholder="Enter Password" required style="padding-right: 40px;">
                    <button type="button" id="toggleAuthPassword" style="position: absolute; right: 12px; top: 38px; border: none; background: transparent; cursor: pointer; color: #6b7280; font-size: 1.1rem;">
                        <i class="fa fa-eye"></i>
                    </button>
                </div>

                <div class="form-group">
                    <label>{{ ucfirst($type) }} Type</label>
                    <select name="schedule_test_type" class="form-control" required>
                        <option value="">Select {{ ucfirst($type) }} Type</option>
                        @if($type === 'exam')
                            <option value="olympiad">Olympiad</option>
                            <option value="final_exam">Final Exam</option>
                        @else
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        @endif
                    </select>
                </div>

                <div class="form-group" id="levelGroup" style="display:none;">
                    <label>Select Level</label>
                    <select name="level_id" class="form-control" required>
                        <option value="">Select Level</option>
                        @foreach($levels as $l)
                            <option value="{{ $l->id }}">Level {{ $l->level }}</option>
                        @endforeach
                    </select>
                </div>

                @if($type === 'exam')
                <div class="form-group" style="background:#f8fafc; padding:20px; border-radius:10px; text-align:center;">
                    <label style="margin-bottom:15px; display:block;">Capture Selfie</label>
                    <div style="margin-bottom: 15px; display: flex; justify-content: center; align-items: center;">
                        <video id="webcam" width="120" height="120" autoplay playsinline style="border-radius: 50%; background: #000; object-fit: cover; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: 4px solid #fff;"></video>
                        <canvas id="canvas" style="display:none;"></canvas>
                        <img id="photo" style="display:none; width: 120px; height: 120px; border-radius: 50%; object-fit: cover; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: 4px solid #fff;" />
                    </div>
                    <div>
                        <button type="button" id="captureBtn" style="padding: 8px 16px; border-radius: 20px; border: none; background: #2563eb; color: #fff; cursor: pointer; font-weight:bold; font-size: 13px;">Capture</button>
                        <button type="button" id="retakeBtn" style="display:none; padding: 8px 16px; border-radius: 20px; border: none; background: #6b7280; color: #fff; cursor: pointer; font-weight:bold; font-size: 13px;">Retake</button>
                    </div>
                    <input type="hidden" name="exam_selfie" id="exam_selfie" value="">
                </div>
                @endif

                <div id="validationErrors" style="color:red; margin-bottom:15px; text-align:center; display:none; font-weight:bold;"></div>

                <button type="submit" id="startBtn">Start Test</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    const startBtn = document.getElementById('startBtn');
    const authForm = document.getElementById('authForm');
    const validationErrors = document.getElementById('validationErrors');
    const typeSelect = document.querySelector('select[name="schedule_test_type"]');
    const levelGroup = document.getElementById('levelGroup');
    const levelSelect = document.querySelector('select[name="level_id"]');
    const passwordInput = document.querySelector('input[name="password"]');
    const examTypeInput = document.querySelector('input[name="exam_type"]');

    const toggleAuthPassword = document.getElementById('toggleAuthPassword');
    if (toggleAuthPassword) {
        toggleAuthPassword.addEventListener('click', function () {
            const pwdInput = document.getElementById('authPasswordInput');
            const type = pwdInput.getAttribute('type') === 'password' ? 'text' : 'password';
            pwdInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fa fa-eye"></i>' : '<i class="fa fa-eye-slash"></i>';
        });
    }

    function autoFetchLevel() {
        let password = passwordInput ? passwordInput.value : '';
        let testType = typeSelect ? typeSelect.value : '';
        let examType = examTypeInput ? examTypeInput.value : '';

        validationErrors.style.display = 'none';

        if (password && testType) {
            startBtn.disabled = true;

            fetch('{{ route("online.assessment.get-level") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    password: password,
                    schedule_test_type: testType,
                    exam_type: examType
                })
            })
            .then(res => res.json())
            .then(data => {
                startBtn.disabled = false;
                if (data.success) {
                    levelSelect.value = data.level_id;
                    levelGroup.style.display = 'block';
                    levelSelect.style.pointerEvents = 'none';
                    levelSelect.style.background = '#e5e7eb'; // Make it look disabled but still submittable
                } else {
                    levelSelect.value = '';
                    levelGroup.style.display = 'none';
                    validationErrors.innerText = "No test schedule found for the provided password and type.";
                    validationErrors.style.display = 'block';
                }
            })
            .catch(err => {
                startBtn.disabled = false;
                console.error(err);
            });
        } else {
            levelGroup.style.display = 'none';
            levelSelect.value = '';
        }
    }

    if (typeSelect) {
        typeSelect.addEventListener('change', autoFetchLevel);
    }
    if (passwordInput) {
        passwordInput.addEventListener('change', autoFetchLevel);
        passwordInput.addEventListener('blur', autoFetchLevel);
    }

    authForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        validationErrors.style.display = 'none';

        // Validation check
        const formData = new FormData(authForm);
        let errors = [];

        if(!formData.get('student_name')) errors.push("Please enter your full name.");
        if(!formData.get('center_id')) errors.push("Please select your center.");
        if(!formData.get('password')) errors.push("Please enter your password.");
        if(!formData.get('schedule_test_type')) errors.push("Please select test type.");
        if(!formData.get('level_id')) errors.push("Please select level.");

        if (examTypeInput && examTypeInput.value === 'exam') {
            if(!formData.get('exam_selfie')) errors.push("Please capture your selfie.");
        }

        if(errors.length > 0) {
            validationErrors.innerHTML = errors.join('<br>');
            validationErrors.style.display = 'block';
            return;
        }

        startBtn.disabled = true;
        startBtn.innerText = 'Starting...';

        try {
            const response = await fetch(authForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();

            if(response.ok && result.success) {
                window.location.href = result.redirect_url;
            } else {
                validationErrors.innerText = result.message || "An error occurred starting the exam.";
                validationErrors.style.display = 'block';
                startBtn.disabled = false;
                startBtn.innerText = 'Start Test';
            }
        } catch (err) {
            console.error(err);
            validationErrors.innerText = "Network error. Please try again.";
            validationErrors.style.display = 'block';
            startBtn.disabled = false;
            startBtn.innerText = 'Start Test';
        }
    });

    const webcam = document.getElementById('webcam');
    const canvas = document.getElementById('canvas');
    const photo = document.getElementById('photo');
    const captureBtn = document.getElementById('captureBtn');
    const retakeBtn = document.getElementById('retakeBtn');
    const examSelfieInput = document.getElementById('exam_selfie');

    if (webcam) {
        navigator.mediaDevices.getUserMedia({ video: true, audio: false })
            .then(function(stream) {
                webcam.srcObject = stream;
            })
            .catch(function(err) {
                console.error("An error occurred: " + err);
            });

        captureBtn.addEventListener('click', function(ev){
            canvas.width = webcam.videoWidth;
            canvas.height = webcam.videoHeight;
            canvas.getContext('2d').drawImage(webcam, 0, 0, canvas.width, canvas.height);
            let data = canvas.toDataURL('image/png');
            photo.setAttribute('src', data);
            examSelfieInput.value = data;

            webcam.style.display = 'none';
            photo.style.display = 'block';
            captureBtn.style.display = 'none';
            retakeBtn.style.display = 'inline-block';
            ev.preventDefault();
        });

        retakeBtn.addEventListener('click', function(ev){
            photo.style.display = 'none';
            webcam.style.display = 'block';
            captureBtn.style.display = 'inline-block';
            retakeBtn.style.display = 'none';
            examSelfieInput.value = '';
            ev.preventDefault();
        });
    }
</script>
@endsection
