<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h3>Daftar Menu</h3>
        <a href="<?= base_url('admin/menu/tambah') ?>"
            style="background:#4b2e2e; color:white; padding:8px 15px; border-radius:8px; text-decoration:none;">
            + Tambah Menu
        </a>
    </div>

    <br>

    <table>
        <tr>
            <th>Gambar</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Kategori</th>
            <th>Aksi</th>
        </tr>

        <?php foreach ($menu as $m): ?>
            <tr>
                <td>
                    <?php if ($m['gambar']): ?>
                        <img src="<?= base_url('uploads/' . $m['gambar']) ?>" width="60">
                    <?php endif; ?>
                </td>
                <td><?= $m['nama_menu'] ?></td>
                <td>Rp <?= number_format($m['harga'], 0, ',', '.') ?></td>
                <td><?= $m['stok'] ?></td>
                <td><?= $m['kategori'] ?></td>
                <td>
                    <a href="<?= base_url('admin/menu/edit/' . $m['id']) ?>">Edit</a> |
                    <a href="<?= base_url('admin/menu/hapus/' . $m['id']) ?>"
                        onclick="return confirm('Yakin hapus?')">
                        Hapus
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?= $this->endSection() ?>