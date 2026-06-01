
// Build bar chart
const months = ["Oct","Nov","Dec","Jan","Feb","Mar"];
const coData = [1,2,1,3,2,1];
const usData = [2,3,2,4,1,1];
const maxV = Math.max(...coData,...usData);
const bc = document.getElementById("barChart");
const bl = document.getElementById("barLabels");
months.forEach((m,i)=>{
  const g = bc.appendChild(document.createElement("div"));
  g.className = "bar-group";
  const b1 = g.appendChild(document.createElement("div"));
  b1.className = "bar";
  b1.style.cssText = `height:${Math.round(coData[i]/maxV*100)}%;background:#185FA5`;
  b1.title = `Companies: ${coData[i]}`;
  const b2 = g.appendChild(document.createElement("div"));
  b2.className = "bar";
  b2.style.cssText = `height:${Math.round(usData[i]/maxV*100)}%;background:#639922`;
  b2.title = `Users: ${usData[i]}`;
  const lbl = bl.appendChild(document.createElement("div"));
  lbl.className = "bar-lbl"; lbl.textContent = m;
});

// Health bars
const health = [
  {label:"API uptime", val:99, fill:"#185FA5", bg:"#E6F1FB", tc:"#0C447C"},
  {label:"DB response", val:84, fill:"#3B6D11", bg:"#EAF3DE", tc:"#3B6D11"},
  {label:"Error rate",  val:3,  fill:"#A32D2D", bg:"#FCEBEB", tc:"#A32D2D"},
];
const hl = document.getElementById("healthList");
health.forEach(h=>{
  const row = hl.appendChild(document.createElement("div"));
  row.className = "health-row";
  row.innerHTML = `
    <span class="health-lbl">${h.label}</span>
    <div class="h-track"><div class="h-fill" style="width:${h.val}%;background:${h.fill}"></div></div>
    <span class="h-val" style="background:${h.bg};color:${h.tc}">${h.val}%</span>`;
});

// Activity feed
const acts = [
  {color:"#3B6D11", text:"Acme Corp activated by admin", time:"2m ago"},
  {color:"#185FA5", text:"New user invited to Globex Inc", time:"14m ago"},
  {color:"#A32D2D", text:"Umbrella Ltd account suspended", time:"1h ago"},
  {color:"#854F0B", text:"Order #0042 awaiting approval", time:"2h ago"},
  {color:"#185FA5", text:"System backup completed", time:"4h ago"},
  {color:"#3B6D11", text:"Initech LLC onboarding complete", time:"Yesterday"},
];
const al = document.getElementById("actList");
acts.forEach(a=>{
  const item = al.appendChild(document.createElement("div"));
  item.className = "act-item";
  item.innerHTML = `
    <div class="act-dot" style="background:${a.color}"></div>
    <div class="act-text">${a.text}</div>
    <div class="act-time">${a.time}</div>`;
});

// Sidebar toggle
function toggleSidebar(){
  const sb = document.getElementById("sidebar");
  const ov = document.getElementById("overlay");
  const mn = document.getElementById("main");
  const mobile = window.innerWidth <= 640;
  if(mobile){
    sb.classList.toggle("open");
    ov.classList.toggle("show");
  } else {
    sb.classList.toggle("hidden");
    mn.classList.toggle("expanded");
  }
}
function closeSidebar(){
  document.getElementById("sidebar").classList.remove("open");
  document.getElementById("overlay").classList.remove("show");
}
window.addEventListener("resize",()=>{
  if(window.innerWidth > 640){
    document.getElementById("overlay").classList.remove("show");
  }
});

// Nav active state
document.querySelectorAll(".nav-item").forEach(item=>{
  item.addEventListener("click",()=>{
    document.querySelectorAll(".nav-item").forEach(i=>i.classList.remove("active"));
    item.classList.add("active");
  });
});

// Logout Confirmation

function confirmLogout() {
    Swal.fire({
        title: 'Are you sure?',
        text: "You will be logged out!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, logout',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logoutForm').submit();
        }
    });
}
