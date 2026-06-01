@extends('client.layout.app')

@section('style')


<style>



    .dash{
        padding: 30px 0 80px;
        min-height: 100vh;
    }

    /* =========================
        PAGE HEADER
    ========================== */

    .page-header{
        margin-bottom: 24px;
    }

    .page-title{
        font-size: 2rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 6px;
    }

    .page-subtitle{
        color: #6b7280;
        font-size: .95rem;
        margin: 0;
    }

    /* =========================
        FORM CARD
    ========================== */

    .form-card{
        background: #fff;
        border-radius: 20px;
        padding: 35px;
        box-shadow: 0 10px 40px rgba(15,23,42,.06);
        border: 1px solid #edf2f7;
    }

    /* =========================
        PROFILE UPLOAD
    ========================== */

    .profile-upload{
        text-align: center;
        margin-bottom: 35px;
    }

    .preview-wrapper{
        position: relative;
        width: 120px;
        height: 120px;
        margin: auto;
    }

    .preview-img{
        width: 120px;
        height: 120px;
        border-radius: 24px;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,.08);
        background: #f8fafc;
    }

    .upload-btn{
        position: absolute;
        bottom: -5px;
        right: -5px;
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: #2563eb;
        color: #fff;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(37,99,235,.25);
    }

    .upload-btn:hover{
        background: #1d4ed8;
    }

    .hidden-input{
        display: none;
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
        margin-bottom: 18px;
        margin-top: 10px;
    }

    /* =========================
        FORM GROUP
    ========================== */

    .form-group{
        margin-bottom: 22px;
    }

    .form-label{
        display: block;
        font-size: .88rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .required{
        color: #ef4444;
    }

    .form-control{
        width: 100%;
        height: 54px;
        border-radius: 10px;
        border: 1px solid #dbe2ea;
        padding: 0 16px;
        font-size: .92rem;
        transition: .2s ease;
        background: #fff;
        box-shadow: none !important;
    }

    textarea.form-control{
        height: auto;
        padding-top: 14px;
        resize: none;
    }

    .form-control:focus{
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37,99,235,.08) !important;
    }

    select.form-control{
        appearance: auto !important;
        -webkit-appearance: menulist !important;
        -moz-appearance: menulist !important;
        cursor: pointer;
    }

    /* =========================
        BUTTONS
    ========================== */

    .btn-submit{
        height: 54px;
        padding: 0 28px;
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg,#2563eb,#4f46e5);
        color: #fff;
        font-weight: 700;
        font-size: .95rem;
        transition: .25s ease;
        box-shadow: 0 12px 25px rgba(37,99,235,.18);
    }

    .btn-submit:hover{
        transform: translateY(-2px);
        box-shadow: 0 16px 35px rgba(37,99,235,.25);
    }

    .btn-cancel{
        height: 54px;
        padding: 0 24px;
        border-radius: 10px;
        border: 1px solid #dbe2ea;
        background: #fff;
        color: #475569;
        font-weight: 600;
        margin-right: 10px;
        transition: .2s ease;
    }

    .btn-cancel:hover{
        background: #f8fafc;
    }

    /* =========================
        MOBILE
    ========================== */

    @media(max-width: 768px){

        .dash{
            padding: 20px 0 60px;
        }

        .form-card{
            padding: 22px;
            border-radius: 22px;
        }

        .page-title{
            font-size: 1.6rem;
        }

        .preview-img{
            width: 100px;
            height: 100px;
        }

        .preview-wrapper{
            width: 100px;
            height: 100px;
        }

        .btn-submit,
        .btn-cancel{
            width: 100%;
            margin: 0 0 10px;
        }

    }

</style>
@endsection


@section('content')

<div class="dash">

<div class="container">

    {{-- PAGE HEADER --}}
    <div class="page-header">

        <h1 class="page-title">
            Add New Student
        </h1>

        <p class="page-subtitle">
            Create a new student profile and manage admissions easily.
        </p>

    </div>

    {{-- FORM CARD --}}
    @if(session('success'))

    <div class="alert alert-success mb-3">
        {{ session('success') }}
    </div>

