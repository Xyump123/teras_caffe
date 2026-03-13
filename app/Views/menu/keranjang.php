<!DOCTYPE html>
<html>

<head>

    <!-- FAVICON -->
    <link rel="icon" type="image/jpeg" href="<?= base_url('uploads/favicon.jpeg') ?>">
    <link rel="shortcut icon" type="image/jpeg" href="<?= base_url('uploads/favicon.jpeg') ?>">

    <title>Keranjang Teras Caffe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background: #f6f2eb;
            color: #3b2f2f;
        }

        .header {
            background: #4b2e2e;
            color: white;
            padding: 18px;
            text-align: center;
            font-size: 22px;
            letter-spacing: 1px;
        }

        .container {
            max-width: 900px;
            margin: auto;
            padding: 20px;
        }

        .back {
            text-decoration: none;
            color: #6f4e37;
            font-weight: bold;
        }

        .card {
            background: white;
            border-radius: 14px;
            padding: 18px;
            margin-top: 15px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .flex {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
        }

        .menu-info {
            flex: 1;
        }

        .nama {
            font-size: 18px;
            font-weight: 600;
        }

        .harga {
            color: #6f4e37;
            font-weight: bold;
            margin-top: 4px;
        }

        .opsi {
            margin-top: 8px;
            font-size: 14px;
        }

        .opsi label {
            margin-right: 10px;
            cursor: pointer;
        }

        .qty-box {
            width: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qty {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .qty-btn {
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 50%;
            font-size: 18px;
            cursor: pointer;
        }

        .minus {
            background: #c9a27c;
        }

        .plus {
            background: #6f4e37;
            color: white;
        }

        .hapus-box {
            width: 40px;
            display: flex;
            justify-content: flex-end;
        }

        .hapus {
            background: #c0392b;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 8px;
            cursor: pointer;
        }

        .total-box {
            background: white;
            border-radius: 14px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .total {
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
        }

        .metode-box {
            margin-bottom: 15px;
        }

        .metode-box label {
            display: block;
            margin-top: 5px;
        }

        .checkout {
            width: 100%;
            background: #6f4e37;
            border: none;
            padding: 14px;
            border-radius: 25px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .checkout:hover {
            background: #4b2e2e;
        }

        .kosong {
            text-align: center;
            margin-top: 60px;
            font-size: 18px;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="header">
        KERANJANG TERAS CAFFE ☕
    </div>

    <div class="container">

        <h3>Meja <?= esc($meja) ?></h3>

        <a class="back" href="<?= base_url('/menu?meja=' . $meja) ?>">
            ⬅ Kembali ke Menu
        </a>

        <?php if (!empty($keranjang)): ?>

            <form action="<?= base_url('/menu/struk') ?>" method="post">

                <?= csrf_field() ?>

                <input type="hidden" name="meja" value="<?= $meja ?>">

                <?php foreach ($keranjang as $k): ?>

                    <div class="card">

                        <div class="flex">

                            <div class="menu-info">

                                <div class="nama">
                                    <?= esc($k['nama_menu']) ?>
                                </div>

                                <div class="harga">
                                    Rp <?= number_format($k['harga'], 0, ',', '.') ?>
                                </div>

                                <?php if ($k['ada_level'] == 1): ?>

                                    <div class="opsi">

                                        <b>Level Pedas :</b><br>

                                        <?php for ($i = 1; $i <= 5; $i++): ?>

                                            <label>
                                                <input type="radio" name="level_<?= $k['id'] ?>" value="<?= $i ?>" required>
                                                🌶 <?= $i ?>
                                            </label>

                                        <?php endfor; ?>

                                    </div>

                                <?php endif; ?>

                            </div>

                            <div class="qty-box">

                                <div class="qty">

                                    <a href="<?= base_url('/menu/keranjang/kurang/' . $k['id'] . '/' . $meja) ?>">
                                        <button type="button" class="qty-btn minus">-</button>
                                    </a>

                                    <b><?= $k['qty'] ?></b>

                                    <a href="<?= base_url('/menu/keranjang/tambah/' . $k['id'] . '/' . $meja) ?>">
                                        <button type="button" class="qty-btn plus">+</button>
                                    </a>

                                </div>

                            </div>

                            <div class="hapus-box">

                                <a href="<?= base_url('/menu/keranjang/hapus/' . $k['id'] . '/' . $meja) ?>">
                                    <button type="button" class="hapus">🗑</button>
                                </a>

                            </div>

                        </div>
                    </div>

                <?php endforeach; ?>

                <div class="total-box">

                    <div class="total">
                        Total Rp <?= number_format($total, 0, ',', '.') ?>
                    </div>

                    <div class="metode-box">

                        <b>Tipe Pembayaran :</b>

                        <label>
                            <input type="radio" name="tipe_pembayaran" value="meja" required>
                            Bayar di Meja
                        </label>

                        <label>
                            <input type="radio" name="tipe_pembayaran" value="kasir">
                            Bayar di Kasir
                        </label>

                        <br>

                        <b>Metode Pembayaran :</b>

                        <label>
                            <input type="radio" name="metode_bayar" value="Cash">
                            Cash
                        </label>

                        <label>
                            <input type="radio" name="metode_bayar" value="QRIS">
                            QRIS
                        </label>

                    </div>

                    <button type="submit" class="checkout">
                        Checkout Pesanan
                    </button>

                </div>

            </form>

        <?php else: ?>

            <div class="kosong">
                🛒 Keranjang Masih Kosong
            </div>

        <?php endif; ?>

    </div>

    <script>
        const meja = document.querySelector('input[value="meja"]');
        const kasir = document.querySelector('input[value="kasir"]');
        const cash = document.querySelector('input[value="Cash"]');
        const qris = document.querySelector('input[value="QRIS"]');

        if (meja) {

            meja.addEventListener("change", function() {

                cash.checked = false;
                cash.disabled = true;
                qris.checked = true;

            });

        }

        if (kasir) {

            kasir.addEventListener("change", function() {

                cash.disabled = false;

            });

        }
    </script>

</body>

</html>