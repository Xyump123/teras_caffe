<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="card">

    <h3>Daftar Transaksi</h3>
    <br>

    <table>
        <tr>
            <th>ID</th>
            <th>Meja</th>
            <th>Total</th>
            <th>Metode</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>

        <?php foreach ($transaksi as $t): ?>
            <tr>
                <td>#<?= $t['id'] ?></td>
                <td><?= $t['meja'] ?></td>
                <td>Rp <?= number_format($t['total'], 0, ',', '.') ?></td>
                <td><?= $t['metode_pembayaran'] ?></td>
                <td>
                    <span class="badge <?= strtolower($t['status']) ?>">
                        <?= strtoupper($t['status']) ?>
                    </span>
                </td>
                <td><?= date('d-m-Y H:i', strtotime($t['created_at'])) ?></td>
                <td>

                    <a href="<?= base_url('admin/detail/' . $t['id']) ?>">
                        Detail
                    </a>

                    <?php if ($t['status'] == 'pending' || $t['status'] == 'menunggu_konfirmasi'): ?>
                        |
                        <a href="<?= base_url('admin/konfirmasi/' . $t['id']) ?>"
                            onclick="return confirm('Konfirmasi pembayaran & kurangi stok?')">
                            Konfirmasi
                        </a>
                    <?php endif; ?>

                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</div>

<?= $this->endSection() ?>