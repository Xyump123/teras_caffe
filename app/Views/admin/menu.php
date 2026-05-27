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
    
    /* TOMBOL TAMBAH WARNA COKLAT */
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
    color: #ffffff;  /* ← SUDAH PUTIH */
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
    
    /* TOMBOL AKSI WARNA COKLAT SEMUA */
    .aksi a {
        text-decoration: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        margin: 0 3px;
        display: inline-block;
        transition: all 0.3s ease;
    }
    
    /* Tombol Edit warna coklat */
    .edit {
        background: #8B6914; /* Coklat keemasan */
        color: white;
    }
    .edit:hover {
        background: #6B4F12;
        transform: translateY(-2px);
    }
    
    /* Tombol Hapus warna coklat kemerahan */
    .hapus {
        background: #8B3A3A; /* Coklat kemerahan */
        color: white;
    }
    .hapus:hover {
        background: #6B2C2C;
        transform: translateY(-2px);
    }
    
    /* Tambahan untuk efek hover pada baris */
    .aksi a:active {
        transform: translateY(0);
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
                <td><?= $m['nama_menu'] ?></td>
                <td>Rp <?= number_format($m['harga'], 0, ',', '.') ?></td>
                <td><?= $m['stok'] ?></td>
                <td><?= $m['kategori'] ?></td>
                <td class="aksi">
                    <a href="<?= base_url('admin/menu/edit/' . $m['id']) ?>" class="edit">Edit</a>
                    <a href="<?= base_url('admin/menu/hapus/' . $m['id']) ?>"
                        class="hapus"
                        onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>