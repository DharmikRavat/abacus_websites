@extends('admin.layout.app')

@section('page-title', 'Edit Employee')

@section('content')



    <div class="card">


        <!-- Header -->
        <div class="roles-header" style="padding:16px 20px;">
            <div>
                <h1>Add Employee</h1>
                <p>Create and manage employee details</p>
            </div>
            <a href="{{ route('admin.employee.index') }}" class="btn btn-primary">← Back</a>
        </div>

        <form method="POST" action="{{ route('admin.employee.store') }}" style="padding:20px;">
            @csrf

            <!-- BASIC INFO -->
            <div class="form-section">
                <div class="section-header">
                    <h3>Basic Information</h3>
                    <p>Personal details of employee</p>
                </div>

                <div class="form-grid">

                    {{-- <div class="form-group">
                        <label class="form-label">Employee Code *</label>
                        <input type="text" name="employee_code" class="form-control" required>
                    </div> --}}

                    <div class="form-group">
                        <label class="form-label">First Name <span class="text-required">*</span></label>
                        <input type="text" name="first_name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Middle Name</label>
                        <input type="text" name="middle_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email <span class="text-required">*</span></label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Phone <span class="text-required">*</span></label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Date of Birth <span class="text-required">*</span></label>
                        <input type="date" name="date_of_birth" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-control">
                            <option value="">Select</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                </div>
            </div>

            <!-- JOB INFO -->
            <div class="form-section">
                <div class="section-header">
                    <h3>Job Information</h3>
                    <p>Employee role and company details</p>
                </div>

                <div class="form-grid">


                    <!-- Department (Single Select) -->
                    <div class="form-group">
                        <label class="form-label">Department<span class="text-required">*</span></label>
                        <select name="department" id="department" class="form-control select2-single" required>
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Designation (Single Select) -->
                    <div class="form-group">
                        <label class="form-label">Designation<span class="text-required">*</span></label>
                        <select name="designation" id="designation" class="form-control select2-single" required>
                            <option value="">Select Designation</option>
                            @foreach($designations as $designation)
                                <option value="{{ $designation->id }}">
                                    {{ $designation->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Role (Multi Select) -->
                    <div class="form-group">
                        <label class="form-label">Role<span class="text-required">*</span></label>
                        <select name="role[]" id="role" class="form-control select2-multiple" multiple required>
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @if($defaultRole && $role->id == $defaultRole->id) selected
                                @endif>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Joining Date <span class="text-required">*</span></label>
                        <input type="date" name="joining_date" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Reporting To <span class="text-required">*</span></label>
                        <input type="text" name="reporting_to" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                </div>
            </div>

            <!-- ADDRESS -->
<div class="form-section">
    <div class="section-header">
        <h3>Address Information</h3>
        <p>Permanent and current address</p>
    </div>

    <div class="form-grid">

        <!-- ================= PERMANENT ADDRESS ================= -->
        <div class="form-group full">
            <label class="form-label">Permanent Address</label>
            <textarea name="address" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label class="form-label">City</label>
            <input type="text" name="city" class="form-control">
        </div>

        <div class="form-group">
            <label class="form-label">State</label>
            <input type="text" name="state" class="form-control">
        </div>

        <div class="form-group">
            <label class="form-label">Country</label>
            <input type="text" name="country" class="form-control">
        </div>

        <div class="form-group">
            <label class="form-label">Pincode</label>
            <input type="text" name="pincode" class="form-control">
        </div>

        <!-- Checkbox -->
        <div class="form-group full">
            <label>
                <input type="checkbox" id="sameAddress">
                Same as Permanent Address
            </label>
        </div>

        <!-- ================= CURRENT ADDRESS ================= -->
        <div class="form-group full">
            <label class="form-label">Current Address</label>
            <textarea name="c_address" id="c_address" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label class="form-label">City</label>
            <input type="text" name="c_city" class="form-control">
        </div>

        <div class="form-group">
            <label class="form-label">State</label>
            <input type="text" name="c_state" class="form-control">
        </div>

        <div class="form-group">
            <label class="form-label">Country</label>
            <input type="text" name="c_country" class="form-control">
        </div>

        <div class="form-group">
            <label class="form-label">Pincode</label>
            <input type="text" name="c_pincode" class="form-control">
        </div>

    </div>
</div>
            <!-- Submit -->
            <div style="margin-top:24px; text-align:right;">
                <button type="submit" class="btn btn-primary">Save Employee</button>
            </div>

        </form>


    </div>

@endsection

@section('script')

    <script>
        document.getElementById('sameAddress').addEventListener('change', function () {
            if (this.checked) {
                document.getElementById('c_address').value =
                    document.querySelector('[name="address"]').value;
            }
        });

    </script>


    <script>
        $(document).ready(function () {

            $(document).ready(function () {

                $('.select2-single').select2({
                    placeholder: "Select option",
                    allowClear: true,
                    width: 'resolve' // 🔥 important
                });

                $('.select2-multiple').select2({
                    placeholder: "Select roles",
                    width: 'resolve' // 🔥 important
                });

            });

        });
    </script>
    <script>
    document.getElementById('sameAddress').addEventListener('change', function () {

    if (this.checked) {
        document.querySelector('[name="c_address"]').value =
            document.querySelector('[name="address"]').value;

        document.querySelector('[name="c_city"]').value =
            document.querySelector('[name="city"]').value;

        document.querySelector('[name="c_state"]').value =
            document.querySelector('[name="state"]').value;

        document.querySelector('[name="c_country"]').value =
            document.querySelector('[name="country"]').value;

        document.querySelector('[name="c_pincode"]').value =
            document.querySelector('[name="pincode"]').value;
    }

});</script>
@endsection