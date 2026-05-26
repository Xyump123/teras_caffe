<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    .edit-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        max-width: 700px;
        margin: 0 auto;
        overflow: hidden;
    }
    .edit-header {
        background: linear-gradient(135deg, #3b2a21, #6f4e37);
        padding: 25px;
        text-align: center;
    }
    .edit-header h3 {
        color: #fff;
        margin: 0;
        font-size: 20px;
    }
    .edit-header p {
        color: rgba(255,255,255,0.8);
        font-size: 12px;
        margin: 5px 0 0;
    }
    .avatar-area {
        text-align: center;
        margin-top: -40px;
        position: relative;
    }
    .avatar-preview {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .camera-btn {
        position: absolute;
        bottom: 0;
        right: 42%;
        background: #8B6914;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.3s;
    }
    .camera-btn:hover { background: #6B4F12; transform: scale(1.1); }
    .camera-btn i { color: #fff; font-size: 14px; }
    .form-body { padding: 25px; }
    .form-group { margin-bottom: 18px; }
    .form-group label { font-weight: 600; font-size: 13px; color: #555; margin-bottom: 6px; display: block; }
    .form-group label i { margin-right: 6px; color: #8B6914; }
    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        font-size: 13px;
        transition: 0.2s;
    }
    .form-control:focus {
        outline: none;
        border-color: #8B6914;
        box-shadow: 0 0 0 3px rgba(139,105,20,0.1);
    }
    textarea.form-control { min-height: 80px; resize: vertical; }
    .info-text { font-size: 10px; color: #999; margin-top: 4px; }
    .form-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 20px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }
    .btn-simpan {
        background: #8B6914;
        color: #fff;
        padding: 8px 20px;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        font-weight: 600;
        font-size: 13px;
        transition: 0.3s;
    }
    .btn-simpan:hover { background: #6B4F12; transform: translateY(-2px); }
    .btn-batal {
        background: #f5f5f5;
        color: #666;
        padding: 8px 20px;
        border-radius: 25px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-batal:hover { background: #eee; }
    @media (max-width: 600px) {
        .form-body { padding: 18px; }
        .camera-btn { right: 38%; }
    }
</style>

<div class="edit-card">
    <div class="edit-header">
    </div>

    <div class="avatar-area">
        <img id="preview" class="avatar-preview" 
             src="<?= session('foto') ? base_url('uploads/' . session('foto')) : 'https://ui-avatars.com/api/?name=' . urlencode(session('nama') ?? session('username')) . '&background=8B6914&color=fff' ?>">
        <label class="camera-btn" for="fotoInput">
            <i class="fa fa-camera"></i>
        </label>
    </div>

    <form action="<?= base_url('admin/update-profile') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <!-- ========== INPUT FILE UNTUK FOTO (Tersembunyi) ========== -->
        <input type="file" name="foto" id="fotoInput" accept="image/*" style="display: none;" onchange="previewImage(event)">
        
        <div class="form-body">
            <div class="form-group">
                <label><i class="fa fa-user"></i> Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="<?= session('nama') ?>" required>
            </div>
            <div class="form-group">
                <label><i class="fa fa-envelope"></i> Email</label>
                <input type="email" name="email" class="form-control" value="<?= session('email') ?>">
            </div>
            <div class="form-group">
                <label><i class="fa fa-pencil"></i> Bio</label>
                <textarea name="bio" class="form-control" placeholder="Tulis bio singkat..."><?= session('bio') ?></textarea>
                <div class="info-text">Ceritakan sedikit tentang diri Anda</div>
            </div>
            <div class="form-actions">
                <a href="<?= base_url('admin/profile') ?>" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
                <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('preview');
            if (preview) {
                preview.src = reader.result;
            }
        }
        if (event.target.files && event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
    
    // Trigger file input saat tombol kamera diklik
    document.querySelector('.camera-btn').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('fotoInput').click();
    });
</script>

<?= $this->endSection() ?>