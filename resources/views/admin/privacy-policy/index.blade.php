@extends('admin.layout.app')

@section('page-title', 'Privacy Policy')

@section('style')
@endsection

@section('content')

{{-- ═══════════ PAGE HEADER ═══════════ --}}
<div class="roles-header">
    <div>
        <h1>Privacy Policy</h1>
        <p>Manage website privacy policy content.</p>
    </div>
</div>

<form action="{{ route('admin.privacy-policy.update',1) }}"
      method="POST">

    @csrf
    @method('PUT')


    {{-- ================= PRIVACY POLICY SECTION ================= --}}
    <div class="form-section">


        <div class="form-grid">

            {{-- TITLE --}}
            <div class="form-group full">
                <label class="form-label">Title</label>

                <input type="text"
                       name="title"
                       class="form-control"
                       value="{{ $policy->title ?? '' }}"
                       placeholder="Enter title">
            </div>


            {{-- DESCRIPTION --}}
            <div class="form-group full">
                <label class="form-label">Description</label>

                <textarea name="description"
                          id="description"
                          rows="10"
                          class="form-control">{{ $policy->description ?? '' }}</textarea>
            </div>


            {{-- STATUS --}}
            <div class="form-group full">

                <label class="toggle-row">

                    <div>
                        <div class="toggle-row-label">
                            Privacy Policy Status
                        </div>

                        <div class="toggle-row-sub">
                            Enable or disable privacy policy
                        </div>
                    </div>

                    <label class="toggle">

                        <input type="checkbox"
                               name="status"
                               {{ isset($policy) && $policy->status ? 'checked' : '' }}>

                        <span class="toggle-slider"></span>

                    </label>

                </label>

            </div>

        </div>

    </div>


    {{-- SAVE BUTTON --}}
    <div class="card"
         style="padding:20px;text-align:right;">

        <button type="submit"
                class="btn btn-primary">

            Save Privacy Policy

        </button>

    </div>

</form>

@endsection


@section('script')

{{-- CKEDITOR CDN --}}
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>

    CKEDITOR.config.versionCheck = false;

    // DESCRIPTION EDITOR
    CKEDITOR.replace('description', {
        height: 400,
    });

</script>
<script>
$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('form').on('submit', function (e) {
        e.preventDefault();

        // IMPORTANT: update CKEditor textarea before submit
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }

        let form = $(this)[0];
        let formData = new FormData(form);

        $.ajax({
            url: $(this).attr('action'),
            type: "POST",   // Laravel PUT handled by _method
            data: formData,
            processData: false,
            contentType: false,

            beforeSend: function () {
                $('button[type="submit"]').text('Saving...');
            },
   success: function (res) {

                if (res.success) {
                    alert(res.message);
                }

                $('button[type="submit"]').text('Save Privacy Policy');
            },

            error: function (xhr) {

                let msg = '';

                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        msg += value + "\n";
                    });
                } else {
                    msg = 'Something went wrong!';
                }

                Swal.fire({
                    icon: 'error',
                    title: msg
                });

                $('button[type="submit"]').text('Save Privacy Policy');
            }
        });

    });

});</script>

@endsection