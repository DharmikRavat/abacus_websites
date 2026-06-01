@extends('admin.layout.app')

@section('content')

{{-- ═══════════ PAGE HEADER ═══════════ --}}
<div class="roles-header">

    <div>
        <h1>Exam Levels</h1>
        <p>Manage difficulty levels for exams</p>
    </div>

    <button class="btn btn-primary"
            onclick="document.getElementById('examLevelForm').requestSubmit()">

        <svg width="14"
             height="14"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2.5">

            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>

            <polyline points="17 21 17 13 7 13 7 21"/>

            <polyline points="7 3 7 8 15 8"/>

        </svg>

        Update Levels

    </button>

</div>

{{-- ═══════════ LEVEL CARD ═══════════ --}}
<div class="card">

    <div class="card-body p-4">

        <form id="examLevelForm">

            @csrf

            @foreach(['easy','medium','hard'] as $difficulty)

            <div class="difficulty-section">

                <h2 class="difficulty-title text-capitalize">
                    {{ $difficulty }}
                </h2>

                <div class="checkbox-group">

                    @for($i = 0; $i <= 10; $i++)

                    <label class="level-item"
                           for="{{ $difficulty }}_{{ $i }}">

                        <input type="checkbox"
                               class="level-checkbox"
                               id="{{ $difficulty }}_{{ $i }}"
                               name="levels[{{ $difficulty }}][{{ $i }}]"
                               value="1">

                        <span class="custom-checkbox">

                            <svg viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="3">

                                <polyline points="20 6 9 17 4 12"></polyline>

                            </svg>

                        </span>

                        <span class="level-label">
                            Level {{ $i }}
                        </span>

                    </label>

                    @endfor

                </div>

            </div>

            @if(!$loop->last)
            <hr class="divider">
            @endif

            @endforeach

        </form>

    </div>

</div>



@endsection

@section('script')

<script>

async function loadLevels() {

    try {

        const res = await fetch("{{ url('/admin/levels') }}", {

        headers: {
    'Accept': 'application/json'
}

        });

        const data = await res.json();

        Object.keys(data).forEach(difficulty => {

            data[difficulty].forEach(item => {

                // ✅ AUTO SELECT CHECKBOX IF ACTIVE

                if (item.is_active == 1) {

                    const checkbox = document.getElementById(
                        `${difficulty}_${item.level}`
                    );

                    if (checkbox) {

                        checkbox.checked = true;

                    }

                }

            });

        });

    } catch (err) {

        console.error(err);

    }

}

document.getElementById('examLevelForm')
.addEventListener('submit', async (e) => {

    e.preventDefault();

    const formData = new FormData(e.target);

    const saveBtn = document.querySelector('.btn-primary');

    saveBtn.disabled = true;

    saveBtn.innerHTML = 'Saving...';

    try {

        const res = await fetch("{{ url('/admin/levels') }}", {

            method: "POST",

            headers: {

                'X-CSRF-TOKEN':
                    document.querySelector('meta[name="csrf-token"]').content,

                'X-Requested-With': 'XMLHttpRequest'

            },

            body: formData

        });

        const data = await res.json();
        console.log(data);

        alert(data.message);

    } catch (err) {

        alert('Something went wrong');

    } finally {

        saveBtn.disabled = false;

        saveBtn.innerHTML = `

            <svg width="14"
                 height="14"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2.5">

                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>

                <polyline points="17 21 17 13 7 13 7 21"/>

                <polyline points="7 3 7 8 15 8"/>

            </svg>

            Save Levels

        `;

    }

});

loadLevels();

</script>

@endsection