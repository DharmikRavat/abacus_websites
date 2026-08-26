@extends('admin.layout.app')

@section('content')

<div class="roles-header">
    <div>
        <h2>Exam Results</h2>
        <p>Manage declared examination results</p>
    </div>
</div>


{{-- Statistics --}}
{{-- STAT CARDS --}}
<div class="stat-grid">

    {{-- TOTAL RESULTS --}}
    <div class="stat-card">

        <div class="stat-top">

            <div class="stat-icon si-blue">
                <svg viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                    <path d="M14 2v6h6"/>
                    <path d="M8 13h8"/>
                    <path d="M8 17h5"/>
                </svg>
            </div>

            <span class="trend-pill t-up">
                Results
            </span>

        </div>

        <div>
            <div class="stat-val">
                {{ $scores ?? 0 }}
            </div>

            <div class="stat-lbl">
                Total Exam Results
            </div>
        </div>

    </div>


    {{-- DECLARED --}}
    <div class="stat-card">

        <div class="stat-top">

            <div class="stat-icon si-amber">
                <svg viewBox="0 0 24 24">

                    <path d="M9 11l3 3L22 4"/>

                    <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>

                </svg>
            </div>

            <span class="trend-pill t-up">
                Declared
            </span>

        </div>

        <div>

            <div class="stat-val">
                {{ \App\Models\ExamResult::count() }}
            </div>

            <div class="stat-lbl">
                Results Declared
            </div>

        </div>

    </div>


    {{-- PASS --}}
    <div class="stat-card">

        <div class="stat-top">

            <div class="stat-icon si-green">
                <svg viewBox="0 0 24 24">

                    <circle cx="12"
                            cy="12"
                            r="9"/>

                    <path d="M8 12l3 3 5-6"/>

                </svg>
            </div>

            <span class="trend-pill t-up">
                Passed
            </span>

        </div>

        <div>

            <div class="stat-val">
                {{ \App\Models\ExamResult::where('result', 'Pass')->count() }}
            </div>

            <div class="stat-lbl">
                Passed Results
            </div>

        </div>

    </div>


    {{-- FAIL --}}
    <div class="stat-card">

        <div class="stat-top">

            <div class="stat-icon si-purple">
                <svg viewBox="0 0 24 24">

                    <circle cx="12"
                            cy="12"
                            r="9"/>

                    <path d="M9 9l6 6"/>
                    <path d="M15 9l-6 6"/>

                </svg>
            </div>

            <span class="trend-pill t-up">
                Failed
            </span>

        </div>

        <div>

            <div class="stat-val">
                {{ \App\Models\ExamResult::where('result', 'Fail')->count() }}
            </div>

            <div class="stat-lbl">
                Failed Results
            </div>

        </div>

    </div>

</div>


{{-- Results Table --}}
{{-- ═══════════════════════════════════════════════
   RESULTS TABLE
═══════════════════════════════════════════════ --}}
<div class="card">

    {{-- SEARCH --}}
    <div class="search-bar">

        <svg width="15"
             height="15"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2"
             style="color:var(--faint);flex-shrink:0">

            <circle cx="11"
                    cy="11"
                    r="8"/>

            <line x1="21"
                  y1="21"
                  x2="16.65"
                  y2="16.65"/>

        </svg>

        <input type="text"
               id="searchInput"
               placeholder="Search student / exam / result..."
               oninput="filterExamResults(this.value)">

        <span id="result-count"
              style="font-size:12px;color:var(--faint);white-space:nowrap">
        </span>

    </div>


    {{-- TABLE --}}
    <div style="overflow-x:auto">

        <table class="roles-table">

            <thead>

                <tr>

                    <th style="width:40px">#</th>

                    <th>Student</th>

                    <th>Exam Level</th>

                    <th>Exam Type</th>

                    <th>Total</th>

                    <th>Correct</th>

                    <th>Wrong</th>

                    <th>Time</th>

                    <th>Result</th>

                    <th>Remark</th>

                    <th>Declared By</th>

                    <th>Declared Date</th>

                </tr>

            </thead>


            <tbody id="examResultBody">

                @forelse($results as $key => $result)

                    <tr>

                        <td>
                            {{ $results->firstItem() + $key }}
                        </td>

                        <td>
                            {{ $result->student->name ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $result->score->exam_level ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $result->score->exam_type ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $result->score->total ?? 0 }}
                        </td>

                        <td>
                            <strong>
                                {{ $result->score->correct ?? 0 }}
                            </strong>
                        </td>

                        <td>
                            {{ $result->score->wrong ?? 0 }}
                        </td>

                        <td>
                            {{ $result->score->time ?? 0 }}
                        </td>

                        <td>

                            @if($result->result === 'Pass')

                                <span class="badge bg-success">
                                    Pass
                                </span>

                            @elseif($result->result === 'Fail')

                                <span class="badge bg-danger">
                                    Fail
                                </span>

                            @else

                                <span class="badge bg-secondary">
                                    {{ $result->result ?? 'Pending' }}
                                </span>

                            @endif

                        </td>

                        <td>
                            {{ $result->remark ?? '-' }}
                        </td>

                        <td>
                            {{ $result->declaredBy->name ?? '-' }}
                        </td>

                        <td>
                            {{ $result->declared_at
                                ? $result->declared_at->format('d-m-Y H:i')
                                : '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="12"
                            style="
                                text-align:center;
                                padding:30px;
                                color:var(--faint);
                            ">

                            No exam results declared.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>


        {{-- EMPTY SEARCH STATE --}}
        <div id="emptyState"
             class="empty-state"
             style="display:none">

            <svg width="40"
                 height="40"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="1.5">

                <circle cx="12"
                        cy="12"
                        r="10"/>

                <path d="M9 12l2 2 4-4"/>

            </svg>

            <p>No Exam Results Found</p>

            <span>
                Try another search keyword
            </span>

        </div>


        {{-- PAGINATION --}}
        <div class="pagination">

            {{ $results->links() }}

        </div>

    </div>

</div>

@endsection