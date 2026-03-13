<!DOCTYPE html>
<html>

<head>

    <!-- FAVICON -->
    <link rel="icon" type="image/jpeg" href="<?= base_url('uploads/favicon.jpeg') ?>">
    <link rel="shortcut icon" type="image/jpeg" href="<?= base_url('uploads/favicon.jpeg') ?>">

    <title>Teras Caffe</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Segoe UI", sans-serif;
            background: #f5f1ea;
            color: #3b2a21;
        }

        /* NAVBAR */

        .navbar {
            background: #3b2a21;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 40px;
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 14px;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }

        /* HERO */

        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                url("https://images.unsplash.com/photo-1509042239860-f550ce710b93");
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
            padding: 120px 20px;
        }

        .hero h1 {
            font-size: 45px;
            margin-bottom: 10px;
        }

        .hero p {
            font-size: 18px;
            max-width: 600px;
            margin: auto;
            margin-bottom: 25px;
        }

        .btn {
            display: inline-block;
            padding: 14px 28px;
            background: #a67c52;
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-size: 15px;
        }

        .btn:hover {
            background: #6f4e37;
        }

        /* SECTION */

        .section {
            padding: 70px 20px;
            text-align: center;
        }

        .section h2 {
            font-size: 28px;
            margin-bottom: 15px;
        }

        .section p {
            max-width: 700px;
            margin: auto;
            color: #6b5a4a;
            line-height: 1.7;
        }

        /* MENU */

        .menu-container {
            margin-top: 40px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 25px;
        }

        .menu-card {
            background: white;
            width: 240px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
        }

        .menu-card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }

        .menu-body {
            padding: 18px;
        }

        .menu-body h3 {
            margin-top: 0;
            margin-bottom: 8px;
        }

        .harga {
            color: #a67c52;
            font-weight: bold;
        }

        /* KEUNGGULAN */

        .features {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
            margin-top: 40px;
        }

        .feature {
            width: 220px;
        }

        .icon {
            font-size: 35px;
            margin-bottom: 10px;
        }

        /* CTA */

        .cta {
            background: #3b2a21;
            color: white;
            padding: 60px 20px;
            text-align: center;
        }

        .cta h2 {
            margin-bottom: 15px;
        }

        /* FOOTER */

        .footer {
            background: #2a1d17;
            color: #ccc;
            text-align: center;
            padding: 25px;
            font-size: 14px;
        }

        .footer a {
            color: #ddd;
            font-size: 12px;
            text-decoration: none;
        }

        /* MOBILE */

        @media(max-width:768px) {

            .hero h1 {
                font-size: 30px;
            }

            .menu-container {
                gap: 15px;
            }

            .menu-card {
                width: 45%;
            }

            .features {
                gap: 20px;
            }

        }
    </style>

</head>

<body>


    <!-- NAVBAR -->

    <div class="navbar">

        <div class="logo">
            ☕ Teras Caffe
        </div>

        <div class="nav-links">
            <a href="admin/login">Login Admin</a>
        </div>

    </div>



    <!-- HERO -->

    <div class="hero">

        <h1>Nikmati Kopi Terbaik</h1>

        <p>
            Tempat nongkrong nyaman dengan suasana santai.
            Cocok untuk berkumpul bersama teman, keluarga, atau bekerja.
        </p>

    </div>



    <!-- TENTANG -->

    <div class="section">

        <h2>Tentang Teras Caffe</h2>

        <p>
            Teras Caffe menghadirkan pengalaman menikmati kopi dengan suasana santai,
            menu yang lezat, serta harga yang ramah di kantong.
            Tempat yang sempurna untuk bersantai, bekerja, atau berkumpul bersama teman.
        </p>

    </div>



    <!-- MENU FAVORIT -->

    <div class="section">

        <h2>Menu Favorit</h2>

        <div class="menu-container">

            <div class="menu-card">

                <img src="uploads/1773138432_19ec7c29894c978a5713.jpg">

                <div class="menu-body">

                    <h3> Nasi Fire Wings</h3>

                    <div class="harga">
                        Rp 18.000
                    </div>

                </div>

            </div>


            <div class="menu-card">

                <img src="uploads/1773141076_709636737227c16636a0.jpg">

                <div class="menu-body">

                    <h3> Roti Bakar Coklat Keju</h3>

                    <div class="harga">
                        Rp 14.000
                    </div>

                </div>

            </div>


            <div class="menu-card">

                <img src="uploads/1773141967_0784289e8ba6af986458.jpg">

                <div class="menu-body">

                    <h3>Max Tea Tarik</h3>

                    <div class="harga">
                        Rp 10.000
                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- KEUNGGULAN -->

    <div class="section">

        <h2>Kenapa Pilih Teras Caffe?</h2>

        <div class="features">

            <div class="feature">
                <div class="icon">☕</div>
                <h3>Kopi Berkualitas</h3>
                Bahan pilihan terbaik
            </div>

            <div class="feature">
                <div class="icon">📱</div>
                <h3>Pesan via QR</h3>
                Pesan langsung dari meja
            </div>

            <div class="feature">
                <div class="icon">🪑</div>
                <h3>Tempat Nyaman</h3>
                Suasana santai
            </div>

            <div class="feature">
                <div class="icon">💰</div>
                <h3>Harga Terjangkau</h3>
                Cocok untuk semua
            </div>

        </div>

    </div>



    <!-- CTA -->

    <div class="cta">

        <h2>Pesan Menu Sekarang</h2>

        Scan QR di meja untuk melihat menu dan memesan makanan langsung dari ponsel Anda.

        <br><br>

        <a href="http://localhost:8080/index.php/menu?meja=1" class="btn">
            Buka Menu
        </a>

    </div>



    <!-- FOOTER -->

    <div class="footer">

        Teras Caffe © 2026

    </div>



</body>

</html>