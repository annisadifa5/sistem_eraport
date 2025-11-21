<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>E-RAPOR | Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

   <!-- Tailwind + Alpine -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    /* ----- Global ----- */

    body {
            font-family: 'Poppins', sans-serif;
            font-size: 15px; 
    }

    :root{
      --bg: #f9fafc;
      --card: #ffffff;
      --muted: #666;
      --primary: #007bff;
      --soft-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: var(--bg);
      color: #333;
      -webkit-font-smoothing:antialiased;
    }
    .container { padding: 30px 60px; max-width: 1200px; margin: 0 auto; }

    /* ----- Header ----- */
    .header {
      display: flex;
      align-items: center;
      border-bottom: 2px solid #eee;
      padding-bottom: 10px;
      margin-bottom: 25px;
    }
    .header h1 {
      font-size: 20px;
      font-weight: 600;
      margin: 0;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .header span {
      font-weight: 500;
      margin-left: 20px;
      color: var(--muted);
    }

    /* ----- Stat Box ----- */
    .stats { display:flex; gap:20px; margin-bottom:30px; }
    .stat-box {
      background: var(--card);
      border-radius: 10px;
      flex: 1;
      padding: 20px;
      text-align: center;
      box-shadow: var(--soft-shadow);
    }
    .stat-box h3 { font-size:14px; color:#777; margin-bottom:5px; }
    .stat-box p { font-size:26px; font-weight:600; color:var(--primary); margin:0; }

    /* ----- Chart + Filter ----- */
    .content { display:flex; gap:30px; align-items:flex-start; }
    .charts { flex:2; display:flex; gap:25px; }
    .chart-box {
      background: var(--card);
      border-radius: 10px;
      flex:1;
      padding:20px;
      box-shadow: var(--soft-shadow);
    }
    .chart-box h4 { margin-bottom:10px; font-size:15px; font-weight:500; }

    /* Filter box */
    .filter-box {
      flex:1;
      background: var(--card);
      border-radius: 10px;
      padding: 20px;
      box-shadow: var(--soft-shadow);
      height: fit-content;
    }
    .filter-box h4 { margin-bottom:15px; font-size:16px; font-weight:600; color:#333; }

    .filter-group { margin-bottom:18px; }
    .filter-group label { display:block; margin-bottom:6px; font-size:14px; color:#444; }
    select, input[type="date"], textarea { width:100%; padding:10px; border-radius:8px; border:1px solid #ccc; font-size:14px; outline:none; }
    .btn-group { display:flex; gap:8px; flex-wrap:wrap; }
    .btn-group button {
      padding:7px 12px; border:1px solid #ccc; border-radius:8px; background:#fff;
      cursor:pointer; font-size:14px; transition:0.15s;
    }
    .btn-group button.active { background:var(--primary); border-color:var(--primary); color:#fff; }
    .apply-btn {
      width:100%; padding:10px; border:none; border-radius:8px; background:var(--primary); color:#fff; font-size:14px; cursor:pointer; margin-top:10px;
    }
    .apply-btn:hover { background:#005fcc; }

    /* ----- Event Section (bawah) ----- */
    .event-section { margin-top:35px; display:flex; gap:25px; align-items:flex-start; }
    .event-card {
      flex:1;
      background:var(--card);
      border-radius:16px;
      padding:20px;
      box-shadow:0 2px 10px rgba(0,0,0,0.05);
      min-height:150px;
    }
    .event-card h4 { margin-bottom:15px; font-size:16px; font-weight:600; color:#333; }
    .event-list { list-style:none; padding:0; margin:0; }
    .event-list li { display:flex; align-items:center; gap:12px; margin-bottom:14px; }
    .event-list li p { margin:0; font-size:14px; font-weight:500; }
    .event-list li small { color:#777; font-size:12px; }

.icon {
  width: 38px;
  height: 38px;
  border-radius: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-shrink: 0;
}

.icon svg {
  width: 20px;
  height: 20px;
  fill: #fff; /* ikon putih */
}

/* Warna pastel */
.blue { background:#6C8CFF; }
.green { background:#4CC9A6; }
.orange { background:#FFBC56; }
.red { background:#FF6F6F; }

    /* ----- Responsive ----- */
    @media (max-width: 980px) {
      .container { padding:20px; }
      .content { flex-direction:column; }
      .charts { flex-direction:column; }
      .event-section { flex-direction:column; }
    }
  </style>
</head>
<div 
  x-data="{
      sidebarOpen: true,
      dataSekolahOpen: false,
      inputNilaiOpen: false,
      modalOpen: false,
      toggleSidebar() {
          this.sidebarOpen = !this.sidebarOpen;
          if (!this.sidebarOpen) {
              this.dataSekolahOpen = false;
              this.inputNilaiOpen = false;
          }
      }
  }"
  class="flex min-h-screen"
>

    <!-- Sidebar -->
    <div :class="sidebarOpen ? 'w-[17rem]' : 'w-20'"
         class="bg-blue-700 text-white transition-all duration-300 flex flex-col justify-between shadow-lg">
        <div>
            <!-- Header -->
            <div :class="sidebarOpen ? 'flex items-center justify-center py-4 border-b border-blue-500' : 'flex items-center justify-center py-4 border-b border-blue-500'"> 
                <template x-if="sidebarOpen"> 
                    <h1 class="text-lg font-semibold">Guru</h1> 
                </template> 
                <button @click="toggleSidebar()" class="text-white focus:outline-none transition-all duration-300" :class="sidebarOpen ? 'ml-3' : 'mx-auto'"> 
                    <i class="fa-solid fa-bars text-2xl"></i> 
                </button> 
            </div>

            <!-- Menu -->
            <nav class="mt-6 space-y-1 font-medium">
                <!-- Beranda -->
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center py-2 hover:bg-blue-800 transition"
                   :class="sidebarOpen ? 'px-4 justify-start' : 'justify-center'">
                    <i class="fa-solid fa-house text-2xl"></i>
                    <span x-show="sidebarOpen" class="ml-3 text-base">Beranda</span>
                </a>

                <!-- Input Nilai -->
                <div>
                    <button @click="inputNilaiOpen = !inputNilaiOpen"
                            class="w-full flex items-center hover:bg-blue-800 transition py-2"
                            :class="sidebarOpen ? 'px-4 justify-between' : 'justify-center'">
                        <div class="flex items-center space-x-3">
                            <i class="fa-solid fa-pen-to-square text-2xl"></i>
                            <span x-show="sidebarOpen">Input Nilai</span>
                        </div>
                        <i x-show="sidebarOpen" 
                           :class="{'rotate-90': inputNilaiOpen}"
                           class="fa-solid fa-chevron-right text-xs transition-transform"></i>
                    </button>

                    <div x-show="inputNilaiOpen" x-transition class="pl-10 bg-blue-600/40 text-sm">
                    <a href="{{ route('input.tugas') }}" 
                       class="block py-2 flex items-center space-x-2 transition 
                            {{ request()->routeIs('input.tugas') ? 'bg-blue-700/70 rounded-l-md' : 'hover:bg-blue-700' }}">
                        <i class="fa-solid fa-users text-xs"></i><span>Tugas</span>
                    </a>
                    <a href="{{ route('input.ulangan') }}" 
                       class="block py-2 flex items-center space-x-2 transition 
                            {{ request()->routeIs('input.ulangan') ? 'bg-blue-700/70 rounded-l-md' : 'hover:bg-blue-700' }}">
                        <i class="fa-solid fa-users text-xs"></i><span>Ulangan Harian</span>
                    </a>
                    <a href="{{ route('input.sts') }}" 
                       class="block py-2 flex items-center space-x-2 transition 
                            {{ request()->routeIs('input.sts') ? 'bg-blue-700/70 rounded-l-md' : 'hover:bg-blue-700' }}">
                        <i class="fa-solid fa-users text-xs"></i><span>STS</span>
                    </a>
                    <a href="{{ route('input.sas') }}" 
                       class="block py-2 flex items-center space-x-2 transition 
                            {{ request()->routeIs('input.sas') ? 'bg-blue-700/70 rounded-l-md' : 'hover:bg-blue-700' }}">
                        <i class="fa-solid fa-users text-xs"></i><span>SAS</span>
                    </a>
                    <a href="{{ route('input.sat') }}" 
                       class="block py-2 flex items-center space-x-2 transition 
                            {{ request()->routeIs('input.sat') ? 'bg-blue-700/70 rounded-l-md' : 'hover:bg-blue-700' }}">
                        <i class="fa-solid fa-users text-xs"></i><span>SAT</span>
                    </a>
                </div>
                </div>

            </nav>
        </div>

       <!-- Logout -->
        <div class="px-4 py-3 border-t border-blue-500">
            <a href="{{ route('logout') }}" class="flex items-center space-x-2 hover:text-gray-200 transition">
                <i class="fa-solid fa-right-from-bracket text-xl"></i>
                <span x-show="sidebarOpen">Keluar</span>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="GET" class="hidden">
                @csrf
            </form>
        </div>
    </div>
<body>
  <div class="container">
    <!-- HEADER -->
    <div class="header">
      <h1>Beranda</h1>
      <span>Semester Genap 2025/2026</span>
    </div>

    <!-- STAT -->
    <div class="stats">
      <div class="stat-box">
        <h3>Guru</h3>
        <p>47</p>
      </div>
      <div class="stat-box">
        <h3>Siswa</h3>
        <p>365</p>
      </div>
    </div>

    <!-- CHART + FILTER -->
    <div class="content">
      <div class="charts">
        <div class="chart-box">
          <h3>Perkembangan Nilai</h3>
          <canvas id="lineChart"></canvas>
        </div>
        <div class="chart-box">
          <h3>Statistik Nilai</h3>
          <canvas id="donutChart"></canvas>
        </div>
      </div>

      <!-- FILTER -->
      <div class="filter-box">
        <h3>Filter</h3>

        <div class="filter-group">
          <label for="bidang">Bidang Minat</label>
          <select id="bidang">
            <option disabled selected>Pilih Bidang Minat</option>
            <option>AKL</option>
            <option>MPLB</option>
            <option>BDP</option>
            <option>KUL</option>
            <option>TB</option>
            <option>TKS</option>
          </select>
        </div>

        <div class="filter-group">
          <label>Kelas</label>
          <div class="btn-group" id="kelas">
            <button type="button">X</button>
            <button type="button">XI</button>
            <button type="button">XII</button>
          </div>
        </div>

        <div class="filter-group">
          <label>Angkatan</label>
          <div class="btn-group" id="angkatan">
            <button type="button">2023</button>
            <button type="button">2024</button>
            <button type="button">2025</button>
          </div>
        </div>

        <div class="filter-group">
          <label>Semester</label>
          <div class="btn-group" id="semester">
            <button type="button">Ganjil</button>
            <button type="button">Genap</button>
          </div>
        </div>

        <button class="apply-btn" onclick="terapkanFilter()">Terapkan</button>
      </div>
    </div>

    <!-- EVENT & NOTIF SECTION (paste sebelum penutup container) -->
    <div class="event-section">
      <!-- Upcoming -->
      <div class="event-card">
        <h4>Upcoming Event</h4>
        <ul class="event-list" id="upcoming-list">

  <li>
    <span class="icon blue">
      <svg viewBox="0 0 24 24"><path d="M6 4v16c0 .6.4 1 1 1h13v-2H8V4H6zm3-1h11c.6 0 1 .4 1 1v14c0 .6-.4 1-1 1H9c-.6 0-1-.4-1-1V4c0-.6.4-1 1-1z"/></svg>
    </span>
    <div><p>Sumatif Tengah Semester</p><small>05 Maret 2025</small></div>
  </li>

  <li>
    <span class="icon orange">
      <svg viewBox="0 0 24 24"><path d="M6 2h9l5 5v15H6V2zm9 1.5V8h4.5L15 3.5z"/></svg>
    </span>
    <div><p>Sumatif Akhir Semester</p><small>02 Juni 2025</small></div>
  </li>

  <li>
    <span class="icon green">
      <svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z"/></svg>
    </span>
    <div><p>Pengisian Nilai Rapor</p><small>16 Juni 2025</small></div>
  </li>

  <li>
    <span class="icon red">
      <svg viewBox="0 0 24 24"><path d="M19 3H5v18l7-3 7 3V3z"/></svg>
    </span>
    <div><p>Rapor Kenaikan Kelas</p><small>20 Juni 2025</small></div>
  </li>

</ul>

      </div>

      <!-- Notifikasi -->
      <div class="event-card">
        <h4>Notifikasi</h4>
        <ul class="event-list" id="notif-list">

  <li>
    <span class="icon red">
      <svg viewBox="0 0 24 24"><path d="M12 1a11 11 0 100 22 11 11 0 000-22zm1 11h5v2h-7V6h2v6z"/></svg>
    </span>
    <div><p>Batas akhir entri nilai harian</p><small>10 Maret</small></div>
  </li>

  <li>
    <span class="icon orange">
      <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19l12-12-1.41-1.41z"/></svg>
    </span>
    <div><p>Pengisian nilai STS dibuka</p><small>17 Maret 2025</small></div>
  </li>

  <li>
    <span class="icon blue">
      <svg viewBox="0 0 24 24"><path d="M3 3h18v2H3zm0 7h18v2H3zm0 7h18v2H3z"/></svg>
    </span>
    <div><p>Jadwal rapor semester genap</p><small>20 Juni 2025</small></div>
  </li>

  <li>
    <span class="icon green">
      <svg viewBox="0 0 24 24"><path d="M19 3H5v18h14V3zM8 9h8v2H8V9zm0 4h8v2H8v-2z"/></svg>
    </span>
    <div><p>Rapor digital siap diunduh</p><small>18 Juni 2025</small></div>
  </li>

</ul>

      </div>

      <!-- Form Input -->
      <div class="event-card">
        <h4>Form Input</h4>
        <textarea id="ev-desc" placeholder="Deskripsi ..." class="input-box" rows="3"></textarea>
        <input id="ev-date" type="date" class="input-box">
        <select id="ev-category" class="input-box">
          <option selected disabled>Kategori</option>
          <option value="upcoming">Upcoming Event</option>
          <option value="notif">Notifikasi</option>
        </select>
        <button id="add-event-btn" class="apply-btn">Tambah Event</button>
      </div>
    </div>
  </div>

  <script>
    /* ===== Button active for filter groups ===== */
    document.querySelectorAll('.btn-group').forEach(group => {
      group.querySelectorAll('button').forEach(btn => {
        btn.addEventListener('click', () => {
          group.querySelectorAll('button').forEach(i => i.classList.remove('active'));
          btn.classList.add('active');
        });
      });
    });

    function terapkanFilter() {
      const bidang = document.getElementById('bidang').value || '-';
      const kelas = document.querySelector('#kelas .active')?.textContent || '-';
      const angkatan = document.querySelector('#angkatan .active')?.textContent || '-';
      const semester = document.querySelector('#semester .active')?.textContent || '-';
      console.log(Filter Digunakan: Bidang: ${bidang}, Kelas: ${kelas}, Angkatan: ${angkatan}, Semester: ${semester});
      alert(Filter diterapkan:\nBidang: ${bidang}\nKelas: ${kelas}\nAngkatan: ${angkatan}\nSemester: ${semester});
    }

    /* ===== Charts ===== */
    // Line chart
    new Chart(document.getElementById('lineChart'), {
      type:'line',
      data:{
        labels:['Sem 1','Sem 2','Sem 3','Sem 4','Sem 5','Sem 6'],
        datasets:[{
          label:'Perkembangan Nilai',
          data:[60,78,85,88,92,97],
          borderColor:'#007bff',
          backgroundColor:'rgba(0,123,255,0.08)',
          tension:0.35,
          fill:true,
          pointRadius:4,
          pointBackgroundColor:'#007bff'
        }]
      },
      options:{
        responsive:true,
        plugins:{ legend:{ display:false } },
        scales:{ y:{ beginAtZero:true, ticks:{ stepSize:20 } } }
      }
    });

    // Donut (doughnut) chart — warna & tipis (cutout)
    new Chart(document.getElementById('donutChart'), {
      type:'doughnut',
      data:{
        labels:['>90','80-89','70-79','<69'],
        datasets:[{
          data:[40,30,20,10],
          backgroundColor:['#6186CC','#55C4AE','#FFAE4C','#FF928A'],
          borderWidth:0
        }]
      },
      options:{
        responsive:true,
        cutout: '65%', // <--- semakin besar => ring semakin tipis
        plugins:{ legend:{ position:'bottom' } }
      }
    });

    /* ===== Add Event (client-side only) ===== */
    const addBtn = document.getElementById('add-event-btn');
    addBtn.addEventListener('click', () => {
      const desc = document.getElementById('ev-desc').value.trim();
      const date = document.getElementById('ev-date').value;
      const cat = document.getElementById('ev-category').value;

      if (!desc) { alert('Isi deskripsi event.'); return; }
      if (!date) { alert('Pilih tanggal event.'); return; }
      if (!cat) { alert('Pilih kategori event.'); return; }

      // create list item
      const li = document.createElement('li');
      const icon = document.createElement('span');
      icon.classList.add('icon');

      const inner = document.createElement('div');
      const p = document.createElement('p');
      p.textContent = desc;
      const s = document.createElement('small');
      // format tanggal dd MMMM YYYY (simple)
      const d = new Date(date);
      const opsi = { day:'2-digit', month:'long', year:'numeric' };
      s.textContent = d.toLocaleDateString('id-ID', opsi);

      inner.appendChild(p);
      inner.appendChild(s);

      if (cat === 'upcoming') {
        icon.classList.add('blue');
        icon.textContent = '📘';
        li.appendChild(icon);
        li.appendChild(inner);
        document.getElementById('upcoming-list').prepend(li);
      } else {
        icon.classList.add('orange');
        icon.textContent = '🔔';
        li.appendChild(icon);
        li.appendChild(inner);
        document.getElementById('notif-list').prepend(li);
      }

      // clear form
      document.getElementById('ev-desc').value = '';
      document.getElementById('ev-date').value = '';
      document.getElementById('ev-category').selectedIndex = 0;
      // feedback
      alert('Event berhasil ditambahkan (sementara di sisi client).');
    });
  </script>
</body>
</html>