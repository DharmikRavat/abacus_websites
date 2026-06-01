
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FuelERP Pro — Multi Petrol Pump Management System</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<style>
/* ===== CSS VARIABLES & RESET ===== */
:root {
  --primary: #1a2b4a;
  --primary-light: #243660;
  --primary-dark: #0f1a2e;
  --accent: #f97316;
  --accent-light: #fb923c;
  --accent-dark: #ea580c;
  --white: #ffffff;
  --bg: #f0f4f8;
  --bg2: #e8eef5;
  --card: #ffffff;
  --border: #d1dce8;
  --text: #1a2b4a;
  --text2: #4a6080;
  --text3: #8a9bb0;
  --success: #10b981;
  --warning: #f59e0b;
  --danger: #ef4444;
  --info: #3b82f6;
  --sidebar-w: 260px;
  --topbar-h: 64px;
  --radius: 12px;
  --shadow: 0 2px 12px rgba(26,43,74,0.08);
  --shadow-lg: 0 8px 32px rgba(26,43,74,0.14);
  --transition: all 0.22s cubic-bezier(0.4,0,0.2,1);
}
[data-theme="dark"] {
  --primary: #1e3a5f;
  --primary-light: #2a4f82;
  --primary-dark: #0f2040;
  --bg: #0f172a;
  --bg2: #1e293b;
  --card: #1e293b;
  --border: #2d3f5a;
  --text: #e2e8f0;
  --text2: #94a3b8;
  --text3: #64748b;
  --shadow: 0 2px 12px rgba(0,0,0,0.3);
  --shadow-lg: 0 8px 32px rgba(0,0,0,0.4);
}
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:'Segoe UI',system-ui,sans-serif;background:var(--bg);color:var(--text);transition:var(--transition);overflow-x:hidden;}
a{text-decoration:none;color:inherit;}
button{cursor:pointer;font-family:inherit;}
input,select,textarea{font-family:inherit;}

/* ===== LOADING SCREEN ===== */
#loading-screen{position:fixed;inset:0;background:var(--primary-dark);display:flex;flex-direction:column;align-items:center;justify-content:center;z-index:9999;transition:opacity 0.6s ease;}
#loading-screen.hide{opacity:0;pointer-events:none;}
.loader-logo{font-size:2.4rem;font-weight:800;color:var(--white);letter-spacing:-1px;margin-bottom:8px;}
.loader-logo span{color:var(--accent);}
.loader-sub{color:rgba(255,255,255,0.5);font-size:0.85rem;margin-bottom:40px;letter-spacing:2px;text-transform:uppercase;}
.loader-bar{width:240px;height:3px;background:rgba(255,255,255,0.1);border-radius:99px;overflow:hidden;}
.loader-fill{height:100%;background:var(--accent);border-radius:99px;animation:loadFill 1.8s ease forwards;}
@keyframes loadFill{0%{width:0}100%{width:100%}}

/* ===== LAYOUT ===== */
#sidebar{position:fixed;left:0;top:0;width:var(--sidebar-w);height:100vh;background:var(--primary);z-index:100;display:flex;flex-direction:column;transition:var(--transition);overflow-y:auto;overflow-x:hidden;}
#sidebar.collapsed{width:72px;}
#topbar{position:fixed;left:var(--sidebar-w);top:0;right:0;height:var(--topbar-h);background:var(--card);border-bottom:1px solid var(--border);display:flex;align-items:center;padding:0 24px;gap:16px;z-index:99;transition:var(--transition);box-shadow:var(--shadow);}
#topbar.expanded{left:72px;}
#main{margin-left:var(--sidebar-w);margin-top:var(--topbar-h);padding:24px;transition:var(--transition);min-height:calc(100vh - var(--topbar-h));}
#main.expanded{margin-left:72px;}

/* ===== SIDEBAR STYLES ===== */
.sidebar-logo{padding:20px 20px 16px;border-bottom:1px solid rgba(255,255,255,0.08);display:flex;align-items:center;gap:12px;min-height:64px;}
.sidebar-logo-icon{width:40px;height:40px;background:var(--accent);border-radius:10px;display:flex;align-items:center;justify-content:center;color:white;font-size:1.1rem;flex-shrink:0;}
.sidebar-logo-text{overflow:hidden;white-space:nowrap;}
.sidebar-logo-text h2{color:white;font-size:1.1rem;font-weight:700;line-height:1.2;}
.sidebar-logo-text span{color:rgba(255,255,255,0.45);font-size:0.7rem;text-transform:uppercase;letter-spacing:1.5px;}
.branch-selector{margin:12px;background:rgba(255,255,255,0.07);border-radius:8px;padding:10px 12px;cursor:pointer;transition:var(--transition);position:relative;}
.branch-selector:hover{background:rgba(255,255,255,0.12);}
.branch-selector select{background:transparent;border:none;color:white;width:100%;font-size:0.8rem;cursor:pointer;outline:none;}
.branch-selector select option{background:var(--primary);color:white;}
.sidebar-section{padding:8px 12px 4px;font-size:0.65rem;color:rgba(255,255,255,0.3);text-transform:uppercase;letter-spacing:1.5px;font-weight:600;overflow:hidden;white-space:nowrap;}
.nav-item{display:flex;align-items:center;gap:12px;padding:10px 20px;color:rgba(255,255,255,0.65);cursor:pointer;transition:var(--transition);position:relative;border-radius:0;margin:1px 8px;border-radius:8px;white-space:nowrap;overflow:hidden;}
.nav-item:hover{background:rgba(255,255,255,0.08);color:white;}
.nav-item.active{background:var(--accent);color:white;}
.nav-item .nav-icon{width:20px;text-align:center;font-size:1rem;flex-shrink:0;}
.nav-item .nav-label{font-size:0.875rem;font-weight:500;overflow:hidden;}
.nav-item .nav-badge{margin-left:auto;background:rgba(255,255,255,0.2);color:white;font-size:0.65rem;padding:2px 7px;border-radius:99px;font-weight:600;flex-shrink:0;}
.nav-item.active .nav-badge{background:rgba(255,255,255,0.3);}
#sidebar.collapsed .nav-label,#sidebar.collapsed .nav-badge,#sidebar.collapsed .sidebar-section,#sidebar.collapsed .sidebar-logo-text,#sidebar.collapsed .branch-selector{display:none;}
#sidebar.collapsed .nav-item{justify-content:center;padding:10px;}
#sidebar.collapsed .sidebar-logo{justify-content:center;padding:12px 0;}

/* ===== TOPBAR ===== */
.topbar-toggle{background:none;border:none;color:var(--text2);font-size:1.1rem;padding:8px;border-radius:8px;transition:var(--transition);}
.topbar-toggle:hover{background:var(--bg2);color:var(--text);}
.topbar-search{flex:1;max-width:320px;position:relative;}
.topbar-search input{width:100%;padding:8px 12px 8px 36px;background:var(--bg2);border:1px solid var(--border);border-radius:8px;color:var(--text);font-size:0.875rem;transition:var(--transition);}
.topbar-search input:focus{outline:none;border-color:var(--accent);background:var(--card);}
.topbar-search i{position:absolute;left:11px;top:50%;transform:translateY(-50%);color:var(--text3);font-size:0.85rem;}
.ticker-wrap{flex:1;overflow:hidden;font-size:0.75rem;color:var(--text2);}
.ticker-inner{display:flex;gap:32px;animation:ticker 25s linear infinite;white-space:nowrap;}
@keyframes ticker{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}
.ticker-item{display:flex;align-items:center;gap:6px;}
.ticker-item .up{color:var(--success);}
.ticker-item .down{color:var(--danger);}
.topbar-actions{display:flex;align-items:center;gap:8px;margin-left:auto;}
.topbar-btn{width:38px;height:38px;border:none;background:var(--bg2);border-radius:8px;color:var(--text2);font-size:0.95rem;transition:var(--transition);position:relative;}
.topbar-btn:hover{background:var(--border);color:var(--text);}
.notif-dot{position:absolute;top:6px;right:6px;width:8px;height:8px;background:var(--danger);border-radius:50%;border:2px solid var(--card);}
.user-avatar{width:38px;height:38px;border-radius:8px;background:var(--accent);color:white;border:none;font-size:0.8rem;font-weight:700;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:var(--transition);}
.user-avatar:hover{opacity:0.85;}
.clock-widget{font-size:0.8rem;color:var(--text2);font-weight:500;white-space:nowrap;}

/* ===== DROPDOWN MENUS ===== */
.dropdown{position:relative;}
.dropdown-menu{position:absolute;right:0;top:calc(100% + 8px);background:var(--card);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow-lg);min-width:280px;z-index:200;display:none;animation:fadeDown 0.18s ease;}
.dropdown-menu.show{display:block;}
@keyframes fadeDown{from{opacity:0;transform:translateY(-8px)}to{opacity:1;transform:translateY(0)}}
.dropdown-header{padding:14px 16px 10px;border-bottom:1px solid var(--border);font-size:0.8rem;font-weight:600;color:var(--text3);text-transform:uppercase;letter-spacing:0.5px;}
.notif-item{padding:12px 16px;display:flex;gap:12px;cursor:pointer;transition:var(--transition);border-bottom:1px solid var(--border);}
.notif-item:hover{background:var(--bg2);}
.notif-icon{width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:0.9rem;flex-shrink:0;}
.notif-content p{font-size:0.825rem;font-weight:500;line-height:1.4;}
.notif-content span{font-size:0.75rem;color:var(--text3);}
.user-menu-item{padding:10px 16px;display:flex;align-items:center;gap:10px;cursor:pointer;transition:var(--transition);font-size:0.875rem;}
.user-menu-item:hover{background:var(--bg2);}
.user-menu-item i{width:16px;color:var(--text3);}

/* ===== PAGE SECTIONS ===== */
.page{display:none;}
.page.active{display:block;animation:pageIn 0.3s ease;}
@keyframes pageIn{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
.page-header{margin-bottom:24px;}
.page-title{font-size:1.5rem;font-weight:700;color:var(--text);}
.page-subtitle{color:var(--text2);font-size:0.875rem;margin-top:2px;}
.breadcrumb{display:flex;align-items:center;gap:6px;font-size:0.78rem;color:var(--text3);margin-bottom:6px;}
.breadcrumb span{color:var(--accent);}

/* ===== CARDS ===== */
.card{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:20px;box-shadow:var(--shadow);}
.card-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;}
.card-title{font-size:0.95rem;font-weight:600;color:var(--text);}
.card-subtitle{font-size:0.78rem;color:var(--text3);margin-top:2px;}

