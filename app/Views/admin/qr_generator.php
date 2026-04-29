<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    .card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .btn-primary {
        background: #1e3a5f;
        color: white;
        padding: 8px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-primary:hover {
        background: #0f2b4a;
    }

    .btn-success {
        background: #28a745;
        color: white;
        padding: 8px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-success:hover {
        background: #218838;
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
        border: 1px solid #eee;
        border-radius: 10px;
        background: #f9f9f9;
    }

    .qr-item img {
        width: 150px;
        height: 150px;
        margin-bottom: 10px;
    }

    .qr-item h4 {
        margin: 10px 0;
        font-size: 16px;
    }

    .btn-download {
        background: #17a2b8;
        color: white;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 4px;
        font-size: 12px;
        display: inline-block;
        margin: 2px;
    }

    .btn-view {
        background: #6c757d;
        color: white;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 4px;
        font-size: 12px;
        display: inline-block;
        margin: 2px;
    }
</style>

<div class="card">
    <h3>📱 Generate QR Code Meja</h3>
    <p>Generate QR Code untuk setiap meja. Pelanggan scan QR Code untuk membuka menu.</p>
</div>

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

        <button type="submit" class="btn-primary">Generate QR Code</button>
    </form>
</div>

<!-- FORM BULK GENERATE -->
<div class="card">
    <h4>Generate Semua Meja (Bulk)</h4>
    <form action="<?= base_url('admin/qr-generator/bulk') ?>" method="post">
        <?= csrf_field() ?>
        
        <div class="form-group">
            <label>Ukuran QR Code (px)</label>
            <input type="number" name="size" class="form-control" value="200" min="100" max="500">
        </div>

        <button type="submit" class="btn-success">Generate Semua Meja (1-20)</button>
    </form>
</div>

<!-- DAFTAR QR CODE YANG SUDAH ADA -->
<div class="card">
    <h4>📋 QR Code Meja yang Tersedia</h4>
    
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
                    <a href="<?= base_url('admin/qr-generator/download/' . $i) ?>" class="btn-download">⬇️ Download</a>
                    <a href="<?= base_url('menu?meja=' . $i) ?>" target="_blank" class="btn-view">👁️ Lihat Menu</a>
                <?php else: ?>
                    <div style="width:150px;height:150px;background:#eee;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                        Belum dibuat
                    </div>
                    <h4>Meja <?= $i ?></h4>
                    <span style="color:#999;">Belum ada QR</span>
                <?php endif; ?>
            </div>
        <?php endfor; ?>
    </div>
</div>

<?= $this->endSection() ?>