<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    .card {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    h3 {
        margin-bottom: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #000;
        color: white;
        padding: 12px;
        text-align: left;
    }

    td {
        padding: 12px;
        border-bottom: 1px solid #eee;
        font-size: 14px;
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

    /* TIPE */

    .badge.meja {
        background: #e2e3ff;
        color: #383d8a;
    }

    .badge.kasir {
        background: #ffe0e0;
        color: #8a1f1f;
    }

    .action a {
        text-decoration: none;
        font-weight: 500;
    }
</style>


<div class="card">

    <h3>Daftar Transaksi</h3>
    <br>

    <table>

        <tr>
            <th width="60">ID</th>
            <th width="80">Meja</th>
            <th width="110">Tipe</th>
            <th width="110">Metode</th>
            <th width="130">Total</th>
            <th width="120">Status</th>
            <th width="160">Tanggal</th>
            <th width="120">Aksi</th>
        </tr>

        <?php if (!empty($transaksi)): ?>

            <?php foreach ($transaksi as $t): ?>

                <tr>

                    <td>#<?= esc($t['id']) ?></td>

                    <td><?= esc($t['meja']) ?></td>

                    <td>
                        <span class="badge <?= strtolower($t['tipe_pembayaran'] ?? 'meja') ?>">
                            <?= strtoupper($t['tipe_pembayaran'] ?? 'MEJA') ?>
                        </span>
                    </td>

                    <td>
                        <span class="badge <?= strtolower($t['metode_pembayaran']) ?>">
                            <?= strtoupper($t['metode_pembayaran']) ?>
                        </span>
                    </td>

                    <td>
                        Rp <?= number_format($t['total'], 0, ',', '.') ?>
                    </td>

                    <td>
                        <span class="badge <?= strtolower($t['status']) ?>">
                            <?= strtoupper($t['status']) ?>
                        </span>
                    </td>

                    <td>
                        <?= isset($t['created_at']) ? date('d-m-Y H:i', strtotime($t['created_at'])) : '-' ?>
                    </td>

                    <td class="action">

                        <a href="<?= base_url('admin/detail/' . $t['id']) ?>">
                            Detail
                        </a>

                        <?php if ($t['status'] == 'pending' || $t['status'] == 'menunggu_konfirmasi'): ?>

                            |

                            <a href="<?= base_url('admin/konfirmasi/' . $t['id']) ?>"
                                onclick="return confirm('Konfirmasi pembayaran dan kurangi stok?')">
                                Konfirmasi
                            </a>

                        <?php endif; ?>

                    </td>

                </tr>

            <?php endforeach; ?>

        <?php else: ?>

            <tr>
                <td colspan="8">Belum ada transaksi</td>
            </tr>

        <?php endif; ?>

    </table>

</div>

<?= $this->endSection() ?>