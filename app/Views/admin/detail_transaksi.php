<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="card">
    <h3>Detail Transaksi #<?= $transaksi['id'] ?></h3>
    <a href="<?= base_url('admin/transaksi') ?>">← Kembali</a>
    
    <table style="margin-top: 20px;">
        <tr><td width="150">Meja</td><td>: <?= $transaksi['meja'] ?></td></tr>
        <tr><td>Metode Pembayaran</td><td>: <?= strtoupper($transaksi['metode_pembayaran']) ?></td></tr>
        <tr><td>Tipe Pembayaran</td><td>: <?= strtoupper($transaksi['tipe_pembayaran'] ?? 'MEJA') ?></td></tr>
        <tr><td>Status</td><td>: <?= strtoupper($transaksi['status']) ?></td></tr>
        <tr><td>Tanggal</td><td>: <?= $transaksi['created_at'] ?></td></tr>
    </table>

    <h4>Daftar Pesanan</h4>
    <table>
        <thead>
            <tr><th>Menu</th><th>Qty</th><th>Level Pedas</th><th>Harga</th><th>Subtotal</th></tr>
        </thead>
        <tbody>
            <?php foreach ($detail as $d): ?>
            <tr>
                <td><?= $d['nama_menu'] ?></td>
                <td><?= $d['qty'] ?></td>
                <td><?= $d['level_pedas'] ? "Level {$d['level_pedas']}" : '-' ?></td>
                <td>Rp <?= number_format($d['harga'], 0, ',', '.') ?></td>
                <td>Rp <?= number_format($d['subtotal'], 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3 style="text-align: right; margin-top: 20px;">Total: Rp <?= number_format($transaksi['total'], 0, ',', '.') ?></h3>
</div>

<?= $this->endSection() ?>