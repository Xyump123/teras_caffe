<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="container-fix">
    <div class="card">
        <a href="<?= base_url('admin/menu') ?>"></i> Kembali</a>
        <h3>Tambah Menu</h3>
        <br>

        <form action="<?= base_url('admin/menu/simpan') ?>" method="post" enctype="multipart/form-data">

            Nama Menu
            <input type="text" name="nama_menu" required>

            <br><br>

            Harga
            <input type="text" id="harga" name="harga" inputmode="numeric" required>

            <br><br>

            Stok
            <input type="number" name="stok" required>

            <br><br>

            Kategori
            <select name="kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Makanan">Makanan</option>
                <option value="Minuman">Minuman</option>
                <option value="Dessert">Dessert</option>
            </select>

            <br><br>

            Gambar
            <input type="file" name="gambar">

            <br><br>

            <button type="submit">Simpan</button>

        </form>

    </div>
</div>

<script>
    const hargaInput = document.getElementById('harga');

    // format saat mengetik
    hargaInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        this.value = new Intl.NumberFormat('id-ID').format(value);
    });

    // sebelum form dikirim ke server
    document.querySelector("form").addEventListener("submit", function() {
        hargaInput.value = hargaInput.value.replace(/\./g, '');
    });
</script>

<?= $this->endSection() ?>