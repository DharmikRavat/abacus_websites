@extends('admin.layout.app')

@section('page-title', 'Terms & Conditions')

@section('style')
@endsection

@section('content')

<div class="roles-header">
    <div>
        <h1>Terms & Conditions</h1>
        <p>Manage website terms & conditions content.</p>
    </div>
</div>

<form action="{{ route('admin.terms-conditions.update', 1) }}"
      method="POST">

    @csrf
    @method('PUT')

    <div class="form-section">


        <div class="form-grid">

            {{-- TITLE --}}
            <div class="form-group full">
                <label class="form-label">Title</label>

                <input type="text"
                       name="title"
                       class="form-control"
                       value="{{ $terms->title ?? '' }}"
                       placeholder="Enter title">
            </div>

            {{-- DESCRIPTION --}}
            <div class="form-group full">
                <label class="form-label">Description</label>

                <textarea name="description"
                          id="description"
                          rows="10"
                          class="form-control">{{ $terms->description ?? '' }}</textarea>
            </div>

            {{-- STATUS --}}
            <div class="form-group full">

                <label class="toggle-row">

                    <div>
                        <div class="toggle-row-label">
                            Terms & Conditions Status
                        </div>

                        <div class="toggle-row-sub">
                            Enable or disable terms & conditions
                        </div>
                    </div>

                    <label class="toggle">

                        <input type="checkbox"
                               name="status"
                               {{ isset($terms) && $terms->status ? 'checked' : '' }}>

                        <span class="toggle-slider"></span>

                    </label>

                </label>

            </div>

        </div>

    </div>

    <div class="card"
         style="padding:20px;text-align:right;">

        <button type="submit"
                class="btn btn-primary">

            Save Terms & Conditions

        </button>

    </div>

</form>

@endsection

@section('script')

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>

    CKEDITOR.config.versionCheck = false;

    CKEDITOR.replace('description', {
        height: 400,
    });

</script>

@endsection