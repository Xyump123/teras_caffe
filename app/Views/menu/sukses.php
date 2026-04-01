<?php

$transaksi = $transaksi ?? null;
$detail = $detail ?? [];

if (!$transaksi):
?>

    <h3>Transaksi tidak ditemukan</h3>
    <a href="<?= base_url('menu') ?>">Kembali ke Menu</a>

<?php return;
endif; ?>

<?php

$status = $transaksi['status'] ?? 'pending';

if ($status == 'pending') {

    $label = 'MENUNGGU PEMBAYARAN';
    $warna = '#fff3cd';
    $text  = '#856404';
} elseif ($status == 'menunggu_konfirmasi') {

    $label = 'MENUNGGU KONFIRMASI KASIR';
    $warna = '#cce5ff';
    $text  = '#004085';
} else {

    $label = 'PEMBAYARAN SELESAI';
    $warna = '#d4edda';
    $text  = '#155724';
}

$tipe = strtoupper($transaksi['tipe_pembayaran'] ?? '-');
$metode = strtoupper($transaksi['metode_pembayaran'] ?? '-');

?>

<!DOCTYPE html>
<html>

<head>

    <link rel="icon" type="image/jpeg" href="<?= base_url('uploads/favicon.jpeg') ?>">
    <title>Status Pembayaran</title>

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

        .box {
            width: 100%;
            max-width: 520px;
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #4b2e2e;
        }

        .status {
            padding: 14px;
            border-radius: 10px;
            font-weight: bold;
            margin-bottom: 18px;
            text-align: center;
            font-size: 14px;
        }

        .info {
            font-size: 14px;
            margin-bottom: 6px;
        }

        .info b {
            color: #333;
        }

        .divider {
            border-bottom: 2px dashed #ccc;
            margin: 15px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
        }

        td {
            padding: 8px 0;
            vertical-align: top;
        }

        .menu-harga {
            text-align: right;
            font-weight: 600;
        }

        .opsi {
            font-size: 12px;
            color: #666;
            margin-top: 2px;
        }

        .total {
            margin-top: 15px;
            font-weight: bold;
            font-size: 20px;
            text-align: center;
            background: #4b2e2e;
            color: white;
            padding: 15px;
            border-radius: 12px;
        }

        .btn {
            display: block;
            margin-top: 20px;
            padding: 14px;
            background: #6f4e37;
            color: white;
            text-decoration: none;
            border-radius: 30px;
            text-align: center;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn:hover {
            background: #4b2e2e;
            transform: scale(1.02);
        }

        @media(max-width:480px) {

            .box {
                padding: 22px;
                border-radius: 15px;
            }

            .title {
                font-size: 20px;
            }

            table {
                font-size: 14px;
            }

            .total {
                font-size: 18px;
            }

        }
    </style>

</head>

<body>

    <div class="box">

        <div class="title">📄 Status Pembayaran</div>

        <div class="status" style="background:<?= esc($warna) ?>; color:<?= esc($text) ?>;">
            Status: <?= esc($label) ?>
        </div>

        <div class="info">
            No Transaksi : <b>#<?= esc($transaksi['id'] ?? '') ?></b>
        </div>

        <div class="info">
            No Meja : <b><?= esc($transaksi['meja'] ?? '') ?></b>
        </div>

        <div class="info">
            Tipe Pembayaran :
            <b><?= esc($tipe) ?></b>
        </div>

        <div class="info">
            Metode Pembayaran :
            <b><?= esc($metode) ?></b>
        </div>

        <div class="divider"></div>

        <table>

            <?php if (!empty($detail)): ?>

                <?php foreach ($detail as $d): ?>

                    <tr>

                        <td>

                            <?= esc($d['nama_menu'] ?? '') ?> x<?= esc($d['qty'] ?? 0) ?>

                            <?php if (!empty($d['level_pedas'])): ?>
                                <div class="opsi">
                                    Level Pedas : <?= esc($d['level_pedas']) ?>
                                </div>
                            <?php endif; ?>

                        </td>

                        <td class="menu-harga">
                            Rp <?= number_format($d['subtotal'] ?? 0, 0, ',', '.') ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php endif; ?>

        </table>

        <div class="divider"></div>

        <div class="total">
            Total Bayar<br>
            Rp <?= number_format($transaksi['total'] ?? 0, 0, ',', '.') ?>
        </div>

        <a href="<?= base_url('menu?meja=' . ($transaksi['meja'] ?? '')) ?>" class="btn">
            Kembali ke Menu
        </a>

    </div>

</body>

</html>