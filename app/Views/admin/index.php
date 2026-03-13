<h2>Dashboard Transaksi</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Meja</th>
        <th>Total</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    <?php foreach ($transaksi as $t): ?>
        <tr>
            <td><?= $t['id'] ?></td>
            <td><?= $t['meja'] ?></td>
            <td>Rp <?= number_format($t['total'], 0, ',', '.') ?></td>
            <td><?= strtoupper($t['status']) ?></td>
            <td>
                <?php if ($t['status'] == 'menunggu_konfirmasi'): ?>
                    <a href="<?= base_url('admin/konfirmasi/' . $t['id']) ?>">
                        Konfirmasi Lunas
                    </a>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>