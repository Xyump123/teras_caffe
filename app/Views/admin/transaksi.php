<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    .card {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        width: 100%;
        box-sizing: border-box;
    }

    h3 {
        margin: 0;
        font-size: 18px;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 10px;
    }

    /* TOMBOL TAMBAH - WARNA COKLAT */
    .btn-tambah {
        background: #8B6914;
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-tambah:hover {
        background: #6B4F12;
        transform: translateY(-2px);
    }

    /* TOMBOL EDIT - SAMA SEPERTI TAMBAH (WARNA COKLAT) */
    .btn-edit {
        background: #8B6914;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 11px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s ease;
    }

    .btn-edit:hover {
        background: #6B4F12;
        transform: translateY(-2px);
    }

    /* TOMBOL DETAIL */
    .btn-detail {
        background: #1e3a5f;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 11px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s ease;
    }

    .btn-detail:hover {
        background: #0f2b4a;
        transform: translateY(-2px);
    }

    /* TOMBOL KONFIRMASI */
    .btn-konfirmasi {
        background: #1a5a3a;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 11px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s ease;
    }

    .btn-konfirmasi:hover {
        background: #0f3d26;
        transform: translateY(-2px);
    }

    .table-wrapper {
        overflow-x: auto;
        width: 100%;
        position: relative;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 0;
    }

    th {
        background: #3b2a21;
        color: white;
        padding: 12px 12px;
        text-align: center;
        font-size: 13px;
        white-space: nowrap;
    }

    td {
        padding: 10px 12px;
        border-bottom: 1px solid #eee;
        font-size: 13px;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
    }

    @media (max-width: 1200px) {
        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        table {
            min-width: 900px;
        }
        th, td {
            padding: 8px 10px;
        }
    }

    .badge {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: bold;
        white-space: nowrap;
        display: inline-block;
    }

    .badge.pending { background: #fff3cd; color: #856404; }
    .badge.menunggu_konfirmasi { background: #cce5ff; color: #004085; }
    .badge.lunas { background: #d4edda; color: #155724; }
    .badge.qris { background: #cce5ff; color: #004085; }
    .badge.cash { background: #d4edda; color: #155724; }
    .badge.meja { background: #e2e3ff; color: #383d8a; }
    .badge.kasir { background: #ffe0e0; color: #8a1f1f; }

    .action {
        white-space: nowrap;
    }

    .empty-row td {
        text-align: center;
        padding: 40px;
        color: #999;
    }

    .col-id { width: 70px; }
    .col-meja { width: 70px; }
    .col-tipe { width: 100px; }
    .col-metode { width: 100px; }
    .col-total { width: 130px; }
    .col-status { width: 120px; }
    .col-tanggal { width: 150px; }
    .col-aksi { min-width: 250px; }
</style>

<div class="card">
    <div class="header">
        <h3>Daftar Transaksi</h3>
        <a href="<?= base_url('admin/transaksi/tambah') ?>" class="btn-tambah">
            + Tambah Transaksi
        </a>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th class="col-id">ID</th>
                    <th class="col-meja">Meja</th>
                    <th class="col-tipe">Tipe</th>
                    <th class="col-metode">Metode</th>
                    <th class="col-total">Total</th>
                    <th class="col-status">Status</th>
                    <th class="col-tanggal">Tanggal</th>
                    <th class="col-aksi">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($transaksi)): ?>
                    <?php foreach ($transaksi as $t): ?>
                        <tr>
                            <td class="col-id"><strong>#<?= esc($t['id']) ?></strong></td>
                            <td class="col-meja"><?= esc($t['meja']) ?></td>
                            <td class="col-tipe">
                                <span class="badge <?= strtolower($t['tipe_pembayaran'] ?? 'meja') ?>">
                                    <?= strtoupper($t['tipe_pembayaran'] ?? 'MEJA') ?>
                                </span>
                            </td>
                            <td class="col-metode">
                                <span class="badge <?= strtolower($t['metode_pembayaran'] ?? 'cash') ?>">
                                    <?= strtoupper($t['metode_pembayaran'] ?? 'CASH') ?>
                                </span>
                            </td>
                            <td class="col-total">Rp <?= number_format($t['total'], 0, ',', '.') ?></td>
                            <td class="col-status">
                                <span class="badge <?= strtolower($t['status']) ?>">
                                    <?= strtoupper($t['status']) ?>
                                </span>
                            </td>
                            <td class="col-tanggal"><?= date('d-m-Y H:i', strtotime($t['created_at'])) ?></td>
                            <td class="col-aksi action">
                                <a href="<?= base_url('admin/transaksi/detail/' . $t['id']) ?>" class="btn-detail">Detail</a>
                                <a href="<?= base_url('admin/transaksi/edit/' . $t['id']) ?>" class="btn-edit">Edit</a>
                                <?php if ($t['status'] != 'lunas'): ?>
                                    <a href="<?= base_url('admin/transaksi/konfirmasi/' . $t['id']) ?>"
                                       class="btn-konfirmasi"
                                       onclick="return confirm('Konfirmasi pembayaran dan kurangi stok?')">Konfirmasi</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr class="empty-row">
                        <td colspan="8">Belum ada transaksi</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>