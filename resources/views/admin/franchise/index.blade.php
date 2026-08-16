@extends('admin.layout.app')

@section('page-title', 'Franchise Page')

@section('style')
@endsection

@section('content')

<div class="roles-header">
    <div>
        <h1>Franchise Page</h1>
        <p>Manage Training & Franchise page content.</p>
    </div>
</div>

<form action="{{ isset($franchise) ? route('admin.franchise-page.update',$franchise->id) : route('admin.franchise-page.store') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    @if(isset($franchise))
        @method('PUT')
    @endif

    <div class="form-section">

        <div class="form-grid">

            {{-- PAGE TITLE --}}
            <div class="form-group full">
                <label class="form-label">Page Title</label>

                <input type="text"
                       name="title"
                       class="form-control"
                       value="{{ $franchise->title ?? '' }}"
                       placeholder="Training & Franchise">
            </div>


            {{-- TRAINING DESCRIPTION --}}
            <div class="form-group full">

                <label class="form-label">
                    Training Description
                </label>

                <textarea
                    id="training_description"
                    name="training_description"
                    class="form-control"
                    rows="8">{{ $franchise->training_description ?? '' }}</textarea>

            </div>


            {{-- ADVANTAGES TITLE --}}
            <div class="form-group full">

                <label class="form-label">
                    Advantages Section Title
                </label>

                <input type="text"
                       name="advantages_title"
                       class="form-control"
                       value="{{ $franchise->advantages_title ?? '' }}">

            </div>


            {{-- ADVANTAGES CONTENT --}}
            <div class="form-group full">

                <label class="form-label">
                    Advantages Description
                </label>

                <textarea
                    id="advantages_description"
                    name="advantages_description"
                    rows="10"
                    class="form-control">{{ $franchise->advantages_description ?? '' }}</textarea>

            </div>


            {{-- IMAGE --}}
            <div class="form-group full">

                <label class="form-label">
                    Right Side Image
                </label>

                <input type="file"
                       name="advantages_image"
                       class="form-control">

                @if(isset($franchise) && $franchise->advantages_image)

                    <div style="margin-top:15px">

                        <img
                            src="{{ asset($franchise->advantages_image) }}"
                            width="200"
                            style="border-radius:10px">

                    </div>

                @endif

            </div>


            {{-- WHY JOIN TITLE --}}
            <div class="form-group full">

                <label class="form-label">
                    Why Join Us Title
                </label>

                <input
                    type="text"
                    name="why_join_title"
                    class="form-control"
                    value="{{ $franchise->why_join_title ?? '' }}">

            </div>


            {{-- WHY JOIN DESCRIPTION --}}
            <div class="form-group full">

                <label class="form-label">
                    Why Join Us Description
                </label>

                <textarea
                    id="why_join_description"
                    name="why_join_description"
                    rows="10"
                    class="form-control">{{ $franchise->why_join_description ?? '' }}</textarea>

            </div>

        </div>

    </div>


    <div class="card"
         style="padding:20px;text-align:right;">

        <button
            type="submit"
            class="btn btn-primary">

            Save Franchise Page

        </button>

    </div>

</form>

@endsection

@section('script')

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>

CKEDITOR.replace('training_description',{
    height:250
});

CKEDITOR.replace('advantages_description',{
    height:300
});

CKEDITOR.replace('why_join_description',{
    height:300
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

        let btn=$('button[type="submit"]');

        btn.text('Saving...');

        $.ajax({

            url:$(this).attr('action'),

            type:'POST',

            data:formData,

            processData:false,

            contentType:false,

            success:function(res){

                alert(res.message);

                btn.text('Save Franchise Page');

            },

            error:function(xhr){

                let msg='';

                $.each(xhr.responseJSON.errors,function(k,v){

                    msg+=v+"\n";

                });

                alert(msg);

                btn.text('Save Franchise Page');

            }

        });

    });

});

</script>

@endsection