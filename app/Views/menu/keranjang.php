<!DOCTYPE html>
<html>

<head>
    <link rel="icon" type="image/jpeg" href="<?= base_url('uploads/favicon.jpeg') ?>">
    <link rel="shortcut icon" type="image/jpeg" href="<?= base_url('uploads/favicon.jpeg') ?>">
    <title>Keranjang Teras Caffe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- ============================================================
    CSRF TOKEN UNTUK AJAX
    ============================================================ -->
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="csrf-name" content="<?= csrf_token() ?>">
    
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background: #f6f2eb;
            color: #3b2f2f;
        }
        .header {
            background: #4b2e2e;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }
        .meja-title {
            background: #6f4e37;
            color: white;
            padding: 6px 15px;
            border-radius: 25px;
            font-size: 14px;
        }
        .back {
            text-decoration: none;
            color: #6f4e37;
            font-weight: bold;
            font-size: 14px;
        }
        .card {
            background: white;
            border-radius: 12px;
            padding: 15px;
            margin-top: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
        .flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            flex-wrap: wrap;
        }
        .menu-info {
            flex: 2;
            min-width: 150px;
        }
        .nama {
            font-size: 16px;
            font-weight: 600;
        }
        .level-info {
            font-size: 12px;
            color: #dc3545;
            margin-top: 4px;
        }
        .level-info i { margin-right: 4px; }
        .harga {
            color: #6f4e37;
            font-weight: bold;
            font-size: 14px;
            margin-top: 4px;
        }
        .stok-info {
            font-size: 11px;
            margin-top: 4px;
            color: #6c757d;
        }

        /* LEVEL PEDAS - SELECT LANGSUNG */
        .level-control-cart {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 6px;
            flex-wrap: wrap;
        }
        .level-control-cart label {
            font-size: 12px;
            font-weight: 600;
            color: #555;
        }
        .level-control-cart select {
            padding: 4px 8px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 12px;
            background: white;
            cursor: pointer;
            transition: 0.3s;
        }
        .level-control-cart select:focus {
            outline: none;
            border-color: #6f4e37;
            box-shadow: 0 0 0 3px rgba(111, 78, 55, 0.1);
        }
        .level-control-cart select:hover { border-color: #6f4e37; }
        .level-control-cart .saving {
            font-size: 11px;
            color: #6f4e37;
            animation: fadeInOut 0.8s ease;
        }
        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateY(-5px); }
            30% { opacity: 1; transform: translateY(0); }
            70% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(5px); }
        }

        .qty-box { min-width: 100px; text-align: center; }
        .qty { display: flex; align-items: center; justify-content: center; gap: 8px; }
        .qty-btn {
            width: 30px; height: 30px; border: none; border-radius: 50%;
            font-size: 16px; cursor: pointer; transition: 0.2s;
        }
        .qty-btn:disabled { opacity: 0.5; cursor: not-allowed; }
        .minus { background: #c9a27c; }
        .plus { background: #6f4e37; color: white; }
        .qty-btn:hover:not(:disabled) { transform: scale(1.1); }
        .max-hint { font-size: 9px; color: #999; margin-top: 3px; }
        .hapus {
            background: #c0392b; color: white; border: none;
            padding: 5px 10px; border-radius: 6px;
            cursor: pointer; font-size: 12px; transition: 0.2s;
        }
        .hapus:hover { background: #a93226; transform: scale(1.05); }
        .total-box {
            background: white; border-radius: 12px; padding: 15px;
            margin-top: 15px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
        .total {
            font-size: 18px; font-weight: bold; text-align: center; margin-bottom: 12px;
        }
        .metode-box { margin-bottom: 12px; }
        .metode-box label {
            display: inline-block; margin-right: 15px; margin-top: 5px; font-size: 13px;
        }
        .checkout {
            width: 100%; background: #6f4e37; border: none; padding: 10px;
            border-radius: 25px; color: white; font-size: 14px;
            cursor: pointer; transition: 0.2s;
        }
        .checkout:hover { background: #4b2e2e; }
        .checkout:disabled { background: #ccc; cursor: not-allowed; }
        .warning { color: #dc3545; font-size: 11px; margin-top: 5px; }
        .kosong { text-align: center; margin-top: 50px; font-size: 16px; color: #777; }
        .info-text {
            font-size: 12px; color: #6f4e37; margin-top: 8px; text-align: left;
        }

        .toast-container {
            position: fixed; top: 20px; right: 20px; z-index: 99999;
        }
        .toast {
            padding: 12px 20px; margin-bottom: 10px; border-radius: 8px;
            font-size: 13px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            animation: slideIn 0.3s ease; min-width: 200px; max-width: 400px;
        }
        .toast.success { background: #d4edda; color: #155724; border-left: 4px solid #28a745; }
        .toast.error { background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545; }
        .toast.info { background: #cce5ff; color: #004085; border-left: 4px solid #17a2b8; }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @media (max-width: 600px) {
            .flex { flex-direction: column; align-items: stretch; }
            .qty-box { text-align: left; }
            .qty { justify-content: flex-start; }
            .hapus-box { text-align: right; }
            .top-bar { flex-direction: column; align-items: flex-start; }
            .metode-box label { display: block; margin-right: 0; }
            .level-control-cart { flex-wrap: wrap; }
        }
    </style>
</head>

<body>

    <div class="header">🛒 KERANJANG TERAS CAFFE</div>

    <div class="container">

        <div class="top-bar">
            <span class="meja-title">Meja <?= esc($meja) ?></span>
            <a class="back" href="<?= base_url('/menu?meja=' . $meja) ?>">← Kembali ke Menu</a>
        </div>

        <?php if (!empty($keranjang)): ?>

            <?php 
            $stokValid = true;
            foreach ($keranjang as $k): 
                $maxQty = min($k['stok'], 30);
                $isStokCukup = ($k['qty'] <= $k['stok'] && $k['qty'] <= 30);
                if (!$isStokCukup) $stokValid = false;
            ?>

                <div class="card">
                    <div class="flex">

                        <div class="menu-info">
                            <div class="nama"><?= esc($k['nama_menu']) ?></div>
                            
                            <?php if (($k['ada_level'] ?? 0) == 1): ?>
                                <div class="level-control-cart">
                                    <i class="fa fa-pepper-hot" style="color: #dc3545;"></i>
                                    <label>Level Pedas:</label>
                                    <select class="level-select" data-id="<?= $k['id'] ?>">
                                        <option value="0" <?= ($k['level_pedas'] ?? 0) == 0 ? 'selected' : '' ?>>🌶 Tidak</option>
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <option value="<?= $i ?>" <?= ($k['level_pedas'] ?? 0) == $i ? 'selected' : '' ?>>
                                                Level <?= $i ?> <?= str_repeat('🌶', $i) ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                    <span class="saving" id="saving-<?= $k['id'] ?>" style="display:none;">
                                        <i class="fa fa-spinner fa-spin"></i> Menyimpan...
                                    </span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="harga">Rp <?= number_format($k['harga'], 0, ',', '.') ?></div>
                            <div class="stok-info">Stok: <?= $k['stok'] ?> | Maks: 30</div>

                            <?php if (!$isStokCukup): ?>
                                <div class="warning">⚠️ Stok tidak mencukupi! (Stok: <?= $k['stok'] ?>)</div>
                            <?php endif; ?>
                        </div>

                        <div class="qty-box">
                            <div class="qty">
                                <a href="<?= base_url('/menu/keranjang/kurang/' . $k['id'] . '/' . $meja) ?>">
                                    <button type="button" class="qty-btn minus" <?= $k['qty'] <= 1 ? 'disabled' : '' ?>>-</button>
                                </a>
                                <b><?= $k['qty'] ?></b>
                                <a href="<?= base_url('/menu/keranjang/tambah/' . $k['id'] . '/' . $meja) ?>">
                                    <button type="button" class="qty-btn plus" <?= $k['qty'] >= $maxQty ? 'disabled' : '' ?>>+</button>
                                </a>
                            </div>
                            <div class="max-hint">Maks: <?= $maxQty ?></div>
                        </div>

                        <div class="hapus-box">
                            <a href="<?= base_url('/menu/keranjang/hapus/' . $k['id'] . '/' . $meja) ?>">
                                <button type="button" class="hapus">🗑 Hapus</button>
                            </a>
                        </div>

                    </div>
                </div>

            <?php endforeach; ?>

            <!-- ============================================================
            FORM CHECKOUT - PASTIKAN CSRF FIELD ADA
            ============================================================ -->
            <form action="<?= base_url('/menu/struk') ?>" method="post" id="formCheckout">
                <?= csrf_field() ?>
                <input type="hidden" name="meja" value="<?= $meja ?>">
                <input type="hidden" name="tipe_pembayaran" value="kasir">

                <div class="total-box">
                    <div class="total">Total: Rp <?= number_format($total, 0, ',', '.') ?></div>

                    <div class="metode-box">
                        <b>Metode Pembayaran :</b><br>
                        <label><input type="radio" name="metode_bayar" value="Cash" required>Cash</label>
                        <label><input type="radio" name="metode_bayar" value="QRIS">QRIS</label>
                    </div>

                    <div class="info-text">
                        <i class="fa fa-info-circle"></i> Silakan lakukan pembayaran di kasir
                    </div>

                    <button type="submit" class="checkout" id="btnCheckout" <?= !$stokValid ? 'disabled' : '' ?>>Checkout</button>
                    
                    <?php if (!$stokValid): ?>
                        <div class="warning" style="text-align: center; margin-top: 10px;">⚠️ Ada item yang stoknya tidak mencukupi. Kurangi jumlah pesanan.</div>
                    <?php endif; ?>
                </div>

            </form>

        <?php else: ?>
            <div class="kosong">🛒 Keranjang Masih Kosong</div>
        <?php endif; ?>

    </div>

    <div class="toast-container" id="toastContainer"></div>

    <script>
        // ============================================================
        // TOAST NOTIFICATION
        // ============================================================
        function showToast(type, message) {
            let container = document.getElementById('toastContainer');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toastContainer';
                container.style.cssText = 'position:fixed; top:20px; right:20px; z-index:99999;';
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

        // ============================================================
        // LEVEL PEDAS - UPDATE LANGSUNG SAAT SELECT BERUBAH (AJAX)
        // ============================================================
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil CSRF token dari meta tag
            var csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            var csrfName = document.querySelector('meta[name="csrf-name"]')?.getAttribute('content') || '<?= csrf_token() ?>';
            
            console.log('CSRF Token:', csrfToken);
            console.log('CSRF Name:', csrfName);
            
            var selects = document.querySelectorAll('.level-select');
            console.log('Total level-select ditemukan:', selects.length);
            
            selects.forEach(function(select) {
                select.addEventListener('change', function() {
                    var id = this.dataset.id;
                    var level = this.value;
                    var saving = document.getElementById('saving-' + id);
                    
                    if (!id) {
                        console.error('ID tidak ditemukan pada select');
                        return;
                    }
                    
                    if (saving) {
                        saving.style.display = 'inline';
                    }
                    
                    console.log('Mengirim update - ID:', id, 'Level:', level);
                    
                    var baseUrl = '<?= base_url() ?>';
                    
                    // Kirim data dengan CSRF token
                    var postData = {
                        id: id,
                        level: parseInt(level)
                    };
                    postData[csrfName] = csrfToken;
                    
                    fetch(baseUrl + 'menu/keranjang/update-level-ajax', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(postData)
                    })
                    .then(function(response) {
                        if (!response.ok) {
                            throw new Error('HTTP ' + response.status);
                        }
                        return response.json();
                    })
                    .then(function(data) {
                        if (saving) {
                            saving.style.display = 'none';
                        }
                        
                        console.log('Response:', data);
                        
                        if (data.success) {
                            showToast('success', '✅ Level pedas berhasil diupdate');
                            this.dataset.oldValue = level;
                        } else {
                            showToast('error', '❌ ' + (data.message || 'Gagal update level pedas'));
                            this.value = this.dataset.oldValue || 0;
                        }
                    }.bind(this))
                    .catch(function(error) {
                        console.error('Error:', error);
                        if (saving) {
                            saving.style.display = 'none';
                        }
                        showToast('error', '❌ Terjadi kesalahan: ' + error.message);
                        this.value = this.dataset.oldValue || 0;
                    }.bind(this));
                });
                
                select.addEventListener('focus', function() {
                    this.dataset.oldValue = this.value;
                });
            });
        });

        // ============================================================
        // FLASH MESSAGE
        // ============================================================
        <?php if (session()->getFlashdata('success')): ?>
            showToast('success', '✅ <?= session()->getFlashdata('success') ?>');
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            showToast('error', '❌ <?= session()->getFlashdata('error') ?>');
        <?php endif; ?>
    </script>

</body>
</html>