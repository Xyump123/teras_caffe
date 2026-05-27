<!DOCTYPE html>
<html>

<head>
    <title><?= $title ?? 'Admin Panel' ?> - Teras Caffe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        }
        .header {
            background: white;
            padding: 18px 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
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
            width: 320px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            z-index: 100000;
            display: none;
        }
        .notification-header {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            font-weight: 600;
        }
        .notification-list { max-height: 350px; overflow-y: auto; }
        .notification-item {
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
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
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        .pulse { animation: pulse 0.5s ease; }
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
                        <div class="notification-empty">Tidak ada pesanan baru</div>
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

        // ==================== NOTIFICATION SYSTEM ====================
        // Gunakan sessionStorage untuk menyimpan ID pesanan yang sudah diberi notifikasi suara
        let lastNotifiedIds = JSON.parse(sessionStorage.getItem('notified_ids') || '[]');

        // ========== SUARA NOTIFIKASI (MP3 DARI FOLDER public/sounds/) ==========
        function playBeep() {
            let audio = new Audio('<?= base_url("sounds/notification.mp3") ?>');
            audio.volume = 0.5;
            audio.currentTime = 0;
            audio.play().catch(e => console.log('Audio error:', e));
        }

        function cekPesananBaru() {
            fetch('<?= base_url("admin/transaksi/cek-pesanan-baru") ?>', {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
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
                            // Cek apakah pesanan ini sudah pernah diberi notifikasi suara
                            if (!lastNotifiedIds.includes(p.id)) {
                                hasNew = true;
                                lastNotifiedIds.push(p.id);
                            }
                            html += `<div class="notification-item">
                                <strong>#${p.id}</strong> - Meja ${p.meja}<br>
                                <small>Total: Rp ${Number(p.total).toLocaleString('id-ID')}</small><br>
                                <small>Status: ${p.status === 'pending' ? 'Menunggu Bayar' : 'Menunggu Konfirmasi'}</small>
                                <small> - ${p.total_item} item</small><br>
                                <a href="<?= base_url('admin/transaksi/detail') ?>/${p.id}" style="color: #8B6914;">Lihat Detail →</a>
                            </div>`;
                        });
                        notificationList.innerHTML = html;
                        
                        // Simpan ID yang sudah dinotifikasi ke sessionStorage
                        sessionStorage.setItem('notified_ids', JSON.stringify(lastNotifiedIds));
                        
                        // Mainkan suara HANYA JIKA ada pesanan baru (belum pernah dinotifikasi)
                        if (hasNew) {
                            playBeep();
                            console.log('🔔 Ada pesanan baru!');
                        }
                    } else {
                        notificationCount.style.display = 'none';
                        notificationList.innerHTML = '<div class="notification-empty">Tidak ada pesanan baru</div>';
                    }
                }
            }).catch(error => console.error('Error:', error));
        }

        document.getElementById('notificationBell').addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = document.getElementById('notificationDropdown');
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        });

        // Cek pesanan setiap 3 detik (TIDAK dipanggil saat load untuk menghindari suara tidak perlu)
        setInterval(cekPesananBaru, 3000);
        
        // Hapus atau comment baris di bawah agar suara tidak muncul saat halaman pertama dimuat
        // cekPesananBaru();  // ← TIDAK DIPANGGIL SAAT LOAD
    </script>
</body>
</html>