<!DOCTYPE html>
<html>

<head>
    <title><?= $title ?? 'Admin Panel' ?> - Teras Caffe</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FAVICON -->
    <link rel="icon" type="image/jpeg" href="<?= base_url('uploads/favicon.jpeg') ?>">
    <link rel="shortcut icon" type="image/jpeg" href="<?= base_url('uploads/favicon.jpeg') ?>">

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Poppins", "Segoe UI", sans-serif;
            background: #f5f1ea;
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */

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
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
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

        /* ===== MAIN ===== */

        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* ===== HEADER ===== */

        .header {
            background: white;
            padding: 18px 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
        }

        .header h3 {
            margin: 0;
            font-weight: 600;
            color: #3b2a21;
        }

        /* ===== USER AREA ===== */

        .user-area {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .logout {
            background: #3b2a21;
            color: white;
            padding: 8px 18px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 13px;
            transition: .2s;
        }

        .logout:hover {
            background: #5a3c2e;
        }

        /* ===== CONTENT ===== */

        .content {
            flex: 1;
            padding: 35px;
        }

        .container-fix {
            max-width: 1200px;
            margin: auto;
        }

        /* ===== CARD ===== */

        .card {
            background: white;
            padding: 25px;
            border-radius: 14px;
            border: 1px solid #eee;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.05);
        }

        /* ===== TABLE ===== */

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background: #3b2a21;
            color: white;
            padding: 14px;
            font-size: 13px;
            letter-spacing: .5px;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        tr:hover {
            background: #faf7f2;
        }

        /* ===== BADGE ===== */

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            color: white;
        }

        .pending {
            background: #d98c2b;
        }

        .lunas {
            background: #3b8b5c;
        }

        .batal {
            background: #b33939;
        }

        /* ===== FORM ===== */

        input,
        select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        input:focus,
        select:focus {
            border-color: #3b2a21;
            outline: none;
        }

        button {
            background: #3b2a21;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background: #5a3c2e;
        }

        /* ===== FOOTER ===== */

        .footer {
            background: white;
            padding: 15px;
            text-align: center;
            border-top: 1px solid #eee;
            font-size: 13px;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2><i class="fa fa-mug-hot"></i> Teras Caffe</h2>

        <a href="<?= base_url('admin/dashboard') ?>">
            <i class="fa fa-chart-line"></i> Dashboard
        </a>

        <a href="<?= base_url('admin/menu') ?>">
            <i class="fa fa-utensils"></i> Manage Menu
        </a>

        <a href="<?= base_url('admin/transaksi') ?>">
            <i class="fa fa-receipt"></i> Transaksi
        </a>

        <a href="<?= base_url('admin/laporan') ?>">
            <i class="fa fa-file-invoice-dollar"></i> Laporan
        </a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <div class="header">
            <h3><?= $title ?? '' ?></h3>

            <div class="user-area">
                <span><i class="fa fa-user"></i> <?= session('username') ?></span>
                <a href="<?= base_url('admin/logout') ?>" class="logout">Logout</a>
            </div>
        </div>

        <div class="content">
            <div class="container-fix">
                <?= $this->renderSection('content') ?>
            </div>
        </div>

        <div class="footer">
            © <?= date('Y') ?> Teras Caffe - Admin Panel
        </div>

    </div>

</body>

</html>