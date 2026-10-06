@extends('admin.layout.app')

@section('page-title', 'About Us')

@section('style')
@endsection

@section('content')

{{-- ═══════════ PAGE HEADER ═══════════ --}}
<div class="roles-header">
    <div>
        <h1>About Us</h1>
        <p>Manage website about us content, vision and mission.</p>
    </div>
</div>

<form action="{{ isset($about) ? route('admin.about-us.update', $about->id) : route('admin.about-us.store') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    @if(isset($about))
        @method('PUT')
    @endif


    {{-- ================= ABOUT SECTION ================= --}}
    <div class="form-section">

        <div class="form-grid">

            {{-- USER IMAGE --}}
            <div class="form-group full">
                <label class="form-label">User Image</label>

                <input type="file"
                       name="user_image"
                       class="form-control">

                @if(isset($about) && $about->user_image)
                    <div style="margin-top:10px;">
<img src="{{ asset($about->user_image) }}"
     width="120"
     style="border-radius:10px;">
                    </div>
                @endif
            </div>


       {{-- DESCRIPTION --}}
<div class="form-group full">
    <label class="form-label">Description</label>

    <textarea name="description_one"
              id="description_one"
              rows="6"
              class="form-control">{{ $about->description_one ?? '' }}</textarea>
</div>


{{-- ABACUS ADVANTAGE --}}
<div class="form-group full">
    <label class="form-label">Abacus Advantage</label>

    <textarea name="abacus_advantage"
              id="abacus_advantage"
              rows="6"
              class="form-control">{{ $about->abacus_advantage ?? '' }}</textarea>
</div>

            {{-- ADVANTAGE IMAGE --}}
            <div class="form-group full">
                <label class="form-label">Advantage Image</label>

                <input type="file"
                       name="advantage_image"
                       class="form-control">

                @if(isset($about) && $about->advantage_image)
                    <div style="margin-top:10px;">
                        <img src="{{ asset($about->advantage_image) }}"
                             width="120"
                             style="border-radius:10px;">
                    </div>
                @endif
            </div>

        </div>

    </div>


    {{-- ================= VISION ================= --}}
    <div class="form-section">

        <div class="section-header">
            <h3>Vision</h3>
            <p>Add multiple vision bullet points</p>
        </div>

        <div id="vision-wrapper">

            @if(isset($about) && !empty($about->vision))

                @foreach($about->vision as $vision)

                    <div class="vision-item"
                         style="display:flex;gap:10px;margin-bottom:10px;">

                        <input type="text"
                               name="vision[]"
                               class="form-control"
                               value="{{ $vision }}"
                               placeholder="Enter vision point">

                        <button type="button"
                                class="btn btn-danger remove-btn">
                            Remove
                        </button>

                    </div>

                @endforeach

            @else

                <div class="vision-item"
                     style="display:flex;gap:10px;margin-bottom:10px;">

                    <input type="text"
                           name="vision[]"
                           class="form-control"
                           placeholder="Enter vision point">

                    <button type="button"
                            class="btn btn-danger remove-btn">
                        Remove
                    </button>

                </div>

            @endif

        </div>

        <button type="button"
                class="btn btn-primary"
                onclick="addVisionField()">
            Add Vision Point
        </button>

    </div>


    {{-- ================= MISSION ================= --}}
    <div class="form-section">

        <div class="section-header">
            <h3>Mission</h3>
            <p>Add multiple mission bullet points</p>
        </div>

        <div id="mission-wrapper">

            @if(isset($about) && !empty($about->mission))

                @foreach($about->mission as $mission)

                    <div class="mission-item"
                         style="display:flex;gap:10px;margin-bottom:10px;">

                        <input type="text"
                               name="mission[]"
                               class="form-control"
                               value="{{ $mission }}"
                               placeholder="Enter mission point">

                        <button type="button"
                                class="btn btn-danger remove-btn">
                            Remove
                        </button>

                    </div>

                @endforeach

            @else

                <div class="mission-item"
                     style="display:flex;gap:10px;margin-bottom:10px;">

                    <input type="text"
                           name="mission[]"
                           class="form-control"
                           placeholder="Enter mission point">

                    <button type="button"
                            class="btn btn-danger remove-btn">
                        Remove
                    </button>

                </div>

            @endif

        </div>

        <button type="button"
                class="btn btn-primary"
                onclick="addMissionField()">
            Add Mission Point
        </button>

    </div>


    {{-- SAVE BUTTON --}}
    <div class="card"
         style="padding:20px;text-align:right;">

        <button type="submit"
                class="btn btn-primary">

            Save About Us

        </button>

    </div>

</form>

@endsection


@section('script')

{{-- CKEDITOR CDN --}}
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>

    // DESCRIPTION EDITOR
    CKEDITOR.replace('description_one', {
        height: 250,
    });

    // ABACUS ADVANTAGE EDITOR
    CKEDITOR.replace('abacus_advantage', {
        height: 250,
    });
     CKEDITOR.config.versionCheck = false;


</script>
<script>
$(document).ready(function () {

    $('form').on('submit', function (e) {

        e.preventDefault();

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT:
        | Sync CKEditor content back to textarea
        |--------------------------------------------------------------------------
        */
        for (let instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }

        let form = $(this)[0];

        let formData = new FormData(form);

        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,

            beforeSend: function () {

                $('button[type="submit"]')
                    .prop('disabled', true)
                    .text('Saving...');

            },

            success: function (res) {

                if (res.success) {
                    alert(res.message);
                }

                $('button[type="submit"]')
                    .prop('disabled', false)
                    .text('Save About Us');

            },

            error: function (xhr) {

                let msg = 'Something went wrong.';

                if (xhr.responseJSON) {

                    if (xhr.responseJSON.errors) {

                        msg = '';

                        $.each(
                            xhr.responseJSON.errors,
                            function (key, value) {

                                msg += value.join
                                    ? value.join('\n') + "\n"
                                    : value + "\n";

                            }
                        );

                    } else if (xhr.responseJSON.message) {

                        msg = xhr.responseJSON.message;

                    }

                }

                alert(msg);

                $('button[type="submit"]')
                    .prop('disabled', false)
                    .text('Save About Us');

            }

        });

    });

});

    // ADD VISION FIELD
    function addVisionField() {

        let html = `
            <div class="vision-item"
                 style="display:flex;gap:10px;margin-bottom:10px;">

                <input type="text"
                       name="vision[]"
                       class="form-control"
                       placeholder="Enter vision point">

                <button type="button"
                        class="btn btn-danger remove-btn">
                    Remove
                </button>

            </div>
        `;

        $('#vision-wrapper').append(html);
    }


    // ADD MISSION FIELD
    function addMissionField() {

        let html = `
            <div class="mission-item"
                 style="display:flex;gap:10px;margin-bottom:10px;">

                <input type="text"
                       name="mission[]"
                       class="form-control"
                       placeholder="Enter mission point">

                <button type="button"
                        class="btn btn-danger remove-btn">
                    Remove
                </button>

            </div>
        `;

        $('#mission-wrapper').append(html);
    }


    // REMOVE FIELD
    $(document).on('click', '.remove-btn', function () {
        $(this).parent().remove();
    });

</script>

@endsection