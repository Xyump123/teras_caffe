<!DOCTYPE html>
<html>

<head>
    <link rel="icon" type="image/jpeg" href="<?= base_url('uploads/favicon.jpeg') ?>">
    <link rel="shortcut icon" type="image/jpeg" href="<?= base_url('uploads/favicon.jpeg') ?>">
    <title>Keranjang Teras Caffe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
        }

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

        .level-info i {
            margin-right: 4px;
        }

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

        .qty-box {
            min-width: 100px;
            text-align: center;
        }

        .qty {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .qty-btn {
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 50%;
            font-size: 16px;
            cursor: pointer;
            transition: 0.2s;
        }

        .qty-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .minus {
            background: #c9a27c;
        }

        .plus {
            background: #6f4e37;
            color: white;
        }

        .max-hint {
            font-size: 9px;
            color: #999;
            margin-top: 3px;
        }

        .hapus {
            background: #c0392b;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
        }

        .total-box {
            background: white;
            border-radius: 12px;
            padding: 15px;
            margin-top: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .total {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 12px;
        }

        .metode-box {
            margin-bottom: 12px;
        }

        .metode-box label {
            display: inline-block;
            margin-right: 15px;
            margin-top: 5px;
            font-size: 13px;
        }

        .checkout {
            width: 100%;
            background: #6f4e37;
            border: none;
            padding: 10px;
            border-radius: 25px;
            color: white;
            font-size: 14px;
            cursor: pointer;
            transition: 0.2s;
        }

        .checkout:hover {
            background: #4b2e2e;
        }

        .checkout:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .warning {
            color: #dc3545;
            font-size: 11px;
            margin-top: 5px;
        }

        .kosong {
            text-align: center;
            margin-top: 50px;
            font-size: 16px;
            color: #777;
        }

        .info-text {
            font-size: 12px;
            color: #6f4e37;
            margin-top: 8px;
            text-align: left;
        }

        @media (max-width: 600px) {
            .flex {
                flex-direction: column;
                align-items: stretch;
            }

            .qty-box {
                text-align: left;
            }

            .qty {
                justify-content: flex-start;
            }

            .hapus-box {
                text-align: right;
            }

            .top-bar {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .metode-box label {
                display: block;
                margin-right: 0;
            }
        }
    </style>
</head>

<body>

    <div class="header">
        🛒 KERANJANG TERAS CAFFE
    </div>

    <div class="container">

        <div class="top-bar">
            <span class="meja-title">Meja <?= esc($meja) ?></span>
            <a class="back" href="<?= base_url('/menu?meja=' . $meja) ?>">← Kembali ke Menu</a>
        </div>

        <?php if (!empty($keranjang)): ?>

            <form action="<?= base_url('/menu/struk') ?>" method="post" id="formCheckout">
                <?= csrf_field() ?>
                <input type="hidden" name="meja" value="<?= $meja ?>">
                <input type="hidden" name="tipe_pembayaran" value="kasir">

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
                                
                                <!-- ========== TAMPILAN LEVEL PEDAS ========== -->
                                <?php if (!empty($k['level_pedas']) && $k['level_pedas'] > 0): ?>
                                    <div class="level-info">
                                        <i class="fa fa-pepper-hot"></i> Level Pedas: 
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <?php if ($i <= $k['level_pedas']): ?>
                                                🌶
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        (Level <?= $k['level_pedas'] ?>)
                                    </div>
                                <?php endif; ?>
                                <!-- ======================================= -->
                                
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

</body>

</html>