    <header class="topbar">
      <button class="menu-btn" onclick="toggleSidebar()">
        <svg viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
      <span class="page-title">@yield('page-title')</span>
      <div class="topbar-right">
        <button class="tb-pill">
          <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          Search
        </button>
        <div class="notif-wrap">
          <button class="tb-pill">
            <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
          </button>
          <div class="notif-dot"></div>
        </div>
        <div class="avatar" style="cursor:pointer;font-size:11px">SA</div>
      </div>
    </header>