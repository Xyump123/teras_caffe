<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 14px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stat-info h4 {
        margin: 0;
        font-size: 14px;
        color: #777;
    }

    .stat-info h2 {
        margin-top: 5px;
        font-size: 26px;
        color: #3b2a21;
    }

    .stat-icon {
        font-size: 28px;
        background: #f3efe7;
        padding: 12px;
        border-radius: 10px;
        color: #6f4e37;
    }

    .table-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .empty {
        text-align: center;
        padding: 30px;
        color: #888;
    }
</style>

<?php
$totalTransaksi = count($transaksi);
$totalPendapatan = array_sum(array_column($transaksi, 'total'));
$totalLunas = count(array_filter($transaksi, function ($t) {
    return strtolower($t['status']) == 'lunas';
}));
$totalPending = count(array_filter($transaksi, function ($t) {
    return strtolower($t['status']) == 'pending';
}));
?>

<div class="stat-grid">

    <div class="stat-card">
        <div class="stat-info">
            <h4>Total Transaksi</h4>
            <h2><?= $totalTransaksi ?></h2>
        </div>
        <div class="stat-icon">
            <i class="fa fa-receipt"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h4>Total Pendapatan</h4>
            <h2>Rp <?= number_format($totalPendapatan, 0, ',', '.') ?></h2>
        </div>
        <div class="stat-icon">
            <i class="fa fa-money-bill"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h4>Transaksi Lunas</h4>
            <h2><?= $totalLunas ?></h2>
        </div>
        <div class="stat-icon">
            <i class="fa fa-check-circle"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h4>Transaksi Pending</h4>
            <h2><?= $totalPending ?></h2>
        </div>
        <div class="stat-icon">
            <i class="fa fa-clock"></i>
        </div>
    </div>

</div>

<div class="card">

    <div class="table-title">
        <h3>Data Transaksi Terbaru</h3>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Meja</th>
            <th>Total</th>
            <th>Status</th>
        </tr>

        <?php if (empty($transaksi)): ?>

            <tr>
                <td colspan="4" class="empty">
                    Belum ada transaksi
                </td>
            </tr>

        <?php else: ?>

            <?php foreach ($transaksi as $t): ?>

                <tr>
                    <td>#<?= $t['id'] ?></td>
                    <td><?= $t['meja'] ?></td>
                    <td>Rp <?= number_format($t['total'], 0, ',', '.') ?></td>
                    <td>
                        <span class="badge <?= strtolower($t['status']) ?>">
                            <?= strtoupper($t['status']) ?>
                        </span>
                    </td>
                </tr>

            <?php endforeach; ?>

        <?php endif; ?>

    </table>

</div>

<?= $this->endSection() ?>