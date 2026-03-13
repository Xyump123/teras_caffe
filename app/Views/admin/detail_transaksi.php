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

    .badge.pending {
        background: #fff3cd;
        color: #856404;
    }

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

    <a href="<?= base_url('admin/menu') ?>"></i> Kembali</a>
    <h3>Edit Menu</h3>

    <h3>Detail Transaksi</h3>

    <table class="info-table">

        <tr>
            <td width="150"><b>ID Transaksi</b></td>
            <td>: <?= $transaksi['id'] ?></td>
        </tr>

        <tr>
            <td><b>Meja</b></td>
            <td>: <?= $transaksi['meja'] ?></td>
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

        <?php foreach ($detail as $d): ?>

            <tr>

                <td class="menu-name">
                    <?= $d['nama_menu'] ?>

                    <?php if (isset($d['level_pedas']) && $d['level_pedas'] != ''): ?>
                        <div class="menu-option">
                            Level Pedas : <?= $d['level_pedas'] ?>
                        </div>
                    <?php endif; ?>

                </td>

                <td><?= $d['qty'] ?></td>

                <td>
                    Rp <?= number_format($d['harga'], 0, ',', '.') ?>
                </td>

                <td>
                    Rp <?= number_format($d['subtotal'], 0, ',', '.') ?>
                </td>

            </tr>

        <?php endforeach; ?>

    </table>

    <div class="total-box">
        Total : Rp <?= number_format($transaksi['total'], 0, ',', '.') ?>
    </div>

</div>

<?= $this->endSection() ?>