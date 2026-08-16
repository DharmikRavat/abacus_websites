@extends('admin.layout.app')

@section('page-title', 'Program Writeup')

@section('content')

<div class="roles-header">
    <div>
        <h1>Program Writeup</h1>
        <p>Manage Program Writeup content.</p>
    </div>
</div>

<form action="{{ route('admin.program-writeup.update') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    {{-- ================= CONTENT ================= --}}
    <div class="form-section">

        <div class="section-header">
            <h3>Program Content</h3>
            <p>Main description of the program</p>
        </div>

        <div class="form-grid">

            <div class="form-group full">
                <label class="form-label">Paragraph 1</label>

                <textarea
                    name="paragraph_1"
                    id="paragraph_1"
                    rows="6"
                    class="form-control">{{ $programWriteup->paragraph_1 ?? '' }}</textarea>
            </div>

            <div class="form-group full">
                <label class="form-label">Paragraph 2</label>

                <textarea
                    name="paragraph_2"
                    id="paragraph_2"
                    rows="6"
                    class="form-control">{{ $programWriteup->paragraph_2 ?? '' }}</textarea>
            </div>

        </div>

    </div>


    {{-- ================= BULLET POINTS ================= --}}
    <div class="form-section">

        <div class="section-header">
            <h3>Bullet Points</h3>
            <p>Add multiple bullet points</p>
        </div>

        <div id="bullet-wrapper">

            @if(isset($programWriteup) && !empty($programWriteup->bullet_points))

                @foreach($programWriteup->bullet_points as $point)

                    <div class="bullet-item"
                         style="display:flex;gap:10px;margin-bottom:10px;">

                        <input
                            type="text"
                            name="bullet_points[]"
                            class="form-control"
                            value="{{ $point }}"
                            placeholder="Enter Bullet Point">

                        <button
                            type="button"
                            class="btn btn-danger remove-btn">
                            Remove
                        </button>

                    </div>

                @endforeach

            @else

                <div class="bullet-item"
                     style="display:flex;gap:10px;margin-bottom:10px;">

                    <input
                        type="text"
                        name="bullet_points[]"
                        class="form-control"
                        placeholder="Enter Bullet Point">

                    <button
                        type="button"
                        class="btn btn-danger remove-btn">
                        Remove
                    </button>

                </div>

            @endif

        </div>

        <button
            type="button"
            class="btn btn-primary"
            onclick="addBulletField()">

            Add Bullet Point

        </button>

    </div>


    {{-- ================= FOOTER ================= --}}
    <div class="form-section">

        <div class="section-header">
            <h3>Footer Section</h3>
        </div>

        <div class="form-grid">

            <div class="form-group">
                <label class="form-label">Footer Title</label>

                <input
                    type="text"
                    name="footer_title"
                    class="form-control"
                    value="{{ $programWriteup->footer_title ?? '' }}">
            </div>

            <div class="form-group">
                <label class="form-label">Footer Subtitle</label>

                <input
                    type="text"
                    name="footer_subtitle"
                    class="form-control"
                    value="{{ $programWriteup->footer_subtitle ?? '' }}">
            </div>

            <div class="form-group full">
                <label class="form-label">Footer Image</label>

                <input
                    type="file"
                    name="footer_image"
                    class="form-control">

                @if(!empty($programWriteup->footer_image))

                    <div style="margin-top:15px;">

                        <img
                            src="{{ asset('storage/'.$programWriteup->footer_image) }}"
                            width="140"
                            style="border-radius:10px;">

                    </div>

                @endif

            </div>

            <div class="form-group full">
                <label class="form-label">Footer Description</label>

                <textarea
                    name="footer_description"
                    id="footer_description"
                    rows="6"
                    class="form-control">{{ $programWriteup->footer_description ?? '' }}</textarea>
            </div>

        </div>

    </div>


    <div class="card" style="padding:20px;text-align:right;">

        <button
            type="submit"
            class="btn btn-primary">

            Save Program Writeup

        </button>

    </div>

</form>

@endsection


@section('script')

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>

CKEDITOR.replace('paragraph_1',{
    height:250
});

CKEDITOR.replace('paragraph_2',{
    height:250
});

CKEDITOR.replace('footer_description',{
    height:250
});

CKEDITOR.config.versionCheck = false;

</script>

<script>

$(function(){

    $('form').submit(function(e){

        e.preventDefault();

        for (var instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }

        let formData=new FormData(this);

        $.ajax({

            url:$(this).attr('action'),

            type:"POST",

            data:formData,

            processData:false,

            contentType:false,

            beforeSend:function(){

                $('button[type=submit]').text('Saving...');

            },

            success:function(res){

                alert(res.message);

                $('button[type=submit]').text('Save Program Writeup');

            },

            error:function(xhr){

                let errors=xhr.responseJSON.errors;

                let msg='';

                $.each(errors,function(k,v){

                    msg+=v+"\n";

                });

                alert(msg);

                $('button[type=submit]').text('Save Program Writeup');

            }

        });

    });

});


function addBulletField(){

    $('#bullet-wrapper').append(`

        <div class="bullet-item"
             style="display:flex;gap:10px;margin-bottom:10px;">

            <input
                type="text"
                name="bullet_points[]"
                class="form-control"
                placeholder="Enter Bullet Point">

            <button
                type="button"
                class="btn btn-danger remove-btn">

                Remove

            </button>

        </div>

    `);

}

$(document).on('click','.remove-btn',function(){

    $(this).parent().remove();

});

</script>

@endsection