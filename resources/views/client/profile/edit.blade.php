@extends('client.layout.app')

@section('style')
<style>
    .dash{ padding: 30px 0 80px; min-height: 100vh; background: #f8fafc; }
    .page-header{ margin-bottom: 24px; }
    .back-arrow-btn { width: 42px; height: 42px; border-radius: 12px; background: #ffffff; border: 1.5px solid #e2e8f0; display: inline-flex; align-items: center; justify-content: center; color: #334155; font-size: 1.05rem; text-decoration: none; transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 2px 6px rgba(15, 23, 42, 0.05); flex-shrink: 0; }
    .back-arrow-btn:hover { background: #2563eb; border-color: #2563eb; color: #ffffff !important; transform: translateX(-3px); box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25); }
    .page-title{ font-size: 2rem; font-weight: 800; color: #111827; margin-bottom: 6px; }
    .page-subtitle{ color: #6b7280; font-size: .95rem; margin: 0; }
    .form-card{ background: #fff; border-radius: 20px; padding: 35px; box-shadow: 0 10px 40px rgba(15,23,42,.06); border: 1px solid #edf2f7; }
    .profile-upload{ text-align: center; margin-bottom: 35px; }
    .preview-wrapper{ position: relative; width: 120px; height: 120px; margin: auto; }
    .preview-img{ width: 120px; height: 120px; border-radius: 24px; object-fit: cover; border: 4px solid #fff; box-shadow: 0 10px 30px rgba(0,0,0,.08); background: #f8fafc; }
    .upload-btn{ position: absolute; bottom: -5px; right: -5px; width: 38px; height: 38px; border-radius: 12px; background: #2563eb; color: #fff; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 8px 20px rgba(37,99,235,.25); }
    .upload-btn:hover{ background: #1d4ed8; }
    .hidden-input{ display: none; }
    .section-title{ font-size: .78rem; font-weight: 800; text-transform: uppercase; letter-spacing: .12em; color: #94a3b8; margin-bottom: 18px; margin-top: 10px; }
    .form-group{ margin-bottom: 22px; }
    .form-label{ display: block; font-size: .88rem; font-weight: 600; color: #374151; margin-bottom: 8px; }
    .required{ color: #ef4444; }
    .form-control{ width: 100%; height: 54px; border-radius: 10px; border: 1px solid #dbe2ea; padding: 0 16px; font-size: .92rem; transition: .2s ease; background: #fff; box-shadow: none !important; }
    .form-control:focus{ border-color: #2563eb; box-shadow: 0 0 0 4px rgba(37,99,235,.08) !important; }
    select.form-control{ appearance: auto !important; -webkit-appearance: menulist !important; -moz-appearance: menulist !important; cursor: pointer; }
    .btn-submit{ height: 54px; padding: 0 28px; border: none; border-radius: 10px; background: linear-gradient(135deg,#2563eb,#4f46e5); color: #fff; font-weight: 700; font-size: .95rem; transition: .25s ease; box-shadow: 0 12px 25px rgba(37,99,235,.18); }
    .btn-submit:hover{ transform: translateY(-2px); box-shadow: 0 16px 35px rgba(37,99,235,.25); }
    .btn-cancel{ height: 54px; padding: 0 24px; border-radius: 10px; border: 1px solid #dbe2ea; background: #fff; color: #475569; font-weight: 600; margin-right: 10px; transition: .2s ease; }
    .btn-cancel:hover{ background: #f8fafc; }
    @media(max-width: 768px){ .dash{ padding: 20px 0 60px; } .form-card{ padding: 22px; border-radius: 22px; } .page-title{ font-size: 1.6rem; } .preview-img, .preview-wrapper{ width: 100px; height: 100px; } .btn-submit, .btn-cancel{ width: 100%; margin: 0 0 10px; } }
</style>
@endsection

@section('content')
<div class="dash">
<div class="container">
    <div class="page-header d-flex align-items-center gap-3">
        <a href="{{ route('profile') }}" class="back-arrow-btn" title="Back to Profile">
            <i class="fa fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="page-title">Edit Profile</h1>
            <p class="page-subtitle">Update your account information.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success mb-3">
        {{ session('success') }}
    </div>
    @endif

    <div class="form-card">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="profile-upload">
                <div class="preview-wrapper">
                    <img id="previewImg" src="https://ui-avatars.com/api/?name=Student&background=EEF2FF&color=4338CA&size=200" class="preview-img">
                    <label for="profileInput" class="upload-btn">
                        <i class="fa fa-camera"></i>
                    </label>
                </div>
                <input type="file" id="profileInput" name="profile" class="hidden-input" accept="image/*" onchange="previewImage(event)">
            </div>

            <div class="section-title">Basic Details</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Full Name <span class="required">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name ?? '' }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Enrollment No <span class="required">*</span></label>
                        <input type="text" name="student_enrollment_id" class="form-control" value="{{ $user->student_enrollment_id ?? '' }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email ?? '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="passwordInput" class="form-control" value="{{ $user->password ?? '' }}" placeholder="Enter new password to change">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword" style="border-radius: 0 4px 4px 0;">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Mobile Number <span class="required">*</span></label>
                        <input type="text" name="mobile" class="form-control" value="{{ $user->mobile ?? '' }}" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <textarea name="address" rows="4" class="form-control">{{ $user->address ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <div class="section-title">Location Details</div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" value="{{ $user->city ?? '' }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control" value="{{ $user->state ?? '' }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Country</label>
                        <input type="text" name="country" class="form-control" value="{{ $user->country ?? 'India' }}">
                    </div>
                </div>
            </div>

            <div class="section-title">Academic Details</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Select Center</label>
                        <select name="center_id" class="form-control">
                            <option value="">Choose Center</option>
                            @if(isset($centers))
                                @foreach($centers as $center)
                                    <option value="{{ $center->id }}" {{ ($user->center_id == $center->id) ? 'selected' : '' }}>
                                        {{ $center->center_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="button" class="btn-cancel" onclick="window.location.href='{{ route('profile') }}'">Cancel</button>
                <button type="submit" class="btn-submit"><i class="fa fa-save me-2"></i> Save Changes</button>
            </div>
        </form>
    </div>
</div>
</div>
@endsection

@section('script')
<script>
function previewImage(event){
    let reader = new FileReader();
    reader.onload = function(){
        document.getElementById('previewImg').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}

document.getElementById('togglePassword').addEventListener('click', function (e) {
    const passwordInput = document.getElementById('passwordInput');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    this.innerHTML = type === 'password' ? '<i class="fa fa-eye"></i>' : '<i class="fa fa-eye-slash"></i>';
});
</script>
@endsection
