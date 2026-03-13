<!DOCTYPE html>
<html>

<head>

    <!-- FAVICON -->
    <link rel="icon" type="image/jpeg" href="<?= base_url('uploads/favicon.jpeg') ?>">
    <link rel="shortcut icon" type="image/jpeg" href="<?= base_url('uploads/favicon.jpeg') ?>">

    <title>Menu Teras Caffe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            box-sizing: border-box;
        }

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
        }

        .container {
            width: 100%;
            max-width: 1500px;
            margin: auto;
            padding: 40px 80px;
        }

        .meja {
            margin-bottom: 15px;
            font-size: 17px;
            color: #5a4636;
        }

        .keranjang-btn {
            background: #6f4e37;
            margin-bottom: 30px;
            padding: 12px 20px;
            border: none;
            color: white;
            border-radius: 25px;
            cursor: pointer;
            font-size: 15px;
        }

        .kategori-title {
            font-size: 22px;
            margin: 40px 0 20px 0;
            border-left: 6px solid #6f4e37;
            padding-left: 10px;
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
        }

        .card img {
            width: 100%;
            height: 190px;
            object-fit: cover;
        }

        .card-body {
            padding: 15px;
            text-align: center;
        }

        .nama-menu {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .harga {
            color: #6f4e37;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .btn-pesan {
            background: #a67c52;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 20px;
            color: white;
            cursor: pointer;
        }

        .btn-pesan:hover {
            background: #6f4e37;
        }

        @media (max-width:600px) {

            .container {
                padding: 15px;
            }

            .menu-container {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .header {
                font-size: 20px;
                padding: 18px;
            }

            .card img {
                height: 110px;
            }

            .nama-menu {
                font-size: 13px;
            }

            .harga {
                font-size: 12px;
            }

            .btn-pesan {
                font-size: 11px;
                padding: 6px;
            }

            .keranjang-btn {
                width: 100%;
                font-size: 13px;
                padding: 8px;
            }

        }
    </style>
</head>

<body>

    <div class="header">
        TERAS CAFFE ☕
    </div>

    <div class="container">

        <?php if ($meja): ?>

            <div class="meja">
                Meja : <b><?= $meja ?></b>
            </div>

            <a href="<?= base_url('/menu/keranjang?meja=' . $meja) ?>">
                <button class="keranjang-btn">
                    🛒 Lihat Keranjang
                </button>
            </a>

        <?php endif; ?>


        <?php
        /* GROUP MENU BERDASARKAN KATEGORI */

        $kategori = [];

        foreach ($menu as $m) {
            $kategori[$m['kategori']][] = $m;
        }
        ?>


        <?php foreach ($kategori as $nama_kategori => $menus): ?>

            <h2 class="kategori-title">
                <?= $nama_kategori ?>
            </h2>

            <div class="menu-container">

                <?php foreach ($menus as $m): ?>

                    <div class="card">

                        <?php if (!empty($m['gambar'])): ?>
                            <img src="<?= base_url('uploads/' . $m['gambar']) ?>">
                        <?php else: ?>
                            <img src="<?= base_url('uploads/default.jpg') ?>">
                        <?php endif; ?>

                        <div class="card-body">

                            <div class="nama-menu">
                                <?= $m['nama_menu'] ?>
                            </div>

                            <div class="harga">
                                Rp <?= number_format($m['harga'], 0, ',', '.') ?>
                            </div>

                            <?php if ($m['stok'] > 0): ?>

                                <form action="<?= base_url('/menu/tambah') ?>" method="post">

                                    <?= csrf_field() ?>

                                    <input type="hidden" name="id_menu" value="<?= $m['id'] ?>">
                                    <input type="hidden" name="nama_menu" value="<?= $m['nama_menu'] ?>">
                                    <input type="hidden" name="harga" value="<?= $m['harga'] ?>">
                                    <input type="hidden" name="meja" value="<?= $meja ?>">

                                    <button class="btn-pesan" type="submit">
                                        Pesan Menu
                                    </button>

                                </form>

                            <?php else: ?>

                                <div style="background:#dc3545;color:white;padding:8px;border-radius:20px;font-size:12px;">
                                    Stok Habis
                                </div>

                            <?php endif; ?>

                        </div>
                    </div>

                <?php endforeach; ?>

            </div>

        <?php endforeach; ?>

    </div>

</body>

</html>