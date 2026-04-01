<!DOCTYPE html>
<html>

<head>

    <!-- FAVICON -->
    <link rel="icon" type="image/jpeg" href="<?= base_url('uploads/favicon.jpeg') ?>">
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

            animation: fadeDown 0.8s ease;
        }

        @keyframes fadeDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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
        }

        .keranjang-btn:hover {
            transform: scale(1.05);
        }

        .kategori-title {
            font-size: 22px;
            margin: 40px 0 20px;
            border-left: 6px solid #6f4e37;
            padding-left: 10px;

            animation: fadeUp 0.6s ease;
        }

        /* GRID */
        .menu-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        /* CARD */
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

        .card:hover img {
            transform: scale(1.1);
        }

        .card-body {
            padding: 15px;
            text-align: center;
        }

        .nama-menu {
            font-size: 18px;
        }

        .harga {
            color: #6f4e37;
            font-weight: bold;
            margin: 10px 0;
        }

        /* BUTTON */
        .btn-pesan {
            position: relative;
            overflow: hidden;
            background: #a67c52;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 20px;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-pesan:hover {
            background: #6f4e37;
            transform: scale(1.05);
        }

        /* ripple */
        .btn-pesan span {
            position: absolute;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s linear;
        }

        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* ANIMATION */
        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* MOBILE */
        @media (max-width:600px) {
            .container {
                padding: 15px;
            }

            .menu-container {
                grid-template-columns: repeat(2, 1fr);
            }

            .card img {
                height: 110px;
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
                <button class="keranjang-btn">🛒 Lihat Keranjang</button>
            </a>
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

                        <img src="<?= !empty($m['gambar']) ? base_url('uploads/' . $m['gambar']) : base_url('uploads/default.jpg') ?>">

                        <div class="card-body">

                            <div class="nama-menu"><?= $m['nama_menu'] ?></div>

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

    <!-- JS RIPPLE -->
    <script>
        document.querySelectorAll('.btn-pesan').forEach(btn => {
            btn.addEventListener('click', function(e) {
                const circle = document.createElement('span');
                const rect = this.getBoundingClientRect();

                circle.style.left = e.clientX - rect.left + 'px';
                circle.style.top = e.clientY - rect.top + 'px';

                this.appendChild(circle);

                setTimeout(() => circle.remove(), 600);
            });
        });
    </script>

</body>

</html>