<?php
$id_transaksi = $id_transaksi ?? '';
$metode = strtolower($metode ?? '');
$tipe = strtolower($tipe ?? '');
$meja = $meja ?? '';
$detail = $detail ?? [];
$total = $total ?? 0;
?>
<!DOCTYPE html>
<html>

<head>

    <link rel="icon" type="image/jpeg" href="<?= base_url('uploads/favicon.jpeg') ?>">

    <title>Struk Pesanan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f3efe7, #e6d5c3);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .struk {
            width: 100%;
            max-width: 520px;
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .logo {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            color: #4b2e2e;
        }

        .subtitle {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-bottom: 10px;
        }

        .info {
            text-align: center;
            font-size: 14px;
            margin-top: 5px;
        }

        .status {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin: 15px 0;
            padding: 12px;
            border-radius: 10px;
        }

        .pending {
            background: #fff3cd;
            color: #856404;
        }

        .cash {
            background: #d4edda;
            color: #155724;
        }

        .divider {
            border-bottom: 2px dashed #ccc;
            margin: 18px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
        }

        td {
            padding: 8px 0;
        }

        .menu-nama {
            font-weight: 500;
        }

        .menu-harga {
            text-align: right;
            font-weight: 600;
        }

        .opsi {
            font-size: 12px;
            color: #666;
        }

        .total-box {
            background: #4b2e2e;
            color: white;
            padding: 18px;
            border-radius: 12px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-top: 15px;
        }

        .qr-box {
            text-align: center;
            margin-top: 18px;
        }

        .qr-box img {
            width: 200px;
            max-width: 100%;
        }

        .info-bayar {
            font-size: 14px;
            text-align: center;
            margin-top: 10px;
            color: #555;
        }

        .btn-bayar {
            margin-top: 20px;
            display: block;
            width: 100%;
            padding: 14px;
            background: #6f4e37;
            color: white;
            border-radius: 30px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            font-weight: 600;
        }

        .btn-bayar:hover {
            background: #4b2e2e;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #777;
        }
    </style>

</head>

<body>

    <div class="struk">

        <div class="logo">TERAS CAFFE ☕</div>
        <div class="subtitle">Struk Pembayaran</div>

        <div class="info">
            No Transaksi : <b>#<?= esc($id_transaksi) ?></b><br>
            Meja : <b><?= esc($meja) ?></b>
        </div>

        <?php if ($metode == 'qris'): ?>

            <div class="status pending">
                MENUNGGU PEMBAYARAN (QRIS)
            </div>

        <?php else: ?>

            <div class="status cash">
                BAYAR DI KASIR (CASH)
            </div>

        <?php endif; ?>

        <div class="divider"></div>

        <table>

            <?php foreach ($detail as $k): ?>

                <tr>

                    <td class="menu-nama">

                        <?= esc($k['nama_menu']) ?> x<?= esc($k['qty']) ?>

                        <?php if (!empty($k['level_pedas'])): ?>
                            <div class="opsi">
                                Level Pedas : <?= esc($k['level_pedas']) ?>
                            </div>
                        <?php endif; ?>

                    </td>

                    <td class="menu-harga">
                        Rp <?= number_format($k['subtotal'], 0, ',', '.') ?>
                    </td>

                </tr>

            <?php endforeach; ?>

        </table>

        <div class="divider"></div>

        <div class="total-box">
            Total Bayar<br>
            Rp <?= number_format($total, 0, ',', '.') ?>
        </div>

        <?php if ($metode == 'qris'): ?>

            <div class="qr-box">

                <img src="<?= base_url('uploads/QR Pembayaran.png') ?>">

                <div class="info-bayar">
                    Scan QR untuk membayar
                </div>

            </div>

            <form action="<?= base_url('menu/bayar') ?>" method="post">

                <?= csrf_field() ?>

                <input type="hidden" name="id_transaksi" value="<?= esc($id_transaksi) ?>">

                <button type="submit" class="btn-bayar">
                    Saya Sudah Bayar
                </button>

            </form>

        <?php endif; ?>

        <?php if ($metode == 'cash'): ?>

            <div class="info-bayar">
                Silakan bayar di kasir<br>
                Sebutkan nomor meja : <b><?= esc($meja) ?></b>
            </div>

            <form action="<?= base_url('menu/bayar') ?>" method="post">

                <?= csrf_field() ?>

                <input type="hidden" name="id_transaksi" value="<?= esc($id_transaksi) ?>">

                <button type="submit" class="btn-bayar">
                    Konfirmasi Sudah Bayar
                </button>

            </form>

        <?php endif; ?>

        <div class="footer">
            Terima kasih telah memesan ☕
        </div>

    </div>

</body>

</html>