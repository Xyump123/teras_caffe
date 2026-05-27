<!DOCTYPE html>
<html>
<head>
    <link rel="icon" type="image/jpeg" href="<?= base_url('uploads/favicon.jpeg') ?>">
    <title>Menu Teras Caffe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: "Georgia", serif;
            margin: 0;
            background: #f3efe7;
            color: #3b2f2f;
        }
        .header {
            background: #4b2e2e;
            color: #fff;
            text-align: center;
            padding: 25px;
            font-size: 28px;
            letter-spacing: 2px;
            font-weight: bold;
            animation: fadeDown 0.8s ease;
        }
        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }
        .meja-info {
            background: #6f4e37;
            color: white;
            padding: 6px 15px;
            border-radius: 25px;
            font-size: 14px;
            display: inline-block;
        }
        @media (max-width: 768px) {
            .top-bar { flex-direction: column; align-items: flex-start; }
        }
        .container {
            max-width: 1500px;
            margin: auto;
            padding: 40px 80px;
        }
        .keranjang-btn {
            background: #6f4e37;
            margin-bottom: 30px;
            padding: 12px 20px;
            border: none;
            color: white;
            border-radius: 25px;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .keranjang-btn:hover { transform: scale(1.05); }
        .kategori-title {
            font-size: 22px;
            margin: 40px 0 20px;
            border-left: 6px solid #6f4e37;
            padding-left: 10px;
            animation: fadeUp 0.6s ease;
        }
        .menu-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }
        .card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5d3b3;
            transition: 0.3s;
            opacity: 0;
            transform: translateY(20px) scale(0.95);
            animation: fadeUp 0.6s ease forwards;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .card:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }
        .card img {
            width: 100%;
            height: 190px;
            object-fit: cover;
            transition: 0.4s;
        }
        .card:hover img { transform: scale(1.1); }
        .card-body {
            padding: 15px;
            text-align: center;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .menu-info {
            flex-grow: 1;
        }
        .nama-menu { font-size: 18px; font-weight: bold; }
        .harga {
            color: #6f4e37;
            font-weight: bold;
            margin: 10px 0;
        }
        
        /* LEVEL PEDAS STYLE */
        .level-control {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin: 10px 0;
        }
        .level-btn {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: none;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }
        .level-btn.minus {
            background: #dc3545;
            color: white;
        }
        .level-btn.plus {
            background: #28a745;
            color: white;
        }
        .level-btn:hover {
            transform: scale(1.1);
        }
        .level-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }
        .level-value {
            font-size: 14px;
            font-weight: bold;
            min-width: 60px;
            text-align: center;
        }
        .level-value i {
            color: #dc3545;
            margin-right: 4px;
        }
        
        .btn-pesan {
            background: #a67c52;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 20px;
            color: white;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }
        .btn-pesan:hover {
            background: #6f4e37;
            transform: scale(1.02);
        }
        .stok-habis {
            background: #dc3545;
            color: white;
            padding: 8px;
            border-radius: 20px;
            font-size: 12px;
            margin-top: 10px;
        }
        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        @media (max-width:600px) {
            .container { padding: 15px; }
            .menu-container { grid-template-columns: repeat(2, 1fr); }
            .card img { height: 110px; }
        }
    </style>
</head>
<body>
    <div class="header">TERAS CAFFE ☕</div>
    <div class="container">
        <?php if ($meja): ?>
         <div class="top-bar">
            <span class="meja-info">Meja <?= $meja ?></span>
             <a href="<?= base_url('/menu/keranjang?meja=' . $meja) ?>">
                <button class="keranjang-btn">🛒 Lihat Keranjang</button>
            </a>
         </div>
        <?php endif; ?>
        
        <?php
        $kategori = [];
        foreach ($menu as $m) {
            $kategori[$m['kategori']][] = $m;
        }
        ?>
        
        <?php $delay = 0; ?>
        <?php foreach ($kategori as $nama_kategori => $menus): ?>
            <h2 class="kategori-title"><?= $nama_kategori ?></h2>
            <div class="menu-container">
                <?php foreach ($menus as $m): $delay += 0.1; ?>
                    <div class="card" style="animation-delay: <?= $delay ?>s;">
                        <img src="<?= !empty($m['gambar']) ? base_url('uploads/' . $m['gambar']) : base_url('uploads/default.jpg') ?>"
                             onerror="this.src='<?= base_url('uploads/default.jpg') ?>'">
                        <div class="card-body">
                            <div class="menu-info">
                                <div class="nama-menu"><?= $m['nama_menu'] ?></div>
                                <div class="harga">Rp <?= number_format($m['harga'], 0, ',', '.') ?></div>
                                
                                <?php if ($m['stok'] > 0 && $m['ada_level'] == 1): ?>
                                    <!-- LEVEL PEDAS CONTROL (hanya untuk menu yang memiliki level) -->
                                    <div class="level-control">
                                        <button type="button" class="level-btn minus" onclick="changeLevel(this, -1)">-</button>
                                        <div class="level-value" id="level-<?= $m['id'] ?>">
                                            <i class="fas fa-pepper-hot"></i> <span id="level-val-<?= $m['id'] ?>">0</span>
                                        </div>
                                        <button type="button" class="level-btn plus" onclick="changeLevel(this, 1)">+</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($m['stok'] > 0): ?>
                                <form action="<?= base_url('/menu/tambah') ?>" method="post" class="order-form" data-menu-id="<?= $m['id'] ?>">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id_menu" value="<?= $m['id'] ?>">
                                    <input type="hidden" name="meja" value="<?= $meja ?>">
                                    <input type="hidden" name="level_pedas" id="level-input-<?= $m['id'] ?>" value="0">
                                    <button class="btn-pesan" type="submit">Pesan Menu</button>
                                </form>
                            <?php else: ?>
                                <div class="stok-habis">Stok Habis</div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        function changeLevel(btn, delta) {
            const menuCard = btn.closest('.card');
            const menuId = menuCard.querySelector('.order-form')?.dataset.menuId;
            
            if (!menuId) return;
            
            const levelSpan = document.getElementById(`level-val-${menuId}`);
            const levelInput = document.getElementById(`level-input-${menuId}`);
            
            let currentLevel = parseInt(levelSpan.innerText) || 0;
            let newLevel = currentLevel + delta;
            
            if (newLevel < 0) newLevel = 0;
            if (newLevel > 5) newLevel = 5;
            
            levelSpan.innerText = newLevel;
            levelInput.value = newLevel;
            
            const levelIcon = document.querySelector(`#level-${menuId} i`);
            if (levelIcon) {
                if (newLevel === 0) {
                    levelIcon.style.color = '#6c757d';
                } else if (newLevel <= 2) {
                    levelIcon.style.color = '#28a745';
                } else if (newLevel <= 4) {
                    levelIcon.style.color = '#fd7e14';
                } else {
                    levelIcon.style.color = '#dc3545';
                }
            }
            
            const minusBtn = btn.parentElement.querySelector('.level-btn.minus');
            const plusBtn = btn.parentElement.querySelector('.level-btn.plus');
            if (minusBtn) minusBtn.disabled = (newLevel <= 0);
            if (plusBtn) plusBtn.disabled = (newLevel >= 5);
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.level-control').forEach(control => {
                const minusBtn = control.querySelector('.level-btn.minus');
                const plusBtn = control.querySelector('.level-btn.plus');
                if (minusBtn) minusBtn.disabled = true;
                if (plusBtn) plusBtn.disabled = false;
            });
        });
    </script>
</body>
</html>