<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    .container-fix {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
    }
    
    .card {
        background: white;
        padding: 35px;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }
    
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f0f0f0;
        color: #555;
        padding: 8px 18px;
        border-radius: 30px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-bottom: 25px;
    }
    
    .btn-back:hover {
        background: #e0e0e0;
        transform: translateX(-3px);
        color: #333;
    }
    
    h3 {
        font-size: 28px;
        font-weight: 700;
        color: #2c3e2f;
        margin: 0 0 15px 0;
        padding-bottom: 15px;
        border-bottom: 3px solid #8B6914;
        display: inline-block;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-top: 25px;
    }
    
    .form-group-full {
        grid-column: span 2;
    }
    
    .form-group {
        margin-bottom: 5px;
    }
    
    .form-group label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        color: #2c3e2f;
        margin-bottom: 10px;
        font-size: 14px;
    }
    
    .form-group label i {
        font-size: 16px;
    }
    
    .form-group label span {
        color: #e74c3c;
        margin-left: 4px;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e8ecef;
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.3s ease;
        box-sizing: border-box;
        background: #fafbfc;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #8B6914;
        background: white;
        box-shadow: 0 0 0 4px rgba(139, 105, 20, 0.1);
    }
    
    .form-control:hover {
        border-color: #c9a03d;
    }
    
    .hint {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .hint:before {
        content: "💡";
        font-size: 11px;
    }
    
    select.form-control {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238B6914' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px;
    }
    
    .file-input {
        position: relative;
        display: inline-block;
        width: 100%;
    }
    
    .file-input input[type="file"] {
        width: 100%;
        padding: 10px;
        background: #fafbfc;
        cursor: pointer;
        border: 2px solid #e8ecef;
        border-radius: 12px;
        font-size: 13px;
        color: #666;
    }
    
    .file-input input[type="file"]::file-selector-button {
        background: #8B6914;
        color: white;
        border: none;
        padding: 8px 18px;
        border-radius: 8px;
        cursor: pointer;
        margin-right: 12px;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .file-input input[type="file"]::file-selector-button:hover {
        background: #6B4F12;
        transform: translateY(-1px);
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
    
    .current-image img {
        border-radius: 10px;
        border: 1px solid #ddd;
        background: white;
        padding: 4px;
        object-fit: cover;
    }
    
    .current-image .image-name {
        font-size: 13px;
        color: #666;
        background: white;
        padding: 4px 10px;
        border-radius: 20px;
    }
    
    .btn-simpan {
        background: #8B6914;
        color: white;
        border: none;
        padding: 14px 28px;
        border-radius: 14px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        margin-top: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    
    .btn-simpan:hover {
        background: #6B4F12;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(139, 105, 20, 0.25);
    }
    
    .btn-simpan:active {
        transform: translateY(0);
    }
    
    .alert {
        padding: 12px 16px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    
    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .form-group-full {
            grid-column: span 1;
        }
        
        .card {
            padding: 20px;
        }
        
        h3 {
            font-size: 22px;
        }
    }
</style>

<div class="container-fix">
    <div class="card">
        <a href="<?= base_url('admin/menu') ?>" class="btn-back">
            ← Kembali
        </a>
        <form action="<?= base_url('admin/menu/update/' . $menu['id']) ?>" method="post" enctype="multipart/form-data">
            <!-- ========== CSRF TOKEN ========== -->
            <?= csrf_field() ?>
            
            <div class="form-grid">
                <div class="form-group">
                    <label>Nama Menu <span>*</span></label>
                    <input type="text" name="nama_menu" class="form-control" value="<?= esc($menu['nama_menu']) ?>" placeholder="Masukkan nama menu" required>
                    <div class="hint">Contoh: Nasi Goreng Special, Es Teh Manis</div>
                </div>

                <div class="form-group">
                    <label>Harga <span>*</span></label>
                    <input type="text" id="harga" name="harga" class="form-control" value="<?= number_format($menu['harga'], 0, ',', '.') ?>" placeholder="Rp 0" inputmode="numeric" required>
                    <div class="hint">Masukkan angka tanpa titik (contoh: 15000)</div>
                </div>

                <div class="form-group">
                    <label>Stok <span>*</span></label>
                    <input type="number" name="stok" class="form-control" value="<?= $menu['stok'] ?>" placeholder="Jumlah stok" required min="0" max="30">
                    <div class="hint">Jumlah ketersediaan menu (minimal 0, maksimal 30)</div>
                </div>

                <div class="form-group">
                    <label>Kategori <span>*</span></label>
                    <select name="kategori" class="form-control" required>
                        <option value="Makanan" <?= $menu['kategori'] == 'Makanan' ? 'selected' : '' ?>>🍚 Makanan</option>
                        <option value="Minuman" <?= $menu['kategori'] == 'Minuman' ? 'selected' : '' ?>>🥤 Minuman</option>
                        <option value="Dessert" <?= $menu['kategori'] == 'Dessert' ? 'selected' : '' ?>>🍰 Dessert</option>
                    </select>
                    <div class="hint">Pilih kategori yang sesuai</div>
                </div>

                <div class="form-group">
                    <label>Level Pedas</label>
                    <select name="ada_level" class="form-control">
                        <option value="0" <?= ($menu['ada_level'] ?? 0) == 0 ? 'selected' : '' ?>>🌶 Tidak</option>
                        <option value="1" <?= ($menu['ada_level'] ?? 0) == 1 ? 'selected' : '' ?>>🌶 Ada Level Pedas (1-5)</option>
                    </select>
                    <div class="hint">Pilih apakah menu ini memiliki level pedas</div>
                </div>

                <div class="form-group form-group-full">
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

                <div class="form-group form-group-full">
                    <label>Gambar Baru (Opsional)</label>
                    <div class="file-input">
                        <input type="file" name="gambar" class="form-control" accept="image/*" style="padding: 8px;">
                    </div>
                    <div class="hint">Format: JPG, PNG, JPEG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar</div>
                </div>
            </div>

            <button type="submit" class="btn-simpan">
                <i class="fa fa-save"></i> Update Menu
            </button>

        </form>
    </div>
</div>

<script>
    const hargaInput = document.getElementById('harga');

    hargaInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value) {
            let formatted = new Intl.NumberFormat('id-ID').format(value);
            this.value = formatted;
        } else {
            this.value = '';
        }
    });

    hargaInput.addEventListener('blur', function() {
        if (this.value === '') {
            this.value = '';
        }
    });

    document.querySelector("form").addEventListener("submit", function(e) {
        let rawValue = hargaInput.value.replace(/\./g, '');
        if (rawValue === '') {
            rawValue = '0';
        }
        hargaInput.value = rawValue;
    });
</script>

<?= $this->endSection() ?>