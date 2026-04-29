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
        width: 100%;
        box-sizing: border-box;
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
    
    .btn-simpan {
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
    
    .btn-simpan:hover {
        background: #6B4F12;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 105, 20, 0.3);
    }
    
    .btn-simpan:active {
        transform: translateY(0);
    }
    
    .alert {
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
    }
    
    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
</style>

<div class="container-fix">
    <div class="card">
        <a href="<?= base_url('admin/menu') ?>" class="btn-back">
            ← Kembali
        </a>

        <h3>Tambah Menu</h3>
        
        <div style="margin: 20px 0;"></div>

        <form action="<?= base_url('admin/menu/simpan') ?>" method="post" enctype="multipart/form-data">
            
            <div class="form-group">
                <label>Nama Menu <span>*</span></label>
                <input type="text" name="nama_menu" placeholder="Masukkan nama menu" required>
                <div class="hint">Contoh: Nasi Goreng, Es Teh Manis, dll.</div>
            </div>

            <div class="form-group">
                <label>Harga <span>*</span></label>
                <input type="text" id="harga" name="harga" placeholder="Rp 0" inputmode="numeric" required>
                <div class="hint">Masukkan angka tanpa titik, contoh: 15000</div>
            </div>

            <div class="form-group">
                <label>Stok <span>*</span></label>
                <input type="number" name="stok" placeholder="Masukkan jumlah stok" required>
                <div class="hint">Jumlah ketersediaan menu (minimal 0)</div>
            </div>

            <div class="form-group">
                <label>Kategori <span>*</span></label>
                <select name="kategori" required>
                    <option value="" disabled selected>-- Pilih Kategori --</option>
                    <option value="Makanan">🍚 Makanan</option>
                    <option value="Minuman">🥤 Minuman</option>
                    <option value="Dessert">🍰 Dessert</option>
                </select>
                <div class="hint">Pilih kategori yang sesuai dengan menu</div>
            </div>

            <div class="form-group">
                <label>Gambar</label>
                <div class="file-input">
                    <input type="file" name="gambar" accept="image/*">
                </div>
                <div class="hint">Format: JPG, PNG, JPEG. Maksimal 2MB</div>
            </div>

            <button type="submit" class="btn-simpan">
                Simpan Menu
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