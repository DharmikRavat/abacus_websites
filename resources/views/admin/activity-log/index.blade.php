@extends('admin.layout.app')

@section('style')
<style>
.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:12px;
    margin:0px 0;
}

.stat-card{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:10px;
    padding:12px 14px;
    box-shadow:0 1px 2px rgba(0,0,0,.04);
}

.stat-title{
    font-size:11px;
    color:#6b7280;
    font-weight:600;
    margin-bottom:10px;
    text-transform:uppercase;
    letter-spacing:.5px;
}

.stat-value{
    font-size:24px;
    font-weight:700;
    color:#111827;
    line-height:1;
}

.stat-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:5px 0;
    font-size:13px;
    border-bottom:1px solid #f3f4f6;
}

.stat-row:last-child{
    border-bottom:none;
    padding-bottom:0;
}

.stat-row span{
    color:#6b7280;
}

.stat-row strong{
    color:#111827;
    font-size:13px;
}
</style>

@endsection

@section('content')
{{-- ═══════════ PAGE HEADER ═══════════ --}}
<div class="roles-header">
    <div>
        <h1>Activity Log</h1>
        <p>View user log info.</p>
    </div>
</div>

{{-- ═══════════ STATISTICS ═══════════ --}}
<div class="stats-grid">

    <div class="stat-card">
        <div class="stat-title">Total Logins</div>
        <div class="stat-value">{{ $stats['total'] }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-title">Platforms</div>

        @forelse($stats['platforms'] as $platform => $count)
            <div class="stat-row">
                <span>{{ ucfirst($platform) }}</span>
                <strong>{{ $count }}</strong>
            </div>
        @empty
            <small>No data</small>
        @endforelse
    </div>

    <div class="stat-card">
        <div class="stat-title">Top Browsers</div>

        @forelse($stats['browsers'] as $browser)
            <div class="stat-row">
                <span>{{ $browser->browser ?: 'Unknown' }}</span>
                <strong>{{ $browser->total }}</strong>
            </div>
        @empty
            <small>No data</small>
        @endforelse
    </div>

    <div class="stat-card">
        <div class="stat-title">Device Types</div>

        @forelse($stats['devices'] as $device)
            <div class="stat-row">
                <span>{{ $device->device_type ?: 'Unknown' }}</span>
                <strong>{{ $device->total }}</strong>
            </div>
        @empty
            <small>No data</small>
        @endforelse
    </div>

</div>

<div class="card">

    <div class="search-bar">
        <svg width="15" height="15" viewBox="0 0 24 24"
             fill="none" stroke="currentColor"
             stroke-width="2"
             style="color:var(--faint);flex-shrink:0">
            <circle cx="11" cy="11" r="8"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>

        <input type="text"
               id="searchInput"
               placeholder="Search..."
               oninput="filterFaqs(this.value)">

        <span id="faq-count"
              style="font-size:12px;color:var(--faint);white-space:nowrap">
        </span>
    </div>

<div style="overflow-x:auto">

    <table class="roles-table">

        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Platform</th>
                <th>Browser</th>
                <th>Operating System</th>
                <th>Device</th>
                <th>IP Address</th>
                <th>Location</th>
                <th>Login Time</th>
            
            </tr>
        </thead>

        <tbody>

            @forelse($logs as $log)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>
                        <strong>{{ optional($log->user)->name ?? 'N/A' }}</strong>
                        <br>
                        <small>{{ optional($log->user)->email ?? '' }}</small>
                    </td>

                    <td>
                        <span class="badge badge-success">
                            {{ ucfirst($log->login_from) }}
                        </span>
                    </td>

                    <td>
                        {{ $log->browser }}
                        <br>
                        <small>{{ $log->browser_version }}</small>
                    </td>

                    <td>
                        {{ $log->os }}
                        <br>
                        <small>{{ $log->os_version }}</small>
                    </td>

                    <td>
                        {{ $log->device ?: '-' }}
                        <br>
                        <small>{{ $log->device_type }}</small>
                    </td>

                    <td>{{ $log->ip }}</td>

                    <td>
                        @if($log->latitude && $log->longitude)
                            {{ $log->latitude }},
                            {{ $log->longitude }}
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($log->login_at)->format('d M Y') }}
                        <br>
                        <small>
                            {{ \Carbon\Carbon::parse($log->login_at)->format('h:i A') }}
                        </small>
                    </td>


                </tr>

            @empty

                <tr>
                    <td colspan="10">

                        <div id="emptyState" class="empty-state">

                            <svg width="40"
                                 height="40"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.5">

                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 8v4l3 2"/>

                            </svg>

                            <p>No Login Logs Found</p>

                            <span>
                                User login activity will appear here.
                            </span>

                        </div>

                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>

</div>
<div class="pagination-wrapper mt-3">
    {{ $logs->links() }}
</div>

@endsection

@section('script')
<script>
function filterFaqs(search) {

    search = search.toLowerCase().trim();

    const tbody = document.getElementById('logBody');
    const rows = tbody.querySelectorAll('tr');

    let visibleCount = 0;

    rows.forEach(row => {

        const text = row.innerText.toLowerCase();

        if (text.includes(search)) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }

    });

    const count = document.getElementById('faq-count');

    if (count) {
        count.textContent = `${visibleCount} Result${visibleCount !== 1 ? 's' : ''}`;
    }

}
</script>

@endsection