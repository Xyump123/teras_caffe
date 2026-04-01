<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    .card {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 25px;
    }

    h3 {
        margin-bottom: 20px;
    }

    .info-table td {
        padding: 8px 0;
        font-size: 15px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #000000;
        color: white;
        padding: 12px;
        text-align: left;
    }

    td {
        padding: 12px;
        border-bottom: 1px solid #eee;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: bold;
    }

    /* STATUS */
    .badge.pending {
        background: #fff3cd;
        color: #856404;
    }

    .badge.menunggu_konfirmasi {
        background: #cce5ff;
        color: #004085;
    }

    .badge.lunas {
        background: #d4edda;
        color: #155724;
    }

    /* METODE */
    .badge.qris {
        background: #cce5ff;
        color: #004085;
    }

    .badge.cash {
        background: #d4edda;
        color: #155724;
    }

    .menu-name {
        font-weight: 500;
    }

    .menu-option {
        font-size: 12px;
        color: #777;
    }

    .total-box {
        text-align: right;
        font-size: 18px;
        font-weight: bold;
        margin-top: 15px;
    }
</style>


<div class="card">

    <a href="<?= base_url('admin/transaksi') ?>">← Kembali</a>

    <h3>Detail Transaksi</h3>

    <table class="info-table">

        <tr>
            <td width="180"><b>ID Transaksi</b></td>
            <td>: <?= esc($transaksi['id']) ?></td>
        </tr>

        <tr>
            <td><b>No Meja</b></td>
            <td>: <?= esc($transaksi['meja']) ?></td>
        </tr>

        <tr>
            <td><b>Tipe Pembayaran</b></td>
            <td>: <?= strtoupper(esc($transaksi['tipe_pembayaran'] ?? '-')) ?></td>
        </tr>

        <tr>
            <td><b>Metode Pembayaran</b></td>
            <td>
                <span class="badge <?= strtolower($transaksi['metode_pembayaran']) ?>">
                    <?= strtoupper(esc($transaksi['metode_pembayaran'])) ?>
                </span>
            </td>
        </tr>

        <tr>
            <td><b>Total</b></td>
            <td>: Rp <?= number_format($transaksi['total'], 0, ',', '.') ?></td>
        </tr>

        <tr>
            <td><b>Status</b></td>
            <td>
                <span class="badge <?= strtolower($transaksi['status']) ?>">
                    <?= strtoupper($transaksi['status']) ?>
                </span>
            </td>
        </tr>

    </table>

</div>


<div class="card">

    <h3>Menu Yang Dipesan</h3>

    <table>

        <tr>
            <th>Menu</th>
            <th width="80">Qty</th>
            <th width="150">Harga</th>
            <th width="150">Subtotal</th>
        </tr>

        <?php if (!empty($detail)): ?>

            <?php foreach ($detail as $d): ?>

                <tr>

                    <td class="menu-name">

                        <?= esc($d['nama_menu']) ?>

                        <?php if (isset($d['level_pedas']) && $d['level_pedas'] != ''): ?>
                            <div class="menu-option">
                                Level Pedas : <?= esc($d['level_pedas']) ?>
                            </div>
                        <?php endif; ?>

                    </td>

                    <td><?= esc($d['qty']) ?></td>

                    <td>
                        Rp <?= number_format($d['harga'], 0, ',', '.') ?>
                    </td>

                    <td>
                        Rp <?= number_format($d['subtotal'], 0, ',', '.') ?>
                    </td>

                </tr>

            <?php endforeach; ?>

        <?php else: ?>

            <tr>
                <td colspan="4">Tidak ada data menu</td>
            </tr>

        <?php endif; ?>

    </table>

    <div class="total-box">
        Total : Rp <?= number_format($transaksi['total'], 0, ',', '.') ?>
    </div>

</div>

<?= $this->endSection() ?>