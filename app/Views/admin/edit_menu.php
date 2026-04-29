<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    .container-fix {
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
    }
    
    .card {
        background: white;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
    }
    
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #6c757d;
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }
    
    .btn-back:hover {
        background: #5a6268;
        transform: translateX(-3px);
    }
    
    h3 {
        font-size: 24px;
        font-weight: 600;
        color: #333;
        margin: 0 0 10px 0;
        padding-bottom: 15px;
        border-bottom: 2px solid #8B6914;
        display: inline-block;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        font-size: 14px;
    }
    
    .form-group label span {
        color: #e74c3c;
        margin-left: 4px;
    }
    
    .form-group input,
    .form-group select {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }
    
    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #8B6914;
        box-shadow: 0 0 0 3px rgba(139, 105, 20, 0.1);
    }
    
    .form-group input:hover,
    .form-group select:hover {
        border-color: #8B6914;
    }
    
    .form-group input[readonly] {
        background: #f9f9f9;
        cursor: not-allowed;
    }
    
    .hint {
        font-size: 12px;
        color: #888;
        margin-top: 5px;
    }
    
    .file-input {
        position: relative;
        display: inline-block;
        width: 100%;
    }
    
    .file-input input[type="file"] {
        padding: 10px;
        background: #f9f9f9;
        cursor: pointer;
    }
    
    .file-input input[type="file"]::file-selector-button {
        background: #8B6914;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        cursor: pointer;
        margin-right: 10px;
        transition: all 0.3s ease;
    }
    
    .file-input input[type="file"]::file-selector-button:hover {
        background: #6B4F12;
    }
    
    .current-image {
        background: #f5f5f5;
        padding: 15px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }
    
    .current-image label {
        font-weight: 600;
        color: #333;
        margin: 0;
    }
    
    .current-image img {
        border-radius: 10px;
        border: 1px solid #ddd;
        background: white;
        padding: 4px;
    }
    
    .current-image .image-name {
        font-size: 13px;
        color: #666;
        background: white;
        padding: 4px 10px;
        border-radius: 20px;
    }
    
    .btn-update {
        background: #8B6914;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        margin-top: 10px;
    }
    
    .btn-update:hover {
        background: #6B4F12;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 105, 20, 0.3);
    }
    
    .btn-update:active {
        transform: translateY(0);
    }
    
    .separator {
        margin: 20px 0;
        border-top: 1px solid #eee;
    }
</style>

<div class="container-fix">
    <div class="card">
        <a href="<?= base_url('admin/menu') ?>" class="btn-back">
            ← Kembali
        </a>

        <h3>Edit Menu</h3>
        
        <div style="margin: 20px 0;"></div>

        <form action="<?= base_url('admin/menu/update/' . $menu['id']) ?>" method="post" enctype="multipart/form-data">
            
            <div class="form-group">
                <label>Nama Menu <span>*</span></label>
                <input type="text" name="nama_menu" value="<?= esc($menu['nama_menu']) ?>" placeholder="Masukkan nama menu" required>
                <div class="hint">Contoh: Nasi Goreng, Es Teh Manis, dll.</div>
            </div>

            <div class="form-group">
                <label>Harga <span>*</span></label>
                <input type="text" id="harga" name="harga" value="<?= number_format($menu['harga'], 0, ',', '.') ?>" placeholder="Rp 0" inputmode="numeric" required>
                <div class="hint">Masukkan angka tanpa titik, contoh: 15000</div>
            </div>

            <div class="form-group">
                <label>Stok <span>*</span></label>
                <input type="number" name="stok" value="<?= $menu['stok'] ?>" placeholder="Masukkan jumlah stok" required>
                <div class="hint">Jumlah ketersediaan menu (minimal 0)</div>
            </div>

            <div class="form-group">
                <label>Kategori <span>*</span></label>
                <select name="kategori" required>
                    <option value="Makanan" <?= $menu['kategori'] == 'Makanan' ? 'selected' : '' ?>>🍚 Makanan</option>
                    <option value="Minuman" <?= $menu['kategori'] == 'Minuman' ? 'selected' : '' ?>>🥤 Minuman</option>
                    <option value="Dessert" <?= $menu['kategori'] == 'Dessert' ? 'selected' : '' ?>>🍰 Dessert</option>
                </select>
                <div class="hint">Pilih kategori yang sesuai dengan menu</div>
            </div>

            <div class="form-group">
                <label>Gambar Saat Ini</label>
                <div class="current-image">
                    <?php if ($menu['gambar']): ?>
                        <img src="<?= base_url('uploads/' . $menu['gambar']) ?>" 
                             onerror="this.src='<?= base_url('uploads/default.jpg') ?>'"
                             width="80" height="80" style="object-fit: cover;">
                        <span class="image-name">📷 <?= $menu['gambar'] ?></span>
                        <small style="color: #888; margin-left: auto;">Kosongkan jika tidak ingin mengganti</small>
                    <?php else: ?>
                        <span style="color: #999;">Tidak ada gambar</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <label>Gambar Baru (Opsional)</label>
                <div class="file-input">
                    <input type="file" name="gambar" accept="image/*">
                </div>
                <div class="hint">Format: JPG, PNG, JPEG. Maksimal 2MB. Biarkan kosong jika tidak ingin mengubah gambar.</div>
            </div>

            <div class="separator"></div>

            <button type="submit" class="btn-update">
                Update Menu
            </button>

        </form>
    </div>
</div>

<script>
    const hargaInput = document.getElementById('harga');

    hargaInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value) {
            this.value = new Intl.NumberFormat('id-ID').format(value);
        } else {
            this.value = '';
        }
    });

    document.querySelector("form").addEventListener("submit", function() {
        let hargaRaw = hargaInput.value.replace(/\./g, '');
        hargaInput.value = hargaRaw;
    });
</script>

<?= $this->endSection() ?>