@endif
    <div class="form-card">

<form action="{{ route('store-user') }}"
      method="POST"
      enctype="multipart/form-data">
            @csrf

            {{-- PROFILE IMAGE --}}
            <div class="profile-upload">

                <div class="preview-wrapper">

                    <img id="previewImg"
                         src="https://ui-avatars.com/api/?name=Student&background=EEF2FF&color=4338CA&size=200"
                         class="preview-img">

                    <label for="profileInput" class="upload-btn">
                        <i class="fa fa-camera"></i>
                    </label>

                </div>

                <input type="file"
                       id="profileInput"
                       name="profile"
                       class="hidden-input"
                       accept="image/*"
                       onchange="previewImage(event)">

            </div>

            {{-- BASIC DETAILS --}}
            <div class="section-title">
                Basic Details
            </div>

            <div class="row">

                {{-- NAME --}}
                <div class="col-md-6">

                    <div class="form-group">

                        <label class="form-label">
                            Full Name <span class="required">*</span>
                        </label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="Enter full name"
                               required>

                    </div>

                </div>

                {{-- EMAIL --}}
                <div class="col-md-6">

                    <div class="form-group">

                        <label class="form-label">
                            Email Address
                        </label>

                        <input type="email"
                               name="email"
                               class="form-control"
                               placeholder="Enter email address">

                    </div>

                </div>

                {{-- PASSWORD --}}
                <div class="col-md-6">

                    <div class="form-group">

                        <label class="form-label">
                            Password <span class="required">*</span>
                        </label>

                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="Create password"
                               required>

                    </div>

                </div>

                {{-- MOBILE --}}
                <div class="col-md-6">

                    <div class="form-group">

                        <label class="form-label">
                            Mobile Number <span class="required">*</span>
                        </label>

                        <input type="text"
                               name="mobile"
                               class="form-control"
                               placeholder="Enter mobile number"
                               required>

                    </div>

                </div>

                {{-- ADDRESS --}}
                <div class="col-md-12">

                    <div class="form-group">

                        <label class="form-label">
                            Address
                        </label>

                        <textarea name="address"
                                  rows="4"
                                  class="form-control"
                                  placeholder="Enter complete address"></textarea>

                    </div>

                </div>

            </div>

            {{-- LOCATION --}}
            <div class="section-title">
                Location Details
            </div>

            <div class="row">

                {{-- CITY --}}
                <div class="col-md-4">

                    <div class="form-group">

                        <label class="form-label">
                            City
                        </label>

                        <input type="text"
                               name="city"
                               class="form-control"
                               placeholder="Enter city">

                    </div>

                </div>

                {{-- STATE --}}
                <div class="col-md-4">

                    <div class="form-group">

                        <label class="form-label">
                            State
                        </label>

                        <input type="text"
                               name="state"
                               class="form-control"
                               placeholder="Enter state">

                    </div>

                </div>

                {{-- COUNTRY --}}
                <div class="col-md-4">

                    <div class="form-group">

                        <label class="form-label">
                            Country
                        </label>

                        <input type="text"
                               name="country"
                               class="form-control"
                               value="India">

                    </div>

                </div>

            </div>

            {{-- CENTER --}}
            <div class="section-title">
                Academic Details
            </div>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">

                        <label class="form-label">
                            Select Center
                        </label>

                        <select name="center_id" class="form-control">

                            <option value="">
                                Choose Center
                            </option>

                            @foreach($centers as $center)

                                <option value="{{ $center->id }}">
                                    {{ $center->center_name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

            </div>

            {{-- SUBMIT --}}
            <div class="text-end mt-4">

                <button type="button" class="btn-cancel" onclick="window.location.href='{{ route('dashboard.index') }}'">
                    Cancel
                </button>

                <button type="submit" class="btn-submit">
                    <i class="fa fa-save me-2"></i>
                    Save Student
                </button>

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


</script>

@endsection