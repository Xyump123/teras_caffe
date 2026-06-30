<!DOCTYPE html>
<html>

<head>
    <title><?= $title ?? 'Admin Panel' ?> - Teras Caffe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    
    <!-- CSRF Token untuk AJAX -->
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="csrf-name" content="<?= csrf_token() ?>">
    
    <link rel="icon" type="image/jpeg" href="<?= base_url('uploads/favicon.jpeg') ?>">
    <link rel="shortcut icon" type="image/jpeg" href="<?= base_url('uploads/favicon.jpeg') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "Poppins", "Segoe UI", sans-serif;
            background: #f5f1ea;
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: #3b2a21;
            color: white;
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }
        .sidebar h2 {
            text-align: center;
            padding: 28px 15px;
            margin: 0;
            font-weight: 600;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar a {
            color: #e9e1d7;
            padding: 16px 25px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 15px;
            transition: all .25s;
        }
        .sidebar a:hover {
            background: #5a3c2e;
            padding-left: 32px;
        }
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .header {
            background: white;
            padding: 18px 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            flex-wrap: wrap;
            gap: 10px;
        }
        .header h3 { margin: 0; font-weight: 600; color: #3b2a21; }
        .notification-bell {
            position: relative;
            cursor: pointer;
            margin-right: 15px;
        }
        .notification-bell i { font-size: 22px; color: #8B6914; }
        .notification-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 10px;
            font-weight: bold;
            display: none;
            min-width: 18px;
            text-align: center;
        }
        .notification-dropdown {
            position: absolute;
            top: 55px;
            right: 20px;
            width: 340px;
            max-width: 90vw;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            z-index: 100000;
            display: none;
            max-height: 500px;
            overflow: hidden;
        }
        .notification-header {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            font-weight: 600;
            background: #f8f9fa;
        }
        .notification-list { max-height: 400px; overflow-y: auto; }
        .notification-item {
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
        }
        .notification-item:hover { background: #f9f9f9; }
        .notification-item strong { color: #8B6914; }
        .notification-empty {
            padding: 20px;
            text-align: center;
            color: #999;
        }
        .user-area {
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
            z-index: 9999;
        }
        .dropdown-profile {
            position: absolute;
            right: 0;
            top: 55px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            min-width: 160px;
            overflow: hidden;
            z-index: 100000;
            display: none;
        }
        .dropdown-profile a {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            font-size: 14px;
        }
        .dropdown-profile a:hover { background: #f5f5f5; }
        .dropdown-profile a:last-child { color: #dc3545; border-top: 1px solid #eee; }
        .content { flex: 1; padding: 35px; }
        .container-fix { max-width: 1200px; margin: auto; }
        .footer {
            background: white;
            padding: 15px;
            text-align: center;
            border-top: 1px solid #eee;
            font-size: 13px;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.3); }
            100% { transform: scale(1); }
        }
        .pulse { animation: pulse 0.5s ease; }
        
        .toast-container {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 99999;
        }
        .toast {
            padding: 12px 20px;
            margin-bottom: 10px;
            border-radius: 8px;
            font-size: 13px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            animation: slideIn 0.3s ease;
            min-width: 200px;
            max-width: 400px;
        }
        .toast.success { background: #d4edda; color: #155724; border-left: 4px solid #28a745; }
        .toast.error { background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545; }
        .toast.info { background: #cce5ff; color: #004085; border-left: 4px solid #17a2b8; }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @media (max-width: 768px) {
            .sidebar { width: 200px; }
            .header { padding: 15px; }
            .content { padding: 15px; }
            .notification-dropdown { right: 10px; width: 300px; }
        }
        @media (max-width: 576px) {
            .sidebar { display: none; }
            .header h3 { font-size: 16px; }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2><i class="fa fa-mug-hot"></i> Teras Caffe</h2>
        <a href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-chart-line"></i> Dashboard</a>
        <a href="<?= base_url('admin/menu') ?>"><i class="fa fa-utensils"></i> Manage Menu</a>
        <a href="<?= base_url('admin/transaksi') ?>"><i class="fa fa-receipt"></i> Transaksi</a>
        <a href="<?= base_url('admin/laporan') ?>"><i class="fa fa-file-invoice-dollar"></i> Laporan</a>
        <a href="<?= base_url('admin/qr-generator') ?>"><i class="fa fa-qrcode"></i> QR Generator</a>
    </div>

    <div class="main">
        <div class="header">
            <h3><?= $title ?? '' ?></h3>
            <div class="user-area">
                <div class="notification-bell" id="notificationBell">
                    <i class="fa fa-bell"></i>
                    <span class="notification-count" id="notificationCount">0</span>
                </div>
                <div class="notification-dropdown" id="notificationDropdown">
                    <div class="notification-header"><i class="fa fa-bell"></i> Notifikasi Pesanan</div>
                    <div class="notification-list" id="notificationList">
                        <div class="notification-empty">Memuat notifikasi...</div>
                    </div>
                </div>
                <div style="text-align:right;">
                    <strong><?= session('nama') ?? session('username') ?></strong><br>
                    <small><?= session('role') ?></small>
                </div>
                <div>
                    <img src="<?= session('foto') ? base_url('uploads/' . session('foto')) : 'https://ui-avatars.com/api/?name=' . (session('nama') ?? session('username')) ?>"
                        style="width:40px; height:40px; border-radius:50%; cursor:pointer; object-fit:cover;"
                        onclick="toggleDropdown()">
                    <div id="dropdownProfile" class="dropdown-profile">
                        <a href="<?= base_url('admin/profile') ?>"><i class="fa fa-user"></i> Profile</a>
                        <a href="<?= base_url('admin/logout') ?>"><i class="fa fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fix">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
        <div class="footer">© <?= date('Y') ?> Teras Caffe - Admin Panel</div>
    </div>

    <div class="toast-container" id="toastContainer"></div>

    <script>
        function toggleDropdown() {
            let dropdown = document.getElementById("dropdownProfile");
            dropdown.style.display = dropdown.style.display === "none" ? "block" : "none";
        }

        document.addEventListener('click', function(event) {
            let dropdown = document.getElementById("dropdownProfile");
            let img = document.querySelector('.user-area img');
            if (dropdown && img && !img.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.style.display = "none";
            }
            let notifDropdown = document.getElementById('notificationDropdown');
            let bell = document.getElementById('notificationBell');
            if (notifDropdown && bell && !bell.contains(event.target) && !notifDropdown.contains(event.target)) {
                notifDropdown.style.display = "none";
            }
        });

        function showToast(type, message) {
            let container = document.getElementById('toastContainer');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toastContainer';
                container.style.cssText = 'position:fixed; top:80px; right:20px; z-index:99999;';
                document.body.appendChild(container);
            }

            const toast = document.createElement('div');
            const colors = {
                success: 'background: #d4edda; color: #155724; border-left: 4px solid #28a745;',
                error: 'background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545;',
                info: 'background: #cce5ff; color: #004085; border-left: 4px solid #17a2b8;'
            };

            toast.style.cssText = `
                padding: 12px 20px;
                margin-bottom: 10px;
                border-radius: 8px;
                font-size: 13px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                animation: slideIn 0.3s ease;
                min-width: 200px;
                max-width: 400px;
                ${colors[type] || colors.info}
            `;
            toast.innerHTML = message;

            container.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(50px)';
                toast.style.transition = 'all 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        let lastNotifiedIds = JSON.parse(localStorage.getItem('teras_notified_ids') || '[]');
        let isFirstLoad = true;
        let audioContext = null;

        function playBeep() {
            try {
                const audioUrl = '<?= base_url("sounds/notification.mp3") ?>';
                let audio = new Audio(audioUrl);
                audio.volume = 0.7;
                audio.play().catch(function(e) {
                    playBeepFallback();
                });
            } catch(e) {
                playBeepFallback();
            }
        }

        function playBeepFallback() {
            try {
                if (!audioContext) {
                    audioContext = new (window.AudioContext || window.webkitAudioContext)();
                }
                const notes = [800, 1000, 800];
                notes.forEach((freq, index) => {
                    setTimeout(() => {
                        try {
                            const oscillator = audioContext.createOscillator();
                            const gainNode = audioContext.createGain();
                            oscillator.connect(gainNode);
                            gainNode.connect(audioContext.destination);
                            oscillator.frequency.value = freq;
                            oscillator.type = 'sine';
                            gainNode.gain.setValueAtTime(0.15, audioContext.currentTime);
                            oscillator.start(audioContext.currentTime);
                            oscillator.stop(audioContext.currentTime + 0.12);
                        } catch(e) {}
                    }, index * 150);
                });
            } catch(e) {}
        }

        function cekPesananBaru() {
            const timestamp = new Date().getTime();
            const baseUrl = '<?= base_url() ?>';
            
            fetch(baseUrl + 'admin/transaksi/cek-pesanan-baru?_=' + timestamp, {
                method: 'GET',
                headers: { 
                    'X-Requested-With': 'XMLHttpRequest',
                    'Cache-Control': 'no-cache, no-store, must-revalidate',
                    'Pragma': 'no-cache'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('HTTP ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const count = data.total_baru;
                    const notificationCount = document.getElementById('notificationCount');
                    const notificationList = document.getElementById('notificationList');

                    if (count > 0) {
                        notificationCount.innerText = count;
                        notificationCount.style.display = 'inline-block';

                        const bell = document.querySelector('.notification-bell i');
                        bell.classList.add('pulse');
                        setTimeout(() => bell.classList.remove('pulse'), 500);

                        let html = '';
                        let hasNew = false;

                        data.pesanan.forEach(p => {
                            if (!lastNotifiedIds.includes(p.id)) {
                                hasNew = true;
                                lastNotifiedIds.push(p.id);
                                localStorage.setItem('teras_notified_ids', JSON.stringify(lastNotifiedIds));
                            }

                            const statusLabel = p.status === 'pending' ? 'Menunggu Bayar' : 'Menunggu Konfirmasi';
                            const statusClass = p.status === 'pending' ? 'pending' : 'menunggu_konfirmasi';

                            html += `<div class="notification-item" onclick="window.location.href='<?= base_url('admin/transaksi/detail') ?>/${p.id}'">
                                <strong>#${p.id}</strong> - Meja ${p.meja}<br>
                                <small>Total: Rp ${Number(p.total).toLocaleString('id-ID')}</small><br>
                                <small><span class="badge ${statusClass}">${statusLabel}</span></small>
                                <small> - ${p.total_item} item</small>
                            </div>`;
                        });

                        if (html) {
                            notificationList.innerHTML = html;
                        }

                        if (hasNew && !isFirstLoad) {
                            playBeep();
                            showToast('info', '🔔 Ada pesanan baru!');
                            console.log('🔔 Ada pesanan baru!');
                        }
                    } else {
                        notificationCount.style.display = 'none';
                        if (isFirstLoad) {
                            notificationList.innerHTML = '<div class="notification-empty">Tidak ada pesanan baru</div>';
                        }
                    }
                }
            }).catch(error => {
                console.error('❌ Error checking notifications:', error);
                const notificationList = document.getElementById('notificationList');
                if (notificationList) {
                    notificationList.innerHTML = '<div class="notification-empty" style="color:red;">⚠️ Gagal terhubung ke server</div>';
                }
            });
        }

        document.getElementById('notificationBell').addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = document.getElementById('notificationDropdown');
            if (dropdown.style.display === 'none' || dropdown.style.display === '') {
                dropdown.style.display = 'block';
                cekPesananBaru();
            } else {
                dropdown.style.display = 'none';
            }
        });

        setTimeout(function() {
            isFirstLoad = false;
            cekPesananBaru();
            setInterval(cekPesananBaru, 5000);
        }, 3000);

        document.addEventListener('visibilitychange', function() {
            if (!document.hidden && !isFirstLoad) {
                cekPesananBaru();
            }
        });

        const style = document.createElement('style');
        style.textContent = `
            .badge.pending { background: #fff3cd; color: #856404; padding: 2px 8px; border-radius: 4px; font-size: 11px; }
            .badge.menunggu_konfirmasi { background: #cce5ff; color: #004085; padding: 2px 8px; border-radius: 4px; font-size: 11px; }
        `;
        document.head.appendChild(style);

        console.log('✅ Notification system initialized');
        console.log('🔊 Sound file path:', '<?= base_url("sounds/notification.mp3") ?>');
        console.log('🔔 Checking for new orders every 5 seconds...');
    </script>
</body>
</html>