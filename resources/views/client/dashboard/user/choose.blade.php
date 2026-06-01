
@extends('client.layout.app')

@section('style')

<style>

    .dash{
        padding: 30px 0 80px;
        min-height: 100vh;
        background: #f8fafc;
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
        CARD
    ========================== */

    .form-card{
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(15,23,42,.06);
        border: 1px solid #edf2f7;
        overflow: hidden;
    }

    /* =========================
        BUTTONS
    ========================== */

    .btn-submit{
        height: 50px;
        padding: 0 22px;
        border: none;
        border-radius: 12px;
        background: linear-gradient(135deg,#2563eb,#4f46e5);
        color: #fff !important;
        font-weight: 700;
        font-size: .92rem;
        transition: .25s ease;
        box-shadow: 0 12px 25px rgba(37,99,235,.18);
        text-decoration: none;
    }

    .btn-submit:hover{
        transform: translateY(-2px);
        box-shadow: 0 16px 35px rgba(37,99,235,.25);
    }
.btn-cancel{
    height: 50px;
    padding: 0 22px;
    border: 1px solid #2563eb;
    border-radius: 12px;
    background: transparent;
    color: #2563eb !important;
    font-weight: 700;
    font-size: .92rem;
    transition: .25s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-cancel:hover{
    background: #2563eb;
    color: #fff !important;
    transform: translateY(-2px);
    box-shadow: 0 12px 24px rgba(37,99,235,.18);
}

    /* =========================
        TABLE
    ========================== */

    .table-responsive{
        overflow-x: auto;
    }

    .student-table{
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    .student-table thead{
        background: #f8fafc;
    }

    .student-table thead th{
        padding: 18px 20px;
        font-size: .82rem;
        font-weight: 700;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .student-table tbody td{
        padding: 18px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: .92rem;
        color: #334155;
    }

    .student-table tbody tr{
        transition: .2s ease;
    }

    .student-table tbody tr:hover{
        background: #f8fbff;
    }

    /* =========================
        PROFILE IMAGE
    ========================== */

    .student-img{
        width: 52px;
        height: 52px;
        border-radius: 14px;
        object-fit: cover;
        border: 3px solid #fff;
        box-shadow: 0 5px 18px rgba(0,0,0,.08);
    }

    /* =========================
        BADGES
    ========================== */

    .badge{
        padding: 8px 14px;
        border-radius: 30px;
        font-size: .72rem;
        font-weight: 700;
    }

    .bg-success{
        background: #dcfce7 !important;
        color: #166534 !important;
    }

    .bg-danger{
        background: #fee2e2 !important;
        color: #991b1b !important;
    }

    /* =========================
        ACTION BUTTONS
    ========================== */

    .action-btn{
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: .2s ease;
        text-decoration: none;
    }

    .edit-btn{
        border: 1px solid #2563eb;
        color: #2563eb;
        background: #fff;
    }

    .edit-btn:hover{
        background: #2563eb;
        color: #fff;
    }

    .delete-btn{
        border: 1px solid #ef4444;
        color: #ef4444;
        background: #fff;
    }

    .delete-btn:hover{
        background: #ef4444;
        color: #fff;
    }


.login-btn{
    height: 40px;
    padding: 0 18px;
    border-radius: 10px;
    background: linear-gradient(135deg,#2563eb,#4f46e5);
    color: #fff !important;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: .85rem;
    font-weight: 600;
    text-decoration: none;
    transition: .2s ease;
    box-shadow: 0 8px 20px rgba(37,99,235,.15);
}

.login-btn:hover{
    transform: translateY(-2px);
    box-shadow: 0 12px 24px rgba(37,99,235,.25);
}


    /* =========================
        EMPTY STATE
    ========================== */

    .empty-state{
        padding: 60px 20px;
        text-align: center;
    }

    .empty-state img{
        width: 90px;
        margin-bottom: 16px;
        opacity: .85;
    }

    .empty-state h6{
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 6px;
    }

    .empty-state p{
        color: #6b7280;
        margin: 0;
    }

    /* =========================
        MOBILE
    ========================== */

    @media(max-width:768px){

        .dash{
            padding: 20px 0 60px;
        }

        .page-title{
            font-size: 1.5rem;
        }

        .student-table thead th,
        .student-table tbody td{
            padding: 14px;
            font-size: .84rem;
        }

        .student-img{
            width: 42px;
            height: 42px;
        }

        .btn-submit{
            width: 100%;
            justify-content: center;
            margin-top: 15px;
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
                    Students List
                </h1>

                <p class="page-subtitle">
                    Manage all registered students easily.
                </p>

            </div>

            <a href="{{ route('add-user') }}"
               class="btn-submit d-inline-flex align-items-center">

                <i class="fa fa-plus me-2"></i>
                Add Student

            </a>

        </div>

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))

            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>

        @endif

        {{-- TABLE CARD --}}
        <div class="form-card">

            <div class="table-responsive">

                <table class="table student-table align-middle mb-0">

                    <thead>

                        <tr>

                            <th>#</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            {{-- <th>Center</th> --}}
                            <th>City</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($students as $student)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>

                                    <img
                                        src="{{ $student->profile }}"
                                        class="student-img"> 

                                </td>

                                <td>

                                    <div class="fw-bold text-dark">
                                        {{ $student->name }}
                                    </div>

                                </td>

                                <td>
                                    {{ $student->mobile }}
                                </td>

                                <td>
                                    {{ $student->email ?? '-' }}
                                </td>

                                {{-- <td>
                                    {{ $student->center->center_name ?? '-' }}
                                </td> --}}

                                <td>
                                    {{ $student->city ?? '-' }}
                                </td>

                                <td>

                                    @if($student->isActive == 1)

                                        <span class="badge bg-success">
                                            Active
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Inactive
                                        </span>

                                    @endif

                                </td>


<td class="text-end">

    <div class="d-flex justify-content-end gap-2">
<a href="javascript:void(0)"
   class="login-btn openLoginModal"
   data-id="{{ $student->id }}"
   data-name="{{ $student->name }}">

    <i class="fa fa-sign-in-alt me-1"></i>
    Login

</a>

    </div>

</td>



                            </tr>

                        @empty

                            <tr>

                                <td colspan="9">

                                    <div class="empty-state">

                                        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png">

                                        <h6>
                                            No Students Found
                                        </h6>

                                        <p>
                                            Start by adding your first student.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

{{-- Login Password Modal --}}

<!-- LOGIN MODAL -->
<div class="modal fade" id="studentLoginModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header">

                <h5 class="modal-title">
                    Student Login
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

            </div>

            <form action="{{ route('student.direct.login') }}"
                  method="POST">

                @csrf

                <div class="modal-body">

                    <input type="hidden"
                           name="student_id"
                           id="student_id">

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Student
                        </label>

                        <input type="text"
                               id="student_name"
                               class="form-control"
                               readonly>

                    </div>

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Enter Password
                        </label>

                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="Enter Password"
                               required>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-cancel"
                            data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button type="submit"
                            class="btn-submit">

                        Login Now

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
@endsection



@section('script')

<script>

    $(document).on('click', '.openLoginModal', function () {

        let studentId = $(this).data('id');
        let studentName = $(this).data('name');

        $('#student_id').val(studentId);
        $('#student_name').val(studentName);

        $('#studentLoginModal').modal('show');

    });

</script>

@endsection
