<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --primary: #8B6914;
        --primary-dark: #6B4F12;
        --secondary: #2c3e2f;
        --gray-bg: #f5f5f5;
        --border: #ddd;
    }

    .page-header {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 25px;
        border: 1px solid var(--border);
    }

    .page-header h3 {
        margin: 0 0 8px 0;
        font-size: 24px;
        font-weight: 600;
        color: #333;
    }

    .page-header p {
        margin: 0;
        color: #666;
        font-size: 14px;
    }

    .grid-2cols {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
        margin-bottom: 30px;
    }

    .card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--border);
    }

    .card h4 {
        margin: 0 0 15px 0;
        font-size: 16px;
        font-weight: 600;
        color: #333;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--primary);
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #333;
        font-size: 13px;
    }

    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 13px;
        background: white;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
    }

    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
    }

    .btn-success {
        background: #28a745;
        color: white;
    }

    .btn-success:hover {
        background: #1e7e34;
    }

    .qr-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .qr-item {
        text-align: center;
        padding: 15px;
        border-radius: 12px;
        background: var(--gray-bg);
        border: 1px solid var(--border);
    }

    .qr-item img {
        width: 140px;
        height: 140px;
        margin-bottom: 10px;
        border-radius: 8px;
    }

    .qr-item h4 {
        margin: 10px 0;
        font-size: 16px;
        font-weight: 600;
        color: #333;
        border: none;
        padding: 0;
    }

    .qr-placeholder {
        width: 140px;
        height: 140px;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        border-radius: 8px;
        font-size: 40px;
    }

    .btn-group {
        display: flex;
        gap: 6px;
        justify-content: center;
        margin-top: 10px;
        flex-wrap: wrap;
    }

    .btn-download {
        background: #17a2b8;
        color: white;
        padding: 4px 10px;
        text-decoration: none;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 500;
    }

    .btn-download:hover {
        background: #138496;
    }

    .btn-view {
        background: #6c757d;
        color: white;
        padding: 4px 10px;
        text-decoration: none;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 500;
    }

    .btn-view:hover {
        background: #5a6268;
    }

    .badge-empty {
        display: inline-block;
        padding: 3px 8px;
        background: #ffeaa7;
        color: #d63031;
        border-radius: 15px;
        font-size: 11px;
        font-weight: 500;
    }

    .section-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .section-title h4 {
        margin: 0;
        border: none;
        padding: 0;
        font-size: 16px;
    }

    .count-badge {
        background: var(--primary);
        color: white;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .grid-2cols {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .qr-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        }
    }
</style>

<div class="page-header">
    <h3>QR Code Meja</h3>
    <p>Generate QR Code untuk setiap meja. Pelanggan scan QR Code untuk membuka menu digital.</p>
</div>

<div class="grid-2cols">
    <!-- FORM GENERATE PER MEJA -->
    <div class="card">
        <h4>Generate Per Meja</h4>
        <form action="<?= base_url('admin/qr-generator/generate') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label>Pilih Nomor Meja</label>
                <select name="meja" class="form-control" required>
                    <option value="">-- Pilih Meja --</option>
                    <?php foreach ($meja as $m): ?>
                        <option value="<?= $m ?>">Meja <?= $m ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Ukuran QR Code (px)</label>
                <input type="number" name="size" class="form-control" value="200" min="100" max="500">
            </div>

            <button type="submit" class="btn btn-primary">
                Generate QR Code
            </button>
        </form>
    </div>

    <!-- FORM BULK GENERATE -->
    <div class="card">
        <h4>Generate Semua Meja</h4>
        <form action="<?= base_url('admin/qr-generator/bulk') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label>Ukuran QR Code (px)</label>
                <input type="number" name="size" class="form-control" value="200" min="100" max="500">
            </div>

            <button type="submit" class="btn btn-success">
                Generate Semua Meja (1-20)
            </button>
        </form>
    </div>
</div>

<!-- DAFTAR QR CODE YANG SUDAH ADA -->
<div class="card">
    <div class="section-title">
        <h4>Daftar QR Code Meja</h4>
        <?php
            $existsCount = 0;
            for ($i = 1; $i <= 20; $i++) {
                if (file_exists(FCPATH . 'uploads/qrcode/meja_' . $i . '.png')) $existsCount++;
            }
        ?>
        <span class="count-badge"><?= $existsCount ?>/20 Tersedia</span>
    </div>
    
    <div class="qr-grid">
        <?php for ($i = 1; $i <= 20; $i++): ?>
            <?php 
            $qrPath = 'uploads/qrcode/meja_' . $i . '.png';
            $exists = file_exists(FCPATH . $qrPath);
            ?>
            <div class="qr-item">
                <?php if ($exists): ?>
                    <img src="<?= base_url($qrPath) ?>" alt="QR Code Meja <?= $i ?>">
                    <h4>Meja <?= $i ?></h4>
                    <div class="btn-group">
                        <a href="<?= base_url('admin/qr-generator/download/' . $i) ?>" class="btn-download">
                            ⬇️ Download
                        </a>
                        <a href="<?= base_url('menu?meja=' . $i) ?>" target="_blank" class="btn-view">
                            👁️ Lihat Menu
                        </a>
                    </div>
                <?php else: ?>
                    <div class="qr-placeholder">
                        🍽️
                    </div>
                    <h4>Meja <?= $i ?></h4>
                    <span class="badge-empty">Belum dibuat</span>
                <?php endif; ?>
            </div>
        <?php endfor; ?>
    </div>
</div>

<?= $this->endSection() ?>