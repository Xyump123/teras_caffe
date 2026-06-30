<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    .card {
        background: #ffffff;
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
    }
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .header h3 {
        margin: 0;
        font-weight: 600;
        color: #333;
    }
    
    .btn-tambah {
        background: #8B6914; 
        color: #fff;
        padding: 10px 18px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-tambah:hover {
        background: #6B4F12; 
        transform: translateY(-2px);
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    thead {
        background: #000; 
        font-weight: 600;
        color: #ffffff;
    }
    th, td {
        padding: 12px 10px;
        text-align: center;
    }
    th {
        background: #60450b; 
    }
    tbody tr {
        border-bottom: 1px solid #eee;
        transition: 0.2s;
    }
    tbody tr:hover {
        background: #fafafa;
    }
    img {
        border-radius: 8px;
    }
    
    .aksi a {
        text-decoration: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        margin: 0 3px;
        display: inline-block;
        transition: all 0.3s ease;
    }
    
    .edit {
        background: #8B6914;
        color: white;
    }
    .edit:hover {
        background: #6B4F12;
        transform: translateY(-2px);
    }
    
    .hapus {
        background: #8B3A3A;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .hapus:hover {
        background: #6B2C2C;
        transform: translateY(-2px);
    }
    
    .aksi a:active {
        transform: translateY(0);
    }
    
    /* Toast notification */
    .toast-container {
        position: fixed;
        top: 80px;
        right: 20px;
        z-index: 99999;
    }
    .toast {
        padding: 12px 20px;
        margin-bottom: 10px;
        border-radius: 8px;
        font-size: 13px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        animation: slideIn 0.3s ease;
        min-width: 200px;
        max-width: 400px;
    }
    .toast.success { background: #d4edda; color: #155724; border-left: 4px solid #28a745; }
    .toast.error { background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545; }
    .toast.info { background: #cce5ff; color: #004085; border-left: 4px solid #17a2b8; }
    
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(50px); }
        to { opacity: 1; transform: translateX(0); }
    }
</style>

<div class="card">
    <div class="header">
        <h3>Daftar Menu</h3>
        <a href="<?= base_url('admin/menu/tambah') ?>" class="btn-tambah">
            + Tambah Menu
        </a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($menu as $m): ?>
            <tr>
                <td>
                    <?php if ($m['gambar']): ?>
                        <img src="<?= base_url('uploads/' . $m['gambar']) ?>" 
                             onerror="this.src='<?= base_url('uploads/default.jpg') ?>'"
                             width="60">
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td><?= esc($m['nama_menu']) ?></td>
                <td>Rp <?= number_format($m['harga'], 0, ',', '.') ?></td>
                <td><?= $m['stok'] ?></td>
                <td><?= $m['kategori'] ?></td>
                <td class="aksi">
                    <a href="<?= base_url('admin/menu/edit/' . $m['id']) ?>" class="edit">Edit</a>
                    <button type="button" class="hapus" data-id="<?= $m['id'] ?>" data-nama="<?= esc($m['nama_menu']) ?>">Hapus</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
// ==================== TOAST NOTIFICATION ====================
function showToast(type, message) {
    let container = document.getElementById('toastContainer');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toastContainer';
        container.style.cssText = 'position:fixed; top:80px; right:20px; z-index:99999;';
        document.body.appendChild(container);
    }
    
    const toast = document.createElement('div');
    const colors = {
        success: 'background: #d4edda; color: #155724; border-left: 4px solid #28a745;',
        error: 'background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545;',
        info: 'background: #cce5ff; color: #004085; border-left: 4px solid #17a2b8;'
    };
    
    toast.style.cssText = `
        padding: 12px 20px;
        margin-bottom: 10px;
        border-radius: 8px;
        font-size: 13px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        animation: slideIn 0.3s ease;
        min-width: 200px;
        max-width: 400px;
        ${colors[type] || colors.info}
    `;
    toast.innerHTML = message;
    
    container.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(50px)';
        toast.style.transition = 'all 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// ==================== HAPUS MENU ====================
document.querySelectorAll('.hapus').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.dataset.id;
        const nama = this.dataset.nama;
        
        if (confirm(`⚠️ Yakin ingin menghapus menu "${nama}"?`)) {
            // Redirect ke URL hapus
            window.location.href = '<?= base_url('admin/menu/hapus') ?>/' + id;
        }
    });
});

// Cek jika ada flash message dari session
<?php if (session()->getFlashdata('success')): ?>
    showToast('success', '✅ <?= session()->getFlashdata('success') ?>');
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    showToast('error', '❌ <?= session()->getFlashdata('error') ?>');
<?php endif; ?>
</script>

<?= $this->endSection() ?>