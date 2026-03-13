<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="card">
    <a href="<?= base_url('admin/menu') ?>"></i> Kembali</a>
    <h3>Edit Menu</h3>
    <br>

    <form action="<?= base_url('admin/menu/update/' . $menu['id']) ?>"
        method="post" enctype="multipart/form-data">

        Nama Menu <br>
        <input type="text" name="nama_menu"
            value="<?= $menu['nama_menu'] ?>" required><br><br>

        Harga <br>
        <input type="text" id="harga" name="harga"
            value="<?= number_format($menu['harga'], 0, ',', '.') ?>" required>

        <br><br>

        Stok <br>
        <input type="number" name="stok"
            value="<?= $menu['stok'] ?>" required><br><br>

        Kategori
        <select name="kategori" required>
            <option value="Makanan" <?= $menu['kategori'] == 'Makanan' ? 'selected' : '' ?>>Makanan</option>
            <option value="Minuman" <?= $menu['kategori'] == 'Minuman' ? 'selected' : '' ?>>Minuman</option>
            <option value="Dessert" <?= $menu['kategori'] == 'Dessert' ? 'selected' : '' ?>>Dessert</option>
        </select>

        <br><br>

        Gambar Baru <br>
        <input type="file" name="gambar"><br><br>

        <button type="submit">Update</button>
    </form>
</div>

<script>
    const hargaInput = document.getElementById('harga');

    // format saat mengetik
    hargaInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        this.value = new Intl.NumberFormat('id-ID').format(value);
    });

    // sebelum form dikirim
    document.querySelector("form").addEventListener("submit", function() {
        hargaInput.value = hargaInput.value.replace(/\./g, '');
    });
</script>

<?= $this->endSection() ?>