/* ===== STAT CARDS ===== */
.stats-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:16px;margin-bottom:24px;}
.stat-card{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:20px;position:relative;overflow:hidden;transition:var(--transition);cursor:default;}
.stat-card:hover{transform:translateY(-2px);box-shadow:var(--shadow-lg);}
.stat-card::after{content:'';position:absolute;top:0;right:0;width:80px;height:80px;border-radius:50%;opacity:0.06;transform:translate(20px,-20px);}
.stat-card.blue::after{background:#3b82f6;}
.stat-card.orange::after{background:var(--accent);}
.stat-card.green::after{background:var(--success);}
.stat-card.red::after{background:var(--danger);}
.stat-card.purple::after{background:#8b5cf6;}
.stat-icon{width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;margin-bottom:14px;}
.stat-icon.blue{background:#eff6ff;color:#3b82f6;}
.stat-icon.orange{background:#fff7ed;color:var(--accent);}
.stat-icon.green{background:#f0fdf4;color:var(--success);}
.stat-icon.red{background:#fef2f2;color:var(--danger);}
.stat-icon.purple{background:#f5f3ff;color:#8b5cf6;}
[data-theme="dark"] .stat-icon.blue{background:rgba(59,130,246,0.15);}
[data-theme="dark"] .stat-icon.orange{background:rgba(249,115,22,0.15);}
[data-theme="dark"] .stat-icon.green{background:rgba(16,185,129,0.15);}
[data-theme="dark"] .stat-icon.red{background:rgba(239,68,68,0.15);}
[data-theme="dark"] .stat-icon.purple{background:rgba(139,92,246,0.15);}
.stat-value{font-size:1.6rem;font-weight:700;line-height:1;margin-bottom:4px;}
.stat-label{font-size:0.78rem;color:var(--text3);font-weight:500;}
.stat-change{font-size:0.75rem;margin-top:8px;display:flex;align-items:center;gap:4px;font-weight:500;}
.stat-change.up{color:var(--success);}
.stat-change.down{color:var(--danger);}

/* ===== GRID LAYOUTS ===== */
.grid-2{display:grid;grid-template-columns:1fr 1fr;gap:20px;}
.grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px;}
.grid-7-5{display:grid;grid-template-columns:7fr 5fr;gap:20px;}
.grid-5-7{display:grid;grid-template-columns:5fr 7fr;gap:20px;}
@media(max-width:1100px){.grid-2,.grid-3,.grid-7-5,.grid-5-7{grid-template-columns:1fr;}}

/* ===== TABLES ===== */
.table-wrap{overflow-x:auto;}
table{width:100%;border-collapse:collapse;font-size:0.875rem;}
th{padding:10px 14px;text-align:left;font-size:0.75rem;font-weight:600;color:var(--text3);text-transform:uppercase;letter-spacing:0.5px;background:var(--bg2);border-bottom:1px solid var(--border);}
td{padding:12px 14px;border-bottom:1px solid var(--border);color:var(--text);vertical-align:middle;}
tr:hover td{background:var(--bg2);}
tr:last-child td{border-bottom:none;}

/* ===== BADGES ===== */
.badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:99px;font-size:0.7rem;font-weight:600;}
.badge-success{background:#d1fae5;color:#065f46;}
.badge-warning{background:#fef3c7;color:#92400e;}
.badge-danger{background:#fee2e2;color:#991b1b;}
.badge-info{background:#dbeafe;color:#1e40af;}
.badge-gray{background:#f1f5f9;color:#475569;}
[data-theme="dark"] .badge-success{background:rgba(16,185,129,0.2);color:#6ee7b7;}
[data-theme="dark"] .badge-warning{background:rgba(245,158,11,0.2);color:#fcd34d;}
[data-theme="dark"] .badge-danger{background:rgba(239,68,68,0.2);color:#fca5a5;}
[data-theme="dark"] .badge-info{background:rgba(59,130,246,0.2);color:#93c5fd;}
[data-theme="dark"] .badge-gray{background:rgba(148,163,184,0.1);color:#94a3b8;}

/* ===== BUTTONS ===== */
.btn{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:8px;border:none;font-size:0.85rem;font-weight:600;transition:var(--transition);cursor:pointer;}
.btn-primary{background:var(--accent);color:white;}
.btn-primary:hover{background:var(--accent-dark);}
.btn-outline{background:transparent;color:var(--text2);border:1px solid var(--border);}
.btn-outline:hover{background:var(--bg2);color:var(--text);}
.btn-success{background:var(--success);color:white;}
.btn-success:hover{filter:brightness(0.9);}
.btn-danger{background:var(--danger);color:white;}
.btn-danger:hover{filter:brightness(0.9);}
.btn-sm{padding:6px 12px;font-size:0.78rem;}
.btn-icon{width:34px;height:34px;padding:0;justify-content:center;border-radius:7px;}

/* ===== PROGRESS BARS ===== */
.progress-bar{height:8px;background:var(--bg2);border-radius:99px;overflow:hidden;}
.progress-fill{height:100%;border-radius:99px;transition:width 1s cubic-bezier(0.4,0,0.2,1);}

/* ===== TANK VISUALIZATION ===== */
.tank-viz{display:flex;flex-direction:column;align-items:center;gap:8px;}
.tank-body{width:60px;height:100px;border:3px solid var(--border);border-radius:6px 6px 10px 10px;position:relative;overflow:hidden;background:var(--bg2);}
.tank-fill{position:absolute;bottom:0;left:0;right:0;border-radius:3px 3px 7px 7px;transition:height 1.2s cubic-bezier(0.4,0,0.2,1);}
.tank-label{font-size:0.72rem;font-weight:600;color:var(--text2);text-align:center;}
.tank-pct{font-size:0.85rem;font-weight:700;color:var(--text);}

/* ===== MODAL ===== */
.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:300;display:none;align-items:center;justify-content:center;padding:20px;backdrop-filter:blur(4px);}
.modal-overlay.show{display:flex;animation:fadeIn 0.2s ease;}
@keyframes fadeIn{from{opacity:0}to{opacity:1}}
.modal{background:var(--card);border-radius:16px;width:100%;max-width:560px;max-height:90vh;overflow-y:auto;box-shadow:var(--shadow-lg);animation:modalIn 0.25s cubic-bezier(0.34,1.56,0.64,1);}
@keyframes modalIn{from{opacity:0;transform:scale(0.92)}to{opacity:1;transform:scale(1)}}
.modal-header{padding:20px 24px 16px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
.modal-title{font-size:1.05rem;font-weight:700;}
.modal-close{background:none;border:none;color:var(--text3);font-size:1.2rem;cursor:pointer;padding:4px;border-radius:6px;transition:var(--transition);}
.modal-close:hover{background:var(--bg2);color:var(--text);}
.modal-body{padding:20px 24px;}
.modal-footer{padding:16px 24px;border-top:1px solid var(--border);display:flex;justify-content:flex-end;gap:10px;}

/* ===== FORM ELEMENTS ===== */
.form-group{margin-bottom:16px;}
.form-label{display:block;font-size:0.82rem;font-weight:600;color:var(--text2);margin-bottom:6px;}
.form-control{width:100%;padding:9px 12px;background:var(--bg2);border:1px solid var(--border);border-radius:8px;color:var(--text);font-size:0.875rem;transition:var(--transition);}
.form-control:focus{outline:none;border-color:var(--accent);background:var(--card);}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:12px;}

/* ===== ACTIVITY TIMELINE ===== */
.timeline{display:flex;flex-direction:column;gap:0;}
.timeline-item{display:flex;gap:12px;padding:10px 0;position:relative;}
.timeline-item::before{content:'';position:absolute;left:15px;top:36px;bottom:-10px;width:1px;background:var(--border);}
.timeline-item:last-child::before{display:none;}
.timeline-dot{width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.75rem;flex-shrink:0;margin-top:2px;}
.timeline-content p{font-size:0.85rem;font-weight:500;}
.timeline-content span{font-size:0.75rem;color:var(--text3);}

/* ===== EMPLOYEE CARDS ===== */
.emp-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:16px;}
.emp-card{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:20px;text-align:center;transition:var(--transition);}
.emp-card:hover{transform:translateY(-2px);box-shadow:var(--shadow-lg);}
.emp-avatar{width:64px;height:64px;border-radius:50%;margin:0 auto 12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;font-weight:700;color:white;}
.emp-name{font-size:0.925rem;font-weight:600;margin-bottom:2px;}
.emp-role{font-size:0.78rem;color:var(--text3);margin-bottom:10px;}
.emp-stats{display:flex;gap:8px;justify-content:center;flex-wrap:wrap;}

/* ===== FUEL RATE WIDGET ===== */
.rate-cards{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;}
.rate-card{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:16px;text-align:center;position:relative;overflow:hidden;}
.rate-card::before{content:'';position:absolute;top:-20px;right:-20px;width:80px;height:80px;border-radius:50%;opacity:0.05;}
.rate-card.petrol::before{background:var(--accent);}
.rate-card.diesel::before{background:#3b82f6;}
.rate-card.cng::before{background:var(--success);}
.rate-card-icon{font-size:1.5rem;margin-bottom:8px;}
.rate-card-fuel{font-size:0.75rem;color:var(--text3);font-weight:600;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px;}
.rate-card-price{font-size:1.6rem;font-weight:800;color:var(--text);}
.rate-card-unit{font-size:0.7rem;color:var(--text3);}
.rate-card-change{font-size:0.75rem;margin-top:6px;font-weight:600;}

/* ===== INVOICE ===== */
.invoice-box{background:white;border:1px solid #e2e8f0;border-radius:12px;padding:24px;max-width:500px;margin:0 auto;color:#1a2b4a;}
.invoice-header{display:flex;justify-content:space-between;align-items:start;margin-bottom:20px;padding-bottom:16px;border-bottom:2px solid var(--accent);}
.invoice-table{width:100%;margin:16px 0;border-collapse:collapse;}
.invoice-table th{background:#f8fafc;padding:8px 12px;font-size:0.78rem;text-align:left;border-bottom:1px solid #e2e8f0;}
.invoice-table td{padding:8px 12px;font-size:0.85rem;border-bottom:1px solid #f1f5f9;}
.invoice-total{background:#fff7ed;border-radius:8px;padding:12px 16px;margin-top:12px;}

/* ===== NOTIFICATIONS PANEL ===== */
.notif-panel{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
.notif-panel-item{padding:12px 16px;display:flex;align-items:start;gap:12px;border-bottom:1px solid var(--border);transition:var(--transition);}
.notif-panel-item:hover{background:var(--bg2);}
.notif-panel-item:last-child{border-bottom:none;}
.notif-panel-icon{width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:0.85rem;flex-shrink:0;}
.notif-panel-content p{font-size:0.83rem;font-weight:500;line-height:1.4;}
.notif-panel-content .time{font-size:0.72rem;color:var(--text3);margin-top:2px;}

/* ===== AI ANALYTICS CARD ===== */
.ai-card{background:linear-gradient(135deg,var(--primary) 0%,#1a3a6e 100%);border-radius:var(--radius);padding:20px;color:white;position:relative;overflow:hidden;}
.ai-card::after{content:'';position:absolute;top:-30px;right:-30px;width:120px;height:120px;background:rgba(249,115,22,0.15);border-radius:50%;}
.ai-tag{display:inline-flex;align-items:center;gap:6px;background:rgba(249,115,22,0.2);color:var(--accent-light);font-size:0.72rem;font-weight:600;padding:4px 10px;border-radius:99px;margin-bottom:10px;}
.ai-card h3{font-size:1rem;margin-bottom:6px;}
.ai-card p{font-size:0.82rem;opacity:0.7;line-height:1.6;}
.ai-insights{margin-top:14px;display:flex;flex-direction:column;gap:8px;}
.ai-insight{background:rgba(255,255,255,0.07);border-radius:8px;padding:8px 12px;font-size:0.8rem;display:flex;align-items:center;gap:8px;}
.ai-insight i{color:var(--accent-light);}

/* ===== SETTINGS ===== */
.settings-section{margin-bottom:28px;}
.settings-section-title{font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--text3);margin-bottom:14px;padding-bottom:8px;border-bottom:1px solid var(--border);}
.toggle-switch{position:relative;width:42px;height:22px;}
.toggle-switch input{display:none;}
.toggle-slider{position:absolute;inset:0;background:var(--border);border-radius:99px;cursor:pointer;transition:var(--transition);}
.toggle-slider::before{content:'';position:absolute;width:16px;height:16px;background:white;border-radius:50%;top:3px;left:3px;transition:var(--transition);}
.toggle-switch input:checked + .toggle-slider{background:var(--accent);}
.toggle-switch input:checked + .toggle-slider::before{transform:translateX(20px);}
.settings-row{display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-bottom:1px solid var(--border);}
.settings-row:last-child{border-bottom:none;}
.settings-row-info p{font-size:0.875rem;font-weight:500;}
.settings-row-info span{font-size:0.78rem;color:var(--text3);}

/* ===== SCROLLBAR ===== */
::-webkit-scrollbar{width:5px;height:5px;}
::-webkit-scrollbar-track{background:transparent;}
::-webkit-scrollbar-thumb{background:var(--border);border-radius:99px;}
::-webkit-scrollbar-thumb:hover{background:var(--text3);}

/* ===== MOBILE ===== */
@media(max-width:768px){
  :root{--sidebar-w:0px;}
  #sidebar{transform:translateX(-100%);width:260px;}
  #sidebar.mobile-open{transform:translateX(0);}
  #topbar{left:0!important;}
  #main{margin-left:0!important;}
  .stats-grid{grid-template-columns:repeat(2,1fr);}
  .rate-cards{grid-template-columns:1fr;}
  .form-row{grid-template-columns:1fr;}
  .modal{border-radius:12px;}
}

/* ===== MISC ===== */
.section-gap{margin-bottom:20px;}
.flex-between{display:flex;align-items:center;justify-content:space-between;}
.flex-gap{display:flex;align-items:center;gap:8px;}
.text-muted{color:var(--text3);}
.fw-600{font-weight:600;}
.mb-16{margin-bottom:16px;}
.chart-container{position:relative;width:100%;}
.overlay-mobile{display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);z-index:99;}
.overlay-mobile.show{display:block;}
</style>
</head>
<body>

<!-- LOADING SCREEN -->
<div id="loading-screen">
  <div class="loader-logo">⛽ Fuel<span>ERP</span></div>
  <div class="loader-sub">Multi Pump Management System</div>
  <div class="loader-bar"><div class="loader-fill"></div></div>
</div>

<div class="overlay-mobile" id="overlay-mobile" onclick="closeSidebar()"></div>

<!-- SIDEBAR -->
<nav id="sidebar">
  <div class="sidebar-logo">
    <div class="sidebar-logo-icon"><i class="fa-solid fa-gas-pump"></i></div>
    <div class="sidebar-logo-text">
      <h2>FuelERP Pro</h2>
      <span>Management Suite</span>
    </div>
  </div>
  <div style="padding:8px 12px;">
    <select class="form-control" style="background:rgba(255,255,255,0.07);border-color:rgba(255,255,255,0.1);color:white;font-size:0.82rem;" onchange="showToast('Branch changed: '+this.options[this.selectedIndex].text,'info')">
      <option>🏢 All Branches</option>
      <option>Pune — Station 1</option>
      <option>Mumbai — Station 2</option>
      <option>Nashik — Station 3</option>
    </select>
  </div>
  <div class="sidebar-section">Main Menu</div>
  <div class="nav-item active" onclick="showPage('dashboard',this)"><div class="nav-icon"><i class="fa-solid fa-gauge-high"></i></div><div class="nav-label">Dashboard</div></div>
  <div class="nav-item" onclick="showPage('pumps',this)"><div class="nav-icon"><i class="fa-solid fa-gas-pump"></i></div><div class="nav-label">Pump Management</div><span class="nav-badge">6</span></div>
  <div class="nav-item" onclick="showPage('inventory',this)"><div class="nav-icon"><i class="fa-solid fa-barrel"></i></div><div class="nav-label">Fuel Inventory</div></div>
  <div class="nav-item" onclick="showPage('employees',this)"><div class="nav-icon"><i class="fa-solid fa-users"></i></div><div class="nav-label">Employees</div><span class="nav-badge">12</span></div>
  <div class="sidebar-section">Finance</div>
  <div class="nav-item" onclick="showPage('billing',this)"><div class="nav-icon"><i class="fa-solid fa-file-invoice-dollar"></i></div><div class="nav-label">Sales & Billing</div></div>
  <div class="nav-item" onclick="showPage('expenses',this)"><div class="nav-icon"><i class="fa-solid fa-wallet"></i></div><div class="nav-label">Expenses</div></div>
  <div class="nav-item" onclick="showPage('reports',this)"><div class="nav-icon"><i class="fa-solid fa-chart-bar"></i></div><div class="nav-label">Reports</div></div>
  <div class="sidebar-section">System</div>
  <div class="nav-item" onclick="showPage('settings',this)"><div class="nav-icon"><i class="fa-solid fa-gear"></i></div><div class="nav-label">Settings</div></div>
  <div style="margin-top:auto;padding:12px;">
    <div style="background:rgba(249,115,22,0.12);border-radius:10px;padding:14px;border:1px solid rgba(249,115,22,0.2);">
      <p style="font-size:0.78rem;color:rgba(255,255,255,0.7);margin-bottom:6px;"><i class="fa-solid fa-circle-info" style="color:var(--accent);margin-right:5px;"></i>Demo Version</p>
      <p style="font-size:0.72rem;color:rgba(255,255,255,0.4);">All data is simulated for demonstration purposes.</p>
    </div>
  </div>
</nav>

<!-- TOPBAR -->
<header id="topbar">
  <button class="topbar-toggle" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
  <div class="topbar-search">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="text" placeholder="Search pumps, employees, transactions...">
  </div>
  <div class="ticker-wrap" id="ticker-wrap">
    <div class="ticker-inner" id="ticker"></div>
  </div>
  <div class="topbar-actions">
    <div class="clock-widget" id="clock-widget"></div>
    <button class="topbar-btn" onclick="toggleTheme()" title="Toggle Theme" id="theme-btn"><i class="fa-solid fa-moon"></i></button>
    <div class="dropdown">
      <button class="topbar-btn" onclick="toggleDropdown('notif-drop')"><i class="fa-solid fa-bell"></i><span class="notif-dot"></span></button>
      <div class="dropdown-menu" id="notif-drop">
        <div class="dropdown-header">Notifications (3 new)</div>
        <div class="notif-item"><div class="notif-icon" style="background:#fef3c7;color:#d97706;"><i class="fa-solid fa-triangle-exclamation"></i></div><div class="notif-content"><p>Diesel low stock at Pump #3</p><span>2 mins ago</span></div></div>
        <div class="notif-item"><div class="notif-icon" style="background:#d1fae5;color:#059669;"><i class="fa-solid fa-circle-check"></i></div><div class="notif-content"><p>Tank refill completed — Petrol</p><span>18 mins ago</span></div></div>
        <div class="notif-item"><div class="notif-icon" style="background:#dbeafe;color:#2563eb;"><i class="fa-solid fa-user-plus"></i></div><div class="notif-content"><p>New employee Arjun added</p><span>1 hr ago</span></div></div>
        <div style="padding:10px 16px;text-align:center;"><button class="btn btn-outline btn-sm" style="width:100%;">View All</button></div>
      </div>
    </div>
    <div class="dropdown">
      <div class="user-avatar" onclick="toggleDropdown('user-drop')">AM</div>
      <div class="dropdown-menu" id="user-drop" style="min-width:200px;">
        <div style="padding:14px 16px;border-bottom:1px solid var(--border);">
          <p style="font-weight:600;font-size:0.9rem;">Amit Mehta</p>
          <p style="font-size:0.78rem;color:var(--text3);">Super Admin</p>
        </div>
        <div class="user-menu-item"><i class="fa-solid fa-user"></i>My Profile</div>
        <div class="user-menu-item"><i class="fa-solid fa-gear"></i>Settings</div>
        <div class="user-menu-item" style="color:var(--danger);"><i class="fa-solid fa-right-from-bracket" style="color:var(--danger);"></i>Sign Out</div>
      </div>
    </div>
  </div>
</header>

<!-- MAIN CONTENT -->
<main id="main">

<!-- ===== DASHBOARD PAGE ===== -->
<div id="page-dashboard" class="page active">
  <div class="breadcrumb"><span>Home</span> / Dashboard</div>
  <div class="flex-between mb-16">
    <div class="page-header" style="margin:0;">
      <div class="page-title">Dashboard Overview</div>
      <div class="page-subtitle">Today — <span id="today-date"></span></div>
    </div>
    <div class="flex-gap">
      <button class="btn btn-outline btn-sm"><i class="fa-solid fa-calendar"></i> This Month</button>
      <button class="btn btn-primary btn-sm" onclick="showToast('Report generated!','success')"><i class="fa-solid fa-file-export"></i> Export</button>
    </div>
  </div>

  <!-- Today's Rates -->
  <div class="rate-cards section-gap">
    <div class="rate-card petrol">
      <div class="rate-card-icon">⛽</div>
      <div class="rate-card-fuel">Petrol</div>
      <div class="rate-card-price" id="rate-petrol">₹103.50</div>
      <div class="rate-card-unit">per litre</div>
      <div class="rate-card-change" style="color:var(--danger);"><i class="fa-solid fa-arrow-down"></i> -₹0.30 today</div>
    </div>
    <div class="rate-card diesel">
      <div class="rate-card-icon">🛢️</div>
      <div class="rate-card-fuel">Diesel</div>
      <div class="rate-card-price" id="rate-diesel">₹89.75</div>
      <div class="rate-card-unit">per litre</div>
      <div class="rate-card-change" style="color:var(--success);"><i class="fa-solid fa-arrow-up"></i> +₹0.15 today</div>
    </div>
    <div class="rate-card cng">
      <div class="rate-card-icon">💨</div>
      <div class="rate-card-fuel">CNG</div>
      <div class="rate-card-price" id="rate-cng">₹78.00</div>
      <div class="rate-card-unit">per kg</div>
      <div class="rate-card-change" style="color:var(--text3);"><i class="fa-solid fa-minus"></i> No change</div>
    </div>
  </div>

  <!-- Stat Cards -->
  <div class="stats-grid">
    <div class="stat-card blue">
      <div class="stat-icon blue"><i class="fa-solid fa-gas-pump"></i></div>
      <div class="stat-value">6</div>
      <div class="stat-label">Total Petrol Pumps</div>
      <div class="stat-change up"><i class="fa-solid fa-arrow-trend-up"></i> +1 this month</div>
    </div>
    <div class="stat-card orange">
      <div class="stat-icon orange"><i class="fa-solid fa-indian-rupee-sign"></i></div>
      <div class="stat-value">₹4.82L</div>
      <div class="stat-label">Daily Revenue</div>
      <div class="stat-change up"><i class="fa-solid fa-arrow-trend-up"></i> +12.4% vs yesterday</div>
    </div>
    <div class="stat-card green">
      <div class="stat-icon green"><i class="fa-solid fa-chart-line"></i></div>
      <div class="stat-value">₹1.4Cr</div>
      <div class="stat-label">Total Fuel Sales (Month)</div>
      <div class="stat-change up"><i class="fa-solid fa-arrow-trend-up"></i> +8.2% vs last month</div>
    </div>
    <div class="stat-card purple">
      <div class="stat-icon purple"><i class="fa-solid fa-users"></i></div>
      <div class="stat-value">42</div>
      <div class="stat-label">Active Employees</div>
      <div class="stat-change up"><i class="fa-solid fa-arrow-trend-up"></i> 38 on shift today</div>
    </div>
    <div class="stat-card red">
      <div class="stat-icon red"><i class="fa-solid fa-clock"></i></div>
      <div class="stat-value">₹2.3L</div>
      <div class="stat-label">Pending Payments</div>
      <div class="stat-change down"><i class="fa-solid fa-triangle-exclamation"></i> 7 invoices due</div>
    </div>
    <div class="stat-card blue">
      <div class="stat-icon blue"><i class="fa-solid fa-barrel"></i></div>
      <div class="stat-value">68%</div>
      <div class="stat-label">Avg. Stock Level</div>
      <div class="stat-change down"><i class="fa-solid fa-arrow-trend-down"></i> Diesel critically low</div>
    </div>
  </div>

  <!-- Charts Row -->
  <div class="grid-7-5 section-gap">
    <div class="card">
      <div class="card-header">
        <div><div class="card-title">Sales Analytics</div><div class="card-subtitle">Monthly fuel sales by type</div></div>
        <select class="form-control" style="width:auto;font-size:0.78rem;padding:5px 10px;">
          <option>Last 6 Months</option><option>Last Year</option>
        </select>
      </div>
      <div class="chart-container" style="height:240px;"><canvas id="salesChart" role="img" aria-label="Monthly fuel sales bar chart">Monthly fuel sales data.</canvas></div>
    </div>
    <div class="card">
      <div class="card-header">
        <div><div class="card-title">Revenue Split</div><div class="card-subtitle">By fuel type this month</div></div>
      </div>
      <div class="chart-container" style="height:200px;"><canvas id="pieChart" role="img" aria-label="Revenue split pie chart">Revenue split by fuel type.</canvas></div>
      <div style="display:flex;gap:12px;justify-content:center;margin-top:10px;flex-wrap:wrap;">
        <span style="display:flex;align-items:center;gap:4px;font-size:0.75rem;color:var(--text2);"><span style="width:10px;height:10px;background:#f97316;border-radius:2px;display:inline-block;"></span>Petrol 54%</span>
        <span style="display:flex;align-items:center;gap:4px;font-size:0.75rem;color:var(--text2);"><span style="width:10px;height:10px;background:#3b82f6;border-radius:2px;display:inline-block;"></span>Diesel 33%</span>
        <span style="display:flex;align-items:center;gap:4px;font-size:0.75rem;color:var(--text2);"><span style="width:10px;height:10px;background:#10b981;border-radius:2px;display:inline-block;"></span>CNG 13%</span>
      </div>
    </div>
  </div>

  <!-- Tank Levels + AI Card + Activity -->
  <div class="grid-2 section-gap">
    <div class="card">
      <div class="card-header">
        <div><div class="card-title"><i class="fa-solid fa-barrel" style="color:var(--accent);margin-right:6px;"></i>Tank Levels</div></div>
        <button class="btn btn-outline btn-sm" onclick="showToast('Refill order placed!','success')"><i class="fa-solid fa-plus"></i> Order Refill</button>
      </div>
      <div style="display:flex;gap:16px;flex-wrap:wrap;justify-content:space-around;">
        <div class="tank-viz">
          <div class="tank-body"><div class="tank-fill" id="tank-petrol" style="height:72%;background:linear-gradient(180deg,#fb923c,#f97316);"></div></div>
          <div class="tank-pct">72%</div><div class="tank-label">Petrol<br>36,000 L</div>
        </div>
        <div class="tank-viz">
          <div class="tank-body"><div class="tank-fill" id="tank-diesel" style="height:23%;background:linear-gradient(180deg,#60a5fa,#3b82f6);"></div></div>
          <div class="tank-pct" style="color:var(--danger);">23%</div><div class="tank-label">Diesel<br>11,500 L</div>
        </div>
        <div class="tank-viz">
          <div class="tank-body"><div class="tank-fill" id="tank-cng" style="height:55%;background:linear-gradient(180deg,#34d399,#10b981);"></div></div>
          <div class="tank-pct">55%</div><div class="tank-label">CNG<br>2,750 kg</div>
        </div>
        <div class="tank-viz">
          <div class="tank-body"><div class="tank-fill" id="tank-premium" style="height:88%;background:linear-gradient(180deg,#a78bfa,#8b5cf6);"></div></div>
          <div class="tank-pct">88%</div><div class="tank-label">Premium<br>44,000 L</div>
        </div>
      </div>
      <div style="margin-top:16px;background:#fef2f2;border-radius:8px;padding:10px 14px;display:flex;align-items:center;gap:8px;">
        <i class="fa-solid fa-triangle-exclamation" style="color:var(--danger);"></i>
        <span style="font-size:0.82rem;color:var(--danger);font-weight:500;">Diesel critically low — refill recommended within 24 hours</span>
      </div>
    </div>
    <div style="display:flex;flex-direction:column;gap:16px;">
      <div class="ai-card">
        <div class="ai-tag"><i class="fa-solid fa-robot"></i> AI Analytics</div>
        <h3>Intelligent Insights</h3>
        <p>Based on consumption patterns and weather data</p>
        <div class="ai-insights">
          <div class="ai-insight"><i class="fa-solid fa-bolt"></i> Petrol demand +18% expected this weekend</div>
          <div class="ai-insight"><i class="fa-solid fa-triangle-exclamation"></i> Diesel stock will deplete in ~18 hrs at current rate</div>
          <div class="ai-insight"><i class="fa-solid fa-circle-check"></i> Revenue on track to exceed monthly target by 7%</div>
        </div>
      </div>
      <div class="card" style="flex:1;">
        <div class="card-header"><div class="card-title">Recent Activity</div></div>
        <div class="timeline">
          <div class="timeline-item"><div class="timeline-dot" style="background:#d1fae5;color:#059669;"><i class="fa-solid fa-check fa-xs"></i></div><div class="timeline-content"><p>₹3,450 payment received — Truck Fleet Co.</p><span>2 mins ago</span></div></div>
          <div class="timeline-item"><div class="timeline-dot" style="background:#fef3c7;color:#d97706;"><i class="fa-solid fa-bolt fa-xs"></i></div><div class="timeline-content"><p>Diesel tank refill triggered — Pump #3</p><span>18 mins ago</span></div></div>
          <div class="timeline-item"><div class="timeline-dot" style="background:#dbeafe;color:#2563eb;"><i class="fa-solid fa-user fa-xs"></i></div><div class="timeline-content"><p>Employee Ravi Kumar clocked in — Shift A</p><span>1 hr ago</span></div></div>
          <div class="timeline-item"><div class="timeline-dot" style="background:#f5f3ff;color:#7c3aed;"><i class="fa-solid fa-file fa-xs"></i></div><div class="timeline-content"><p>Monthly report generated and emailed</p><span>3 hrs ago</span></div></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Transactions -->
  <div class="card">
    <div class="card-header">
      <div><div class="card-title">Recent Transactions</div><div class="card-subtitle">Last 10 transactions across all pumps</div></div>
      <button class="btn btn-outline btn-sm" onclick="showPage('billing',document.querySelector('.nav-item:nth-child(6)'))"><i class="fa-solid fa-eye"></i> View All</button>
    </div>
    <div class="table-wrap">
      <table>
        <thead><tr><th>#ID</th><th>Pump</th><th>Fuel</th><th>Qty (L)</th><th>Amount</th><th>Payment</th><th>Time</th><th>Status</th></tr></thead>
        <tbody id="txn-table"></tbody>
      </table>
    </div>
  </div>
</div>

<!-- ===== PUMP MANAGEMENT PAGE ===== -->
<div id="page-pumps" class="page">
  <div class="breadcrumb"><span>Home</span> / Pump Management</div>
  <div class="flex-between mb-16">
    <div class="page-header" style="margin:0;"><div class="page-title">Pump Management</div><div class="page-subtitle">Manage all petrol pump stations</div></div>
    <button class="btn btn-primary" onclick="openModal('pump-modal')"><i class="fa-solid fa-plus"></i> Add Pump</button>
  </div>
  <div class="stats-grid" style="grid-template-columns:repeat(4,1fr);">
    <div class="stat-card blue"><div class="stat-icon blue"><i class="fa-solid fa-circle-check"></i></div><div class="stat-value">5</div><div class="stat-label">Active Pumps</div></div>
    <div class="stat-card red"><div class="stat-icon red"><i class="fa-solid fa-circle-xmark"></i></div><div class="stat-value">1</div><div class="stat-label">Under Maintenance</div></div>
    <div class="stat-card orange"><div class="stat-icon orange"><i class="fa-solid fa-location-dot"></i></div><div class="stat-value">3</div><div class="stat-label">Cities</div></div>
    <div class="stat-card green"><div class="stat-icon green"><i class="fa-solid fa-nozzle"></i></div><div class="stat-value">18</div><div class="stat-label">Total Nozzles</div></div>
  </div>
  <div class="card">
    <div class="card-header">
      <div class="card-title">All Petrol Pumps</div>
      <div class="flex-gap">
        <input type="text" class="form-control" placeholder="Search pumps..." style="width:200px;" oninput="filterTable(this.value,'pumps-table')">
        <select class="form-control" style="width:140px;" onchange="showToast('Filter applied','info')"><option>All Status</option><option>Active</option><option>Inactive</option><option>Maintenance</option></select>
      </div>
    </div>
    <div class="table-wrap">
      <table id="pumps-table">
        <thead><tr><th>#</th><th>Pump Name</th><th>Location</th><th>Owner</th><th>Contact</th><th>Fuel Types</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody id="pumps-tbody"></tbody>
      </table>
    </div>
  </div>
</div>

<!-- ===== INVENTORY PAGE ===== -->
<div id="page-inventory" class="page">
  <div class="breadcrumb"><span>Home</span> / Fuel Inventory</div>
  <div class="flex-between mb-16">
    <div class="page-header" style="margin:0;"><div class="page-title">Fuel Inventory</div><div class="page-subtitle">Monitor and manage fuel stock levels</div></div>
    <button class="btn btn-primary" onclick="openModal('price-modal')"><i class="fa-solid fa-tag"></i> Update Prices</button>
  </div>
  <div id="inventory-cards" class="grid-2 section-gap"></div>
  <div class="grid-2">
    <div class="card">
      <div class="card-header"><div class="card-title">Stock History (7 Days)</div></div>
      <div class="chart-container" style="height:220px;"><canvas id="stockChart" role="img" aria-label="Stock history line chart">Fuel stock history.</canvas></div>
    </div>
    <div class="card">
      <div class="card-header"><div class="card-title">Refill Alerts</div></div>
      <div id="refill-alerts"></div>
    </div>
  </div>
</div>

<!-- ===== EMPLOYEES PAGE ===== -->
<div id="page-employees" class="page">
  <div class="breadcrumb"><span>Home</span> / Employees</div>
  <div class="flex-between mb-16">
    <div class="page-header" style="margin:0;"><div class="page-title">Employee Management</div><div class="page-subtitle">Manage staff, shifts, and salaries</div></div>
    <button class="btn btn-primary" onclick="openModal('emp-modal')"><i class="fa-solid fa-user-plus"></i> Add Employee</button>
  </div>
  <div class="stats-grid" style="grid-template-columns:repeat(4,1fr);">
    <div class="stat-card green"><div class="stat-icon green"><i class="fa-solid fa-user-check"></i></div><div class="stat-value">38</div><div class="stat-label">Present Today</div></div>
    <div class="stat-card red"><div class="stat-icon red"><i class="fa-solid fa-user-xmark"></i></div><div class="stat-value">4</div><div class="stat-label">Absent Today</div></div>
    <div class="stat-card orange"><div class="stat-icon orange"><i class="fa-solid fa-indian-rupee-sign"></i></div><div class="stat-value">₹8.4L</div><div class="stat-label">Monthly Payroll</div></div>
    <div class="stat-card blue"><div class="stat-icon blue"><i class="fa-solid fa-briefcase"></i></div><div class="stat-value">3</div><div class="stat-label">Roles</div></div>
  </div>
  <div class="emp-grid" id="emp-cards"></div>
</div>

<!-- ===== BILLING PAGE ===== -->
<div id="page-billing" class="page">
  <div class="breadcrumb"><span>Home</span> / Sales & Billing</div>
  <div class="page-header"><div class="page-title">Sales & Billing</div><div class="page-subtitle">Generate bills and manage transactions</div></div>
  <div class="grid-5-7">
    <div class="card">
      <div class="card-header"><div class="card-title"><i class="fa-solid fa-calculator" style="color:var(--accent);margin-right:6px;"></i>Generate Bill</div></div>
      <div class="form-group"><div class="form-label">Select Pump</div><select class="form-control" id="bill-pump"><option>Pump #1 — Pune Main</option><option>Pump #2 — Kothrud</option><option>Pump #3 — Mumbai Highway</option></select></div>
      <div class="form-group"><div class="form-label">Fuel Type</div><select class="form-control" id="bill-fuel" onchange="updateBill()"><option value="103.50">Petrol — ₹103.50/L</option><option value="89.75">Diesel — ₹89.75/L</option><option value="78.00">CNG — ₹78.00/kg</option><option value="109.00">Premium — ₹109.00/L</option></select></div>
      <div class="form-group"><div class="form-label">Quantity (Litres / kg)</div><input type="number" class="form-control" id="bill-qty" value="20" min="1" max="500" oninput="updateBill()"></div>
      <div class="form-group"><div class="form-label">Payment Method</div><select class="form-control" id="bill-pay"><option>Cash</option><option>UPI / QR</option><option>Card</option><option>Fleet Card</option></select></div>
      <div style="background:var(--bg2);border-radius:8px;padding:14px;margin-bottom:16px;">
        <div class="flex-between" style="margin-bottom:6px;"><span style="font-size:0.82rem;color:var(--text2);">Subtotal</span><span style="font-size:0.82rem;font-weight:600;" id="bill-sub">₹2,070.00</span></div>
        <div class="flex-between" style="margin-bottom:6px;"><span style="font-size:0.82rem;color:var(--text2);">GST (18%)</span><span style="font-size:0.82rem;font-weight:600;" id="bill-gst">₹372.60</span></div>
        <div style="border-top:1px solid var(--border);margin:8px 0;"></div>
        <div class="flex-between"><span style="font-weight:700;">Total</span><span style="font-size:1.1rem;font-weight:800;color:var(--accent);" id="bill-total">₹2,442.60</span></div>
      </div>
      <div class="flex-gap">
        <button class="btn btn-primary" style="flex:1;" onclick="openModal('invoice-modal')"><i class="fa-solid fa-receipt"></i> Generate Invoice</button>
        <button class="btn btn-outline" onclick="showToast('QR payment opened','info')"><i class="fa-solid fa-qrcode"></i></button>
      </div>
    </div>
    <div class="card">
      <div class="card-header"><div class="card-title">All Transactions</div><div class="card-subtitle" id="txn-count">Showing all transactions</div></div>
      <div class="table-wrap">
        <table>
          <thead><tr><th>#</th><th>Fuel</th><th>Qty</th><th>Amount</th><th>Method</th><th>Status</th></tr></thead>
          <tbody id="billing-table"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- ===== EXPENSES PAGE ===== -->
<div id="page-expenses" class="page">
  <div class="breadcrumb"><span>Home</span> / Expenses</div>
  <div class="flex-between mb-16">
    <div class="page-header" style="margin:0;"><div class="page-title">Expense Management</div><div class="page-subtitle">Track all operational costs</div></div>
    <button class="btn btn-primary" onclick="openModal('expense-modal')"><i class="fa-solid fa-plus"></i> Add Expense</button>
  </div>
  <div class="stats-grid" style="grid-template-columns:repeat(4,1fr);">
    <div class="stat-card red"><div class="stat-icon red"><i class="fa-solid fa-arrow-up-wide-short"></i></div><div class="stat-value">₹6.2L</div><div class="stat-label">Total Expenses (Month)</div></div>
    <div class="stat-card orange"><div class="stat-icon orange"><i class="fa-solid fa-wrench"></i></div><div class="stat-value">₹48K</div><div class="stat-label">Maintenance</div></div>
    <div class="stat-card blue"><div class="stat-icon blue"><i class="fa-solid fa-bolt"></i></div><div class="stat-value">₹22K</div><div class="stat-label">Electricity</div></div>
    <div class="stat-card green"><div class="stat-icon green"><i class="fa-solid fa-users"></i></div><div class="stat-value">₹8.4L</div><div class="stat-label">Staff Salaries</div></div>
  </div>
  <div class="grid-7-5">
    <div class="card">
      <div class="card-header"><div class="card-title">Expense Breakdown</div><div class="card-subtitle">Monthly expense categories</div></div>
      <div class="chart-container" style="height:280px;"><canvas id="expenseChart" role="img" aria-label="Expense breakdown bar chart">Monthly expense categories.</canvas></div>
    </div>
    <div class="card">
      <div class="card-header"><div class="card-title">Recent Expenses</div></div>
      <div id="expense-list"></div>
    </div>
  </div>
</div>

<!-- ===== REPORTS PAGE ===== -->
<div id="page-reports" class="page">
  <div class="breadcrumb"><span>Home</span> / Reports</div>
  <div class="flex-between mb-16">
    <div class="page-header" style="margin:0;"><div class="page-title">Reports & Analytics</div><div class="page-subtitle">Comprehensive business intelligence</div></div>
    <div class="flex-gap">
      <select class="form-control" style="width:140px;"><option>This Month</option><option>Last Month</option><option>This Year</option></select>
      <button class="btn btn-primary" onclick="showToast('Report exported as PDF','success')"><i class="fa-solid fa-download"></i> Export PDF</button>
    </div>
  </div>
  <div class="grid-2 section-gap">
    <div class="card">
      <div class="card-header"><div class="card-title">Daily Sales Trend</div></div>
      <div class="chart-container" style="height:240px;"><canvas id="dailyChart" role="img" aria-label="Daily sales trend line chart">Daily sales trend.</canvas></div>
    </div>
    <div class="card">
      <div class="card-header"><div class="card-title">Fuel Consumption</div></div>
      <div class="chart-container" style="height:240px;"><canvas id="consumptionChart" role="img" aria-label="Fuel consumption chart">Fuel consumption by type.</canvas></div>
    </div>
  </div>
  <div class="grid-3 section-gap">
    <div class="card" style="text-align:center;padding:28px 20px;">
      <div style="width:56px;height:56px;background:#fff7ed;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-size:1.4rem;color:var(--accent);"><i class="fa-solid fa-calendar-day"></i></div>
      <div style="font-size:1.1rem;font-weight:700;margin-bottom:4px;">Daily Report</div>
      <div style="font-size:0.78rem;color:var(--text3);margin-bottom:16px;">Today's full summary</div>
      <button class="btn btn-primary btn-sm" onclick="showToast('Daily report downloaded','success')"><i class="fa-solid fa-download"></i> Download</button>
    </div>
    <div class="card" style="text-align:center;padding:28px 20px;">
      <div style="width:56px;height:56px;background:#dbeafe;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-size:1.4rem;color:#2563eb;"><i class="fa-solid fa-calendar-week"></i></div>
      <div style="font-size:1.1rem;font-weight:700;margin-bottom:4px;">Weekly Report</div>
      <div style="font-size:0.78rem;color:var(--text3);margin-bottom:16px;">Last 7 days analytics</div>
      <button class="btn btn-outline btn-sm" onclick="showToast('Weekly report downloaded','success')"><i class="fa-solid fa-download"></i> Download</button>
    </div>
    <div class="card" style="text-align:center;padding:28px 20px;">
      <div style="width:56px;height:56px;background:#d1fae5;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-size:1.4rem;color:#059669;"><i class="fa-solid fa-calendar"></i></div>
      <div style="font-size:1.1rem;font-weight:700;margin-bottom:4px;">Monthly Report</div>
      <div style="font-size:0.78rem;color:var(--text3);margin-bottom:16px;">Full month breakdown</div>
      <button class="btn btn-outline btn-sm" onclick="showToast('Monthly report downloaded','success')"><i class="fa-solid fa-download"></i> Download</button>
    </div>
  </div>
  <div class="card">
    <div class="card-header"><div class="card-title">Employee Performance</div><div class="card-subtitle">Top performers this month</div></div>
    <div class="table-wrap"><table>
      <thead><tr><th>Employee</th><th>Role</th><th>Pump</th><th>Transactions</th><th>Revenue Generated</th><th>Attendance</th><th>Rating</th></tr></thead>
      <tbody>
        <tr><td><div class="flex-gap"><div style="width:30px;height:30px;border-radius:50%;background:#f97316;color:white;display:flex;align-items:center;justify-content:center;font-size:0.7rem;font-weight:700;">RS</div>Ravi Sharma</div></td><td>Manager</td><td>Pump #1</td><td>842</td><td>₹4.2L</td><td><span class="badge badge-success">98%</span></td><td>⭐⭐⭐⭐⭐</td></tr>
        <tr><td><div class="flex-gap"><div style="width:30px;height:30px;border-radius:50%;background:#3b82f6;color:white;display:flex;align-items:center;justify-content:center;font-size:0.7rem;font-weight:700;">PK</div>Priya Kumar</div></td><td>Accountant</td><td>Pump #2</td><td>680</td><td>₹3.4L</td><td><span class="badge badge-success">96%</span></td><td>⭐⭐⭐⭐⭐</td></tr>
        <tr><td><div class="flex-gap"><div style="width:30px;height:30px;border-radius:50%;background:#8b5cf6;color:white;display:flex;align-items:center;justify-content:center;font-size:0.7rem;font-weight:700;">AM</div>Arjun Mehta</div></td><td>Worker</td><td>Pump #3</td><td>520</td><td>₹2.6L</td><td><span class="badge badge-warning">87%</span></td><td>⭐⭐⭐⭐</td></tr>
      </tbody>
    </table></div>
  </div>
</div>

<!-- ===== SETTINGS PAGE ===== -->
<div id="page-settings" class="page">
  <div class="breadcrumb"><span>Home</span> / Settings</div>
  <div class="page-header"><div class="page-title">System Settings</div><div class="page-subtitle">Configure your FuelERP system</div></div>
  <div class="grid-2">
    <div style="display:flex;flex-direction:column;gap:20px;">
      <div class="card">
        <div class="settings-section-title">Company Information</div>
        <div class="form-group"><div class="form-label">Company Name</div><input class="form-control" value="Mehta Fuel Group Pvt. Ltd."></div>
        <div class="form-row">
          <div class="form-group"><div class="form-label">GST Number</div><input class="form-control" value="27AADCM1234A1ZX"></div>
          <div class="form-group"><div class="form-label">Phone</div><input class="form-control" value="+91 98765 43210"></div>
        </div>
        <div class="form-group"><div class="form-label">Address</div><input class="form-control" value="Plot 12, Baner Road, Pune 411045"></div>
        <div class="form-group">
          <div class="form-label">Logo</div>
          <div style="border:2px dashed var(--border);border-radius:8px;padding:20px;text-align:center;cursor:pointer;" onclick="showToast('Upload feature in full version','info')">
            <i class="fa-solid fa-cloud-arrow-up" style="font-size:1.5rem;color:var(--text3);"></i>
            <p style="font-size:0.82rem;color:var(--text3);margin-top:6px;">Click to upload logo</p>
          </div>
        </div>
        <button class="btn btn-primary" onclick="showToast('Company info saved!','success')"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
      </div>
      <div class="card">
        <div class="settings-section-title">Fuel Price Settings</div>
        <div class="form-row">
          <div class="form-group"><div class="form-label">Petrol (₹/L)</div><input class="form-control" value="103.50" type="number"></div>
          <div class="form-group"><div class="form-label">Diesel (₹/L)</div><input class="form-control" value="89.75" type="number"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><div class="form-label">CNG (₹/kg)</div><input class="form-control" value="78.00" type="number"></div>
          <div class="form-group"><div class="form-label">Premium (₹/L)</div><input class="form-control" value="109.00" type="number"></div>
        </div>
        <button class="btn btn-primary" onclick="showToast('Prices updated successfully!','success')"><i class="fa-solid fa-tag"></i> Update Prices</button>
      </div>
    </div>
    <div style="display:flex;flex-direction:column;gap:20px;">
      <div class="card">
        <div class="settings-section-title">Notifications</div>
        <div class="settings-row"><div class="settings-row-info"><p>Low Stock Alerts</p><span>Alert when fuel drops below 20%</span></div><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></div>
        <div class="settings-row"><div class="settings-row-info"><p>Daily Report Email</p><span>Receive daily summary by email</span></div><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></div>
        <div class="settings-row"><div class="settings-row-info"><p>Payment Notifications</p><span>Alert on every payment received</span></div><label class="toggle-switch"><input type="checkbox"><span class="toggle-slider"></span></label></div>
        <div class="settings-row"><div class="settings-row-info"><p>Employee Alerts</p><span>Late arrival & absence notifications</span></div><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></div>
        <div class="settings-row"><div class="settings-row-info"><p>Price Update Alerts</p><span>Notify on government price changes</span></div><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></div>
      </div>
      <div class="card">
        <div class="settings-section-title">Appearance</div>
        <div class="settings-row"><div class="settings-row-info"><p>Dark Mode</p><span>Switch to dark theme</span></div><label class="toggle-switch"><input type="checkbox" id="dark-toggle" onchange="toggleTheme()"><span class="toggle-slider"></span></label></div>
        <div class="settings-row"><div class="settings-row-info"><p>Compact Sidebar</p><span>Collapse sidebar by default</span></div><label class="toggle-switch"><input type="checkbox"><span class="toggle-slider"></span></label></div>
        <div class="settings-row"><div class="settings-row-info"><p>Animations</p><span>Enable UI animations</span></div><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></div>
      </div>
      <div class="card">
        <div class="settings-section-title">User Profile</div>
        <div class="form-row">
          <div class="form-group"><div class="form-label">First Name</div><input class="form-control" value="Amit"></div>
          <div class="form-group"><div class="form-label">Last Name</div><input class="form-control" value="Mehta"></div>
        </div>
        <div class="form-group"><div class="form-label">Email</div><input class="form-control" value="amit@mehtafuel.com"></div>
        <div class="form-group"><div class="form-label">New Password</div><input class="form-control" type="password" placeholder="••••••••"></div>
        <button class="btn btn-primary" onclick="showToast('Profile updated!','success')"><i class="fa-solid fa-floppy-disk"></i> Save Profile</button>
      </div>
    </div>
  </div>
</div>

</main>

<!-- ===== MODALS ===== -->
<!-- Add Pump Modal -->
<div class="modal-overlay" id="pump-modal">
  <div class="modal">
    <div class="modal-header"><div class="modal-title"><i class="fa-solid fa-gas-pump" style="color:var(--accent);margin-right:8px;"></i>Add Petrol Pump</div><button class="modal-close" onclick="closeModal('pump-modal')"><i class="fa-solid fa-xmark"></i></button></div>
    <div class="modal-body">
      <div class="form-row"><div class="form-group"><div class="form-label">Pump Name *</div><input class="form-control" placeholder="e.g. Pune Highway Station"></div><div class="form-group"><div class="form-label">Location *</div><input class="form-control" placeholder="City, Area"></div></div>
      <div class="form-row"><div class="form-group"><div class="form-label">Owner Name *</div><input class="form-control" placeholder="Full name"></div><div class="form-group"><div class="form-label">Contact Number *</div><input class="form-control" placeholder="+91 XXXXX XXXXX"></div></div>
      <div class="form-row"><div class="form-group"><div class="form-label">License Number</div><input class="form-control" placeholder="License ID"></div><div class="form-group"><div class="form-label">Status</div><select class="form-control"><option>Active</option><option>Inactive</option><option>Maintenance</option></select></div></div>
      <div class="form-group"><div class="form-label">Fuel Types Available</div><div class="flex-gap" style="flex-wrap:wrap;gap:10px;"><label style="display:flex;align-items:center;gap:5px;font-size:0.85rem;"><input type="checkbox" checked> Petrol</label><label style="display:flex;align-items:center;gap:5px;font-size:0.85rem;"><input type="checkbox" checked> Diesel</label><label style="display:flex;align-items:center;gap:5px;font-size:0.85rem;"><input type="checkbox"> CNG</label><label style="display:flex;align-items:center;gap:5px;font-size:0.85rem;"><input type="checkbox"> Premium</label></div></div>
    </div>
    <div class="modal-footer"><button class="btn btn-outline" onclick="closeModal('pump-modal')">Cancel</button><button class="btn btn-primary" onclick="addPump()"><i class="fa-solid fa-plus"></i> Add Pump</button></div>
  </div>
</div>

<!-- Add Employee Modal -->
<div class="modal-overlay" id="emp-modal">
  <div class="modal">
    <div class="modal-header"><div class="modal-title"><i class="fa-solid fa-user-plus" style="color:var(--accent);margin-right:8px;"></i>Add Employee</div><button class="modal-close" onclick="closeModal('emp-modal')"><i class="fa-solid fa-xmark"></i></button></div>
    <div class="modal-body">
      <div class="form-row"><div class="form-group"><div class="form-label">Full Name *</div><input class="form-control" placeholder="Employee name"></div><div class="form-group"><div class="form-label">Role *</div><select class="form-control"><option>Manager</option><option>Worker</option><option>Accountant</option><option>Security</option></select></div></div>
      <div class="form-row"><div class="form-group"><div class="form-label">Contact</div><input class="form-control" placeholder="+91 XXXXX XXXXX"></div><div class="form-group"><div class="form-label">Assigned Pump</div><select class="form-control"><option>Pump #1</option><option>Pump #2</option><option>Pump #3</option><option>All Pumps</option></select></div></div>
      <div class="form-row"><div class="form-group"><div class="form-label">Shift</div><select class="form-control"><option>Morning (6AM–2PM)</option><option>Afternoon (2PM–10PM)</option><option>Night (10PM–6AM)</option></select></div><div class="form-group"><div class="form-label">Salary (₹/month)</div><input class="form-control" placeholder="e.g. 18000" type="number"></div></div>
    </div>
    <div class="modal-footer"><button class="btn btn-outline" onclick="closeModal('emp-modal')">Cancel</button><button class="btn btn-primary" onclick="showToast('Employee added successfully!','success');closeModal('emp-modal')"><i class="fa-solid fa-user-plus"></i> Add Employee</button></div>
  </div>
</div>

<!-- Invoice Modal -->
<div class="modal-overlay" id="invoice-modal">
  <div class="modal" style="max-width:520px;">
    <div class="modal-header"><div class="modal-title">Invoice Preview</div><button class="modal-close" onclick="closeModal('invoice-modal')"><i class="fa-solid fa-xmark"></i></button></div>
    <div class="modal-body"><div id="invoice-content"></div></div>
    <div class="modal-footer"><button class="btn btn-outline" onclick="closeModal('invoice-modal')">Close</button><button class="btn btn-primary" onclick="showToast('Invoice printed!','success')"><i class="fa-solid fa-print"></i> Print Invoice</button></div>
  </div>
</div>

<!-- Price Update Modal -->
<div class="modal-overlay" id="price-modal">
  <div class="modal" style="max-width:440px;">
    <div class="modal-header"><div class="modal-title"><i class="fa-solid fa-tag" style="color:var(--accent);margin-right:8px;"></i>Update Fuel Prices</div><button class="modal-close" onclick="closeModal('price-modal')"><i class="fa-solid fa-xmark"></i></button></div>
    <div class="modal-body">
      <div class="form-row"><div class="form-group"><div class="form-label">Petrol (₹/L)</div><input class="form-control" value="103.50" type="number" step="0.01"></div><div class="form-group"><div class="form-label">Diesel (₹/L)</div><input class="form-control" value="89.75" type="number" step="0.01"></div></div>
      <div class="form-row"><div class="form-group"><div class="form-label">CNG (₹/kg)</div><input class="form-control" value="78.00" type="number" step="0.01"></div><div class="form-group"><div class="form-label">Premium (₹/L)</div><input class="form-control" value="109.00" type="number" step="0.01"></div></div>
    </div>
    <div class="modal-footer"><button class="btn btn-outline" onclick="closeModal('price-modal')">Cancel</button><button class="btn btn-primary" onclick="showToast('Prices updated!','success');closeModal('price-modal')">Update Prices</button></div>
  </div>
</div>

<!-- Expense Modal -->
<div class="modal-overlay" id="expense-modal">
  <div class="modal" style="max-width:440px;">
    <div class="modal-header"><div class="modal-title"><i class="fa-solid fa-plus" style="color:var(--accent);margin-right:8px;"></i>Add Expense</div><button class="modal-close" onclick="closeModal('expense-modal')"><i class="fa-solid fa-xmark"></i></button></div>
    <div class="modal-body">
      <div class="form-row"><div class="form-group"><div class="form-label">Category</div><select class="form-control"><option>Maintenance</option><option>Electricity</option><option>Fuel Purchase</option><option>Staff Salary</option><option>Miscellaneous</option></select></div><div class="form-group"><div class="form-label">Amount (₹)</div><input class="form-control" type="number" placeholder="0.00"></div></div>
      <div class="form-group"><div class="form-label">Description</div><input class="form-control" placeholder="Brief description"></div>
      <div class="form-row"><div class="form-group"><div class="form-label">Pump</div><select class="form-control"><option>Pump #1</option><option>Pump #2</option><option>Pump #3</option><option>All</option></select></div><div class="form-group"><div class="form-label">Date</div><input class="form-control" type="date"></div></div>
    </div>
    <div class="modal-footer"><button class="btn btn-outline" onclick="closeModal('expense-modal')">Cancel</button><button class="btn btn-primary" onclick="showToast('Expense recorded!','success');closeModal('expense-modal')">Add Expense</button></div>
  </div>
</div>

<!-- TOAST -->
<div id="toast-container" style="position:fixed;bottom:24px;right:24px;display:flex;flex-direction:column;gap:8px;z-index:9998;"></div>

<script>
// ===== DUMMY DATA =====
const pumpsData = [
  {id:'P001',name:'Pune Main Station',location:'Baner, Pune',owner:'Amit Mehta',contact:'+91 98765 43210',fuels:'Petrol, Diesel, Premium',status:'active'},
  {id:'P002',name:'Kothrud Fuel Point',location:'Kothrud, Pune',owner:'Suresh Patil',contact:'+91 87654 32109',fuels:'Petrol, Diesel',status:'active'},
  {id:'P003',name:'Mumbai Highway Depot',location:'Khopoli, Mumbai',owner:'Ramesh Joshi',contact:'+91 76543 21098',fuels:'Petrol, Diesel, CNG',status:'active'},
  {id:'P004',name:'Nashik North Pump',location:'Deolali, Nashik',owner:'Vijay Kulkarni',contact:'+91 65432 10987',fuels:'Petrol, Diesel',status:'maintenance'},
  {id:'P005',name:'Pimpri Station',location:'Pimpri-Chinchwad',owner:'Deepak Shah',contact:'+91 54321 09876',fuels:'Petrol, Diesel, CNG, Premium',status:'active'},
  {id:'P006',name:'Hadapsar Fuel Hub',location:'Hadapsar, Pune',owner:'Nitin More',contact:'+91 43210 98765',fuels:'Petrol, Diesel',status:'active'},
];
const transactions = [
  {id:'T1042',pump:'Pump #1',fuel:'Petrol',qty:35,amount:3622.5,method:'UPI',time:'10:42 AM',status:'completed'},
  {id:'T1041',pump:'Pump #3',fuel:'Diesel',qty:80,amount:7180,method:'Cash',time:'10:38 AM',status:'completed'},
  {id:'T1040',pump:'Pump #2',fuel:'Premium',qty:20,amount:2180,method:'Card',time:'10:31 AM',status:'completed'},
  {id:'T1039',pump:'Pump #5',fuel:'CNG',qty:15,amount:1170,method:'UPI',time:'10:22 AM',status:'completed'},
  {id:'T1038',pump:'Pump #1',fuel:'Petrol',qty:50,amount:5175,method:'Fleet',time:'10:14 AM',status:'completed'},
  {id:'T1037',pump:'Pump #4',fuel:'Diesel',qty:120,amount:10770,method:'Cash',time:'10:08 AM',status:'pending'},
  {id:'T1036',pump:'Pump #6',fuel:'Petrol',qty:22,amount:2277,method:'UPI',time:'09:55 AM',status:'completed'},
  {id:'T1035',pump:'Pump #2',fuel:'Diesel',qty:45,amount:4038.75,method:'Card',time:'09:44 AM',status:'completed'},
  {id:'T1034',pump:'Pump #3',fuel:'Premium',qty:30,amount:3270,method:'UPI',time:'09:32 AM',status:'completed'},
  {id:'T1033',pump:'Pump #1',fuel:'CNG',qty:10,amount:780,method:'Cash',time:'09:18 AM',status:'failed'},
];
const employees = [
  {name:'Ravi Sharma',role:'Manager',pump:'Pump #1',shift:'Morning',salary:'₹32,000',status:'present',color:'#f97316'},
  {name:'Priya Kumar',role:'Accountant',pump:'Pump #2',shift:'Morning',salary:'₹28,000',status:'present',color:'#3b82f6'},
  {name:'Arjun Mehta',role:'Worker',pump:'Pump #3',shift:'Afternoon',salary:'₹18,000',status:'present',color:'#8b5cf6'},
  {name:'Sunita Rao',role:'Manager',pump:'Pump #4',shift:'Morning',salary:'₹30,000',status:'absent',color:'#10b981'},
  {name:'Deepak Nair',role:'Worker',pump:'Pump #5',shift:'Night',salary:'₹17,000',status:'present',color:'#ef4444'},
  {name:'Kavita Joshi',role:'Accountant',pump:'Pump #6',shift:'Afternoon',salary:'₹26,000',status:'present',color:'#f59e0b'},
  {name:'Ankit Verma',role:'Worker',pump:'Pump #1',shift:'Afternoon',salary:'₹16,000',status:'present',color:'#06b6d4'},
  {name:'Meera Patel',role:'Worker',pump:'Pump #2',shift:'Night',salary:'₹16,500',status:'present',color:'#ec4899'},
];
const expenses = [
  {cat:'Fuel Purchase',desc:'Petrol 40,000L from BPCL',amount:'₹41,40,000',date:'27 May',icon:'fa-barrel',color:'#fff7ed',icolor:'#f97316'},
  {cat:'Staff Salary',desc:'May payroll — 42 employees',amount:'₹8,40,000',date:'25 May',icon:'fa-users',color:'#d1fae5',icolor:'#059669'},
  {cat:'Electricity',desc:'Monthly bill — all pumps',amount:'₹22,400',date:'22 May',icon:'fa-bolt',color:'#dbeafe',icolor:'#2563eb'},
  {cat:'Maintenance',desc:'Pump nozzle replacement #3',amount:'₹14,500',date:'20 May',icon:'fa-wrench',color:'#fef3c7',icolor:'#d97706'},
  {cat:'Miscellaneous',desc:'Stationery & office supplies',amount:'₹3,200',date:'19 May',icon:'fa-box',color:'#f5f3ff',icolor:'#7c3aed'},
];
const tickerFuels = [
  {name:'Petrol PUN',price:'₹103.50',change:'+0.00%'},
  {name:'Diesel PUN',price:'₹89.75',change:'+0.17%'},
  {name:'CNG PUN',price:'₹78.00',change:'0.00%'},
  {name:'Premium PUN',price:'₹109.00',change:'+0.09%'},
  {name:'Petrol MUM',price:'₹104.20',change:'-0.29%'},
  {name:'Diesel MUM',price:'₹90.40',change:'+0.17%'},
];

// ===== LOADING SCREEN =====
window.addEventListener('load',()=>{
  setTimeout(()=>{
    document.getElementById('loading-screen').classList.add('hide');
    initAll();
  },2000);
});

function initAll(){
  updateClock();
  setInterval(updateClock,1000);
  initTicker();
  setDate();
  renderTxnTable();
  renderPumpsTable();
  renderEmployees();
  renderBillingTable();
  renderExpenses();
  renderInventory();
  initCharts();
}

// ===== CLOCK =====
function updateClock(){
  const n=new Date();
  const t=n.toLocaleTimeString('en-IN',{hour:'2-digit',minute:'2-digit',second:'2-digit'});
  const el=document.getElementById('clock-widget');
  if(el) el.textContent=t;
}
function setDate(){
  const d=new Date().toLocaleDateString('en-IN',{weekday:'long',year:'numeric',month:'long',day:'numeric'});
  const el=document.getElementById('today-date');
  if(el) el.textContent=d;
}

// ===== TICKER =====
function initTicker(){
  const t=document.getElementById('ticker');
  if(!t)return;
  let html='';
  for(let i=0;i<2;i++){
    tickerFuels.forEach(f=>{
      const up=f.change.startsWith('+');
      const zero=f.change==='0.00%';
      html+=`<span class="ticker-item"><strong>${f.name}</strong> ${f.price} <span class="${up?'up':zero?'':'down'}">${f.change}</span></span>`;
    });
  }
  t.innerHTML=html;
}

// ===== NAVIGATION =====
function showPage(name,el){
  document.querySelectorAll('.page').forEach(p=>p.classList.remove('active'));
  document.querySelectorAll('.nav-item').forEach(n=>n.classList.remove('active'));
  const pg=document.getElementById('page-'+name);
  if(pg) pg.classList.add('active');
  if(el) el.classList.add('active');
  if(window.innerWidth<=768) closeSidebar();
  window.scrollTo(0,0);
  // Reinit charts on first view
  if(name==='inventory' && !window._stockInited){window._stockInited=true;initStockChart();}
  if(name==='expenses' && !window._expInited){window._expInited=true;initExpenseChart();}
  if(name==='reports' && !window._repInited){window._repInited=true;initReportCharts();}
}

// ===== SIDEBAR =====
function toggleSidebar(){
  const s=document.getElementById('sidebar');
  const t=document.getElementById('topbar');
  const m=document.getElementById('main');
  if(window.innerWidth<=768){
    s.classList.toggle('mobile-open');
    document.getElementById('overlay-mobile').classList.toggle('show');
  } else {
    s.classList.toggle('collapsed');
    t.classList.toggle('expanded');
    m.classList.toggle('expanded');
  }
}
function closeSidebar(){
  document.getElementById('sidebar').classList.remove('mobile-open');
  document.getElementById('overlay-mobile').classList.remove('show');
}

// ===== THEME =====
let isDark=false;
function toggleTheme(){
  isDark=!isDark;
  document.documentElement.setAttribute('data-theme',isDark?'dark':'');
  document.getElementById('theme-btn').innerHTML=isDark?'<i class="fa-solid fa-sun"></i>':'<i class="fa-solid fa-moon"></i>';
  const dt=document.getElementById('dark-toggle');
  if(dt) dt.checked=isDark;
}

// ===== DROPDOWNS =====
function toggleDropdown(id){
  document.querySelectorAll('.dropdown-menu').forEach(d=>{if(d.id!==id)d.classList.remove('show');});
  document.getElementById(id).classList.toggle('show');
}
document.addEventListener('click',e=>{
  if(!e.target.closest('.dropdown')) document.querySelectorAll('.dropdown-menu').forEach(d=>d.classList.remove('show'));
});

// ===== MODALS =====
function openModal(id){
  document.getElementById(id).classList.add('show');
  if(id==='invoice-modal') renderInvoice();
}
function closeModal(id){document.getElementById(id).classList.remove('show');}
document.querySelectorAll('.modal-overlay').forEach(m=>{
  m.addEventListener('click',e=>{if(e.target===m) m.classList.remove('show');});
});

// ===== TOAST =====
function showToast(msg,type='info'){
  const colors={success:'#10b981',error:'#ef4444',warning:'#f59e0b',info:'#3b82f6'};
  const icons={success:'fa-circle-check',error:'fa-circle-xmark',warning:'fa-triangle-exclamation',info:'fa-circle-info'};
  const t=document.getElementById('toast-container');
  const toast=document.createElement('div');
  toast.style.cssText=`background:var(--card);border:1px solid var(--border);border-left:4px solid ${colors[type]};border-radius:10px;padding:12px 16px;display:flex;align-items:center;gap:10px;font-size:0.875rem;box-shadow:var(--shadow-lg);min-width:240px;animation:slideIn 0.3s ease;`;
  toast.innerHTML=`<i class="fa-solid ${icons[type]}" style="color:${colors[type]};"></i><span>${msg}</span>`;
  t.appendChild(toast);
  setTimeout(()=>{toast.style.opacity='0';toast.style.transform='translateX(20px)';toast.style.transition='all 0.3s';setTimeout(()=>toast.remove(),300);},3000);
}

// ===== RENDER FUNCTIONS =====
function renderTxnTable(){
  const tb=document.getElementById('txn-table');
  if(!tb)return;
  tb.innerHTML=transactions.map(t=>`
    <tr>
      <td style="font-family:monospace;font-size:0.8rem;color:var(--text3);">${t.id}</td>
      <td>${t.pump}</td>
      <td><span style="display:inline-flex;align-items:center;gap:4px;">${fuelIcon(t.fuel)} ${t.fuel}</span></td>
      <td>${t.qty}L</td>
      <td style="font-weight:600;">₹${t.amount.toLocaleString('en-IN',{maximumFractionDigits:2})}</td>
      <td><span class="badge badge-gray">${t.method}</span></td>
      <td style="color:var(--text3);font-size:0.82rem;">${t.time}</td>
      <td>${statusBadge(t.status)}</td>
    </tr>`).join('');
}
function renderPumpsTable(){
  const tb=document.getElementById('pumps-tbody');
  if(!tb)return;
  tb.innerHTML=pumpsData.map(p=>`
    <tr>
      <td style="font-family:monospace;font-size:0.8rem;color:var(--text3);">${p.id}</td>
      <td><strong>${p.name}</strong></td>
      <td><i class="fa-solid fa-location-dot" style="color:var(--accent);margin-right:5px;"></i>${p.location}</td>
      <td>${p.owner}</td>
      <td><a href="tel:${p.contact}" style="color:var(--info);">${p.contact}</a></td>
      <td style="font-size:0.78rem;">${p.fuels}</td>
      <td>${statusBadge(p.status)}</td>
      <td>
        <div class="flex-gap">
          <button class="btn btn-outline btn-sm btn-icon" onclick="showToast('Edit feature in full version','info')" title="Edit"><i class="fa-solid fa-pen-to-square"></i></button>
          <button class="btn btn-danger btn-sm btn-icon" onclick="showToast('Pump deleted (demo)','error')" title="Delete"><i class="fa-solid fa-trash"></i></button>
        </div>
      </td>
    </tr>`).join('');
}
function renderEmployees(){
  const c=document.getElementById('emp-cards');
  if(!c)return;
  c.innerHTML=employees.map(e=>`
    <div class="emp-card">
      <div class="emp-avatar" style="background:${e.color};">${e.name.split(' ').map(n=>n[0]).join('')}</div>
      <div class="emp-name">${e.name}</div>
      <div class="emp-role"><span class="badge badge-gray">${e.role}</span></div>
      <div style="margin:10px 0;font-size:0.78rem;color:var(--text3);">${e.pump} · ${e.shift}</div>
      <div class="emp-stats">
        <span class="badge badge-info">${e.salary}</span>
        <span class="badge ${e.status==='present'?'badge-success':'badge-danger'}">${e.status}</span>
      </div>
      <div class="flex-gap" style="justify-content:center;margin-top:12px;">
        <button class="btn btn-outline btn-sm btn-icon" onclick="showToast('Edit employee','info')"><i class="fa-solid fa-pen-to-square"></i></button>
        <button class="btn btn-outline btn-sm btn-icon" onclick="showToast('Call '+this.closest('.emp-card').querySelector('.emp-name').textContent,'info')"><i class="fa-solid fa-phone"></i></button>
      </div>
    </div>`).join('');
}
function renderBillingTable(){
  const tb=document.getElementById('billing-table');
  if(!tb)return;
  tb.innerHTML=transactions.map((t,i)=>`
    <tr>
      <td style="font-size:0.78rem;color:var(--text3);">${t.id}</td>
      <td>${fuelIcon(t.fuel)} ${t.fuel}</td>
      <td>${t.qty}L</td>
      <td style="font-weight:600;">₹${t.amount.toLocaleString('en-IN',{maximumFractionDigits:2})}</td>
      <td>${t.method}</td>
      <td>${statusBadge(t.status)}</td>
    </tr>`).join('');
}
function renderExpenses(){
  const el=document.getElementById('expense-list');
  if(!el)return;
  el.innerHTML=expenses.map(e=>`
    <div class="notif-panel-item">
      <div class="notif-panel-icon" style="background:${e.color};color:${e.icolor};"><i class="fa-solid ${e.icon}"></i></div>
      <div class="notif-panel-content" style="flex:1;">
        <p>${e.cat}</p>
        <div class="time">${e.desc}</div>
      </div>
      <div style="font-weight:700;font-size:0.85rem;color:var(--text);white-space:nowrap;">${e.amount}</div>
    </div>`).join('');
}
const inventory=[
  {name:'Petrol',icon:'⛽',color:'#f97316',bgColor:'#fff7ed',capacity:50000,current:36000,unit:'litres',price:'₹103.50/L',low:20,critical:10},
  {name:'Diesel',icon:'🛢️',color:'#3b82f6',bgColor:'#eff6ff',capacity:50000,current:11500,unit:'litres',price:'₹89.75/L',low:20,critical:10},
  {name:'CNG',icon:'💨',color:'#10b981',bgColor:'#f0fdf4',capacity:5000,current:2750,unit:'kg',price:'₹78.00/kg',low:30,critical:15},
  {name:'Premium',icon:'⭐',color:'#8b5cf6',bgColor:'#f5f3ff',capacity:50000,current:44000,unit:'litres',price:'₹109.00/L',low:20,critical:10},
];
function renderInventory(){
  const c=document.getElementById('inventory-cards');
  if(!c)return;
  c.innerHTML=inventory.map(f=>{
    const pct=Math.round((f.current/f.capacity)*100);
    const warn=pct<=f.low;
    const crit=pct<=f.critical;
    return `<div class="card">
      <div class="card-header">
        <div class="flex-gap"><span style="font-size:1.5rem;">${f.icon}</span><div><div class="card-title">${f.name} Stock</div><div class="card-subtitle">${f.price}</div></div></div>
        <span class="badge ${crit?'badge-danger':warn?'badge-warning':'badge-success'}">${crit?'Critical':warn?'Low':'Normal'}</span>
      </div>
      <div class="flex-between" style="margin-bottom:8px;">
        <span style="font-size:0.82rem;color:var(--text2);">${f.current.toLocaleString('en-IN')} / ${f.capacity.toLocaleString('en-IN')} ${f.unit}</span>
        <span style="font-size:1rem;font-weight:700;color:${f.color};">${pct}%</span>
      </div>
      <div class="progress-bar"><div class="progress-fill" style="width:${pct}%;background:${f.color};"></div></div>
      <div style="margin-top:14px;display:flex;gap:8px;">
        <button class="btn btn-primary btn-sm" onclick="showToast('Refill order placed for ${f.name}!','success')"><i class="fa-solid fa-plus"></i> Order Refill</button>
        <button class="btn btn-outline btn-sm" onclick="openModal('price-modal')"><i class="fa-solid fa-tag"></i> Update Price</button>
      </div>
    </div>`;
  }).join('');
  // Refill alerts
  const ra=document.getElementById('refill-alerts');
  if(ra) ra.innerHTML=inventory.map(f=>{
    const pct=Math.round((f.current/f.capacity)*100);
    const warn=pct<=f.low;
    if(!warn)return '';
    return `<div class="notif-panel-item">
      <div class="notif-panel-icon" style="background:${pct<=f.critical?'#fee2e2':'#fef3c7'};color:${pct<=f.critical?'#dc2626':'#d97706'};"><i class="fa-solid fa-triangle-exclamation"></i></div>
      <div class="notif-panel-content">
        <p>${f.name} — ${pct}% remaining</p>
        <div class="time">${f.current.toLocaleString('en-IN')} ${f.unit} left · ${pct<=f.critical?'CRITICAL':'Low Stock'}</div>
      </div>
      <button class="btn btn-primary btn-sm" onclick="showToast('Refill ordered!','success')">Order</button>
    </div>`;
  }).join('') || '<div style="padding:20px;text-align:center;color:var(--text3);"><i class="fa-solid fa-circle-check" style="font-size:2rem;color:var(--success);"></i><p style="margin-top:8px;">All stocks are at healthy levels</p></div>';
}

// ===== BILLING =====
function updateBill(){
  const price=parseFloat(document.getElementById('bill-fuel').value)||103.50;
  const qty=parseFloat(document.getElementById('bill-qty').value)||0;
  const sub=price*qty;
  const gst=sub*0.18;
  const total=sub+gst;
  document.getElementById('bill-sub').textContent='₹'+sub.toFixed(2);
  document.getElementById('bill-gst').textContent='₹'+gst.toFixed(2);
  document.getElementById('bill-total').textContent='₹'+total.toFixed(2);
}
function renderInvoice(){
  const fuelSel=document.getElementById('bill-fuel');
  const fuelText=fuelSel.options[fuelSel.selectedIndex].text.split('—')[0].trim();
  const qty=document.getElementById('bill-qty').value;
  const price=parseFloat(document.getElementById('bill-fuel').value);
  const sub=(price*qty).toFixed(2);
  const gst=(price*qty*0.18).toFixed(2);
  const total=(price*qty*1.18).toFixed(2);
  const payMethod=document.getElementById('bill-pay').value;
  const inv=document.getElementById('invoice-content');
  const invNo='INV-'+Math.floor(10000+Math.random()*90000);
  inv.innerHTML=`<div class="invoice-box">
    <div class="invoice-header">
      <div><div style="font-size:1.2rem;font-weight:800;color:#1a2b4a;">⛽ FuelERP Pro</div><div style="font-size:0.75rem;color:#64748b;margin-top:2px;">Mehta Fuel Group Pvt. Ltd.</div><div style="font-size:0.72rem;color:#94a3b8;">GST: 27AADCM1234A1ZX</div></div>
      <div style="text-align:right;"><div style="font-size:1rem;font-weight:700;color:#f97316;">INVOICE</div><div style="font-size:0.8rem;color:#475569;">${invNo}</div><div style="font-size:0.72rem;color:#94a3b8;">${new Date().toLocaleDateString('en-IN')}</div></div>
    </div>
    <table class="invoice-table"><thead><tr><th>Description</th><th>Qty</th><th>Rate</th><th>Amount</th></tr></thead>
    <tbody><tr><td>${fuelText}</td><td>${qty} L</td><td>₹${price.toFixed(2)}</td><td>₹${sub}</td></tr></tbody></table>
    <div class="invoice-total">
      <div style="display:flex;justify-content:space-between;margin-bottom:4px;font-size:0.82rem;"><span>Subtotal</span><span>₹${sub}</span></div>
      <div style="display:flex;justify-content:space-between;margin-bottom:4px;font-size:0.82rem;"><span>GST (18%)</span><span>₹${gst}</span></div>
      <div style="display:flex;justify-content:space-between;font-weight:800;font-size:1rem;color:#f97316;"><span>TOTAL</span><span>₹${total}</span></div>
    </div>
    <div style="margin-top:12px;font-size:0.75rem;color:#94a3b8;text-align:center;">Payment: ${payMethod} · Thank you for your business!</div>
  </div>`;
}

// ===== HELPERS =====
function fuelIcon(f){const icons={Petrol:'⛽',Diesel:'🛢️',CNG:'💨',Premium:'⭐'};return icons[f]||'⛽';}
function statusBadge(s){const map={active:'badge-success',completed:'badge-success',present:'badge-success',inactive:'badge-danger',failed:'badge-danger',absent:'badge-danger',maintenance:'badge-warning',pending:'badge-warning'};return `<span class="badge ${map[s]||'badge-gray'}">${s}</span>`;}
function filterTable(val,id){
  const rows=document.getElementById(id).querySelectorAll('tbody tr');
  rows.forEach(r=>{r.style.display=r.textContent.toLowerCase().includes(val.toLowerCase())?'':'none';});
}
function addPump(){
  showToast('Pump added successfully!','success');
  closeModal('pump-modal');
}

// ===== CHARTS =====
function initCharts(){
  // Sales Chart
  const sCtx=document.getElementById('salesChart');
  if(!sCtx||sCtx._chart)return;
  sCtx._chart=new Chart(sCtx,{type:'bar',data:{
    labels:['Jan','Feb','Mar','Apr','May','Jun'],
    datasets:[
      {label:'Petrol',data:[820,940,780,1020,1150,980],backgroundColor:'#f97316',borderRadius:4},
      {label:'Diesel',data:[540,620,580,710,820,760],backgroundColor:'#3b82f6',borderRadius:4},
      {label:'CNG',data:[180,220,190,260,310,280],backgroundColor:'#10b981',borderRadius:4},
    ]
  },options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false}},scales:{x:{grid:{display:false}},y:{grid:{color:'rgba(0,0,0,0.05)'},ticks:{callback:v=>'₹'+v+'K'}}}}});

  // Pie Chart
  const pCtx=document.getElementById('pieChart');
  if(!pCtx||pCtx._chart)return;
  pCtx._chart=new Chart(pCtx,{type:'doughnut',data:{
    labels:['Petrol','Diesel','CNG'],
    datasets:[{data:[54,33,13],backgroundColor:['#f97316','#3b82f6','#10b981'],borderWidth:0,hoverOffset:4}]
  },options:{responsive:true,maintainAspectRatio:false,cutout:'70%',plugins:{legend:{display:false}}}});
}
function initStockChart(){
  const ctx=document.getElementById('stockChart');
  if(!ctx||ctx._chart)return;
  ctx._chart=new Chart(ctx,{type:'line',data:{
    labels:['21 May','22 May','23 May','24 May','25 May','26 May','27 May'],
    datasets:[
      {label:'Petrol',data:[48,42,38,44,50,40,36],borderColor:'#f97316',backgroundColor:'rgba(249,115,22,0.06)',tension:0.4,fill:true,pointRadius:3},
      {label:'Diesel',data:[38,30,24,20,32,18,11.5],borderColor:'#3b82f6',backgroundColor:'rgba(59,130,246,0.06)',tension:0.4,fill:true,pointRadius:3},
      {label:'CNG',data:[4.5,4.2,3.8,4.1,4.6,3.9,2.75],borderColor:'#10b981',backgroundColor:'rgba(16,185,129,0.06)',tension:0.4,fill:true,pointRadius:3},
    ]
  },options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false}},scales:{x:{grid:{display:false}},y:{grid:{color:'rgba(0,0,0,0.05)'}}}}});
}
function initExpenseChart(){
  const ctx=document.getElementById('expenseChart');
  if(!ctx||ctx._chart)return;
  ctx._chart=new Chart(ctx,{type:'bar',data:{
    labels:['Fuel Purchase','Staff Salary','Maintenance','Electricity','Misc'],
    datasets:[{label:'Amount (₹K)',data:[4140,840,48,22,3.2],backgroundColor:['#f97316','#3b82f6','#f59e0b','#10b981','#8b5cf6'],borderRadius:6}]
  },options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false}},scales:{x:{grid:{display:false}},y:{grid:{color:'rgba(0,0,0,0.05)'},ticks:{callback:v=>'₹'+v+'K'}}}}});
}
function initReportCharts(){
  const d1=document.getElementById('dailyChart');
  if(d1&&!d1._chart) d1._chart=new Chart(d1,{type:'line',data:{
    labels:['6AM','8AM','10AM','12PM','2PM','4PM','6PM','8PM'],
    datasets:[{label:'Revenue (₹K)',data:[12,28,45,62,55,70,82,48],borderColor:'#f97316',backgroundColor:'rgba(249,115,22,0.08)',tension:0.4,fill:true,pointBackgroundColor:'#f97316',pointRadius:4}]
  },options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false}},scales:{x:{grid:{display:false}},y:{grid:{color:'rgba(0,0,0,0.05)'},ticks:{callback:v=>'₹'+v+'K'}}}}});

  const d2=document.getElementById('consumptionChart');
  if(d2&&!d2._chart) d2._chart=new Chart(d2,{type:'bar',data:{
    labels:['Week 1','Week 2','Week 3','Week 4'],
    datasets:[
      {label:'Petrol (KL)',data:[48,52,44,56],backgroundColor:'#f97316',borderRadius:4},
      {label:'Diesel (KL)',data:[32,38,30,42],backgroundColor:'#3b82f6',borderRadius:4},
      {label:'CNG (100kg)',data:[18,22,16,24],backgroundColor:'#10b981',borderRadius:4},
    ]
  },options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false}},scales:{x:{grid:{display:false}},y:{grid:{color:'rgba(0,0,0,0.05)'}}}}});
}

// Init bill calc
setTimeout(()=>updateBill(),2100);
</script>
<style>
@keyframes slideIn{from{opacity:0;transform:translateX(20px)}to{opacity:1;transform:translateX(0)}}
</style>
</body>
</html>

