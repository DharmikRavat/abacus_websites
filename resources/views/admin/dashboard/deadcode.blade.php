@extends('admin.layout.app')

@section('content')

<!-- GREETING -->
      <div>
        <div class="greet-text">Good morning, Super Admin</div>
        <div class="greet-sub">Here's what's happening across your platform today — April 9, 2026.</div>
      </div>

      <!-- STAT CARDS -->
      <div class="stat-grid">
        <div class="stat-card">
          <div class="stat-top">
            <div class="stat-icon si-blue">
              <svg viewBox="0 0 24 24"><path d="M3 21h18M9 8h1m5 0h1M9 12h1m5 0h1M5 21V5a2 2 0 012-2h10a2 2 0 012 2v16"/></svg>
            </div>
            <span class="trend-pill t-up">+3</span>
          </div>
          <div>
            <div class="stat-val">10</div>
            <div class="stat-lbl">Total Companies</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-top">
            <div class="stat-icon si-amber">
              <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
            </div>
            <span class="trend-pill t-up">+2</span>
          </div>
          <div>
            <div class="stat-val">13</div>
            <div class="stat-lbl">System Users</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-top">
            <div class="stat-icon si-red">
              <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
            </div>
            <span class="trend-pill t-dn">-1</span>
          </div>
          <div>
            <div class="stat-val">2</div>
            <div class="stat-lbl">Active Orders</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-top">
            <div class="stat-icon si-green">
              <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <span class="trend-pill t-up">+1</span>
          </div>
          <div>
            <div class="stat-val">2</div>
            <div class="stat-lbl">Customers</div>
          </div>
        </div>
      </div>

      <!-- ROW 2: Table + Side -->
      <div class="row2">
        <div class="panel">
          <div class="panel-hdr">
            <span class="panel-title">Companies</span>
            <button class="view-all">View all →</button>
          </div>
          <table>
            <thead>
              <tr>
                <th>Company</th>
                <th>Users</th>
                <th>Orders</th>
                <th>Status</th>
                <th>Joined</th>
              </tr>
            </thead>
            <tbody>
              <tr><td><div class="co-name">Acme Corp</div><div class="co-domain">acme.com</div></td><td>4</td><td>1</td><td><span class="pill p-active">Active</span></td><td style="color:var(--faint)">Jan 12</td></tr>
              <tr><td><div class="co-name">Globex Inc</div><div class="co-domain">globex.io</div></td><td>2</td><td>0</td><td><span class="pill p-pending">Pending</span></td><td style="color:var(--faint)">Feb 3</td></tr>
              <tr><td><div class="co-name">Initech LLC</div><div class="co-domain">initech.co</div></td><td>3</td><td>1</td><td><span class="pill p-active">Active</span></td><td style="color:var(--faint)">Feb 18</td></tr>
              <tr><td><div class="co-name">Umbrella Ltd</div><div class="co-domain">umbrella.net</div></td><td>1</td><td>0</td><td><span class="pill p-suspended">Suspended</span></td><td style="color:var(--faint)">Mar 1</td></tr>
              <tr><td><div class="co-name">Weyland-Y</div><div class="co-domain">weyland.ai</div></td><td>3</td><td>0</td><td><span class="pill p-inactive">Inactive</span></td><td style="color:var(--faint)">Mar 22</td></tr>
            </tbody>
          </table>
        </div>

        <div class="side-col">
          <!-- BAR CHART -->
          <div class="panel">
            <div class="panel-hdr">
              <span class="panel-title">Monthly registrations</span>
            </div>
            <div class="chart-wrap">
              <div class="bar-chart" id="barChart"></div>
              <div class="bar-labels" id="barLabels"></div>
              <div class="legend">
                <div class="legend-item"><div class="legend-dot" style="background:#185FA5"></div>Companies</div>
                <div class="legend-item"><div class="legend-dot" style="background:#3B6D11"></div>Users</div>
              </div>
            </div>
          </div>

          <!-- HEALTH -->
          <div class="panel">
            <div class="panel-hdr">
              <span class="panel-title">Platform health</span>
            </div>
            <div class="health-list" id="healthList"></div>
          </div>
        </div>
      </div>

      <!-- ROW 3: Activity + Quick Actions -->
      <div class="row3">
        <div class="panel">
          <div class="panel-hdr">
            <span class="panel-title">Recent activity</span>
            <button class="view-all">View audit log →</button>
          </div>
          <div class="act-list" id="actList"></div>
        </div>

        <div class="panel">
          <div class="panel-hdr">
            <span class="panel-title">Quick actions</span>
          </div>
          <div class="qa-grid">
            <button class="qa-btn">
              <svg viewBox="0 0 24 24"><path d="M3 21h18M9 8h1m5 0h1M9 12h1m5 0h1M5 21V5a2 2 0 012-2h10a2 2 0 012 2v16"/></svg>
              Add Company
            </button>
            <button class="qa-btn">
              <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
              Invite User
            </button>
            <button class="qa-btn">
              <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
              Approvals
            </button>
            <button class="qa-btn">
              <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
              Export Report
            </button>
            <button class="qa-btn">
              <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
              Permissions
            </button>
            <button class="qa-btn">
              <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 010 14.14M4.93 19.07a10 10 0 010-14.14"/></svg>
              Settings
            </button>
          </div>
        </div>
      </div>

@endsection