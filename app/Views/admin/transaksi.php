<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    /* PERBAIKAN UTAMA - PASTIKAN CONTAINER FULL WIDTH */
    .content-wrapper {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
    }
    
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

    .btn-tambah {
        background: #1e3a5f;
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
        background: #0f2b4a;
        transform: translateY(-2px);
    }

    /* TABLE RESPONSIVE - SCROLL HORIZONTAL TIDAK MERUSAK LAYOUT */
    .table-wrapper {
        overflow-x: auto;
        width: 100%;
        margin: 0 -0px;
        position: relative;
    }

    /* HILANGKAN min-width AGAR TABEL MENGIKUTI LEBAR KONTAINER */
    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 0; /* GANTI DARI 1000px MENJADI 0 */
    }

    th {
        background: #000;
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

    /* RESPONSIVE UNTUK LAYAR KECIL */
    @media (max-width: 1200px) {
        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        table {
            min-width: 900px; /* BERLAKU SAAT LAYAR KECIL */
        }
        
        th, td {
            padding: 8px 10px;
        }
    }

    /* BADGE */
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

    /* TOMBOL ACTION */
    .action {
        white-space: nowrap;
    }

    .action a {
        text-decoration: none;
        font-weight: 500;
        padding: 5px 10px;
        border-radius: 4px;
        margin: 0 2px;
        display: inline-block;
        font-size: 11px;
        transition: all 0.3s ease;
    }

    .btn-detail { background: #1e3a5f; color: white; }
    .btn-detail:hover { background: #0f2b4a; transform: translateY(-2px); }

    .btn-edit { background: #4a3a2a; color: white; }
    .btn-edit:hover { background: #332618; transform: translateY(-2px); }

    .btn-hapus { background: #5a2a2a; color: white; }
    .btn-hapus:hover { background: #3d1c1c; transform: translateY(-2px); }

    .btn-konfirmasi { background: #1a5a3a; color: white; }
    .btn-konfirmasi:hover { background: #0f3d26; transform: translateY(-2px); }

    .empty-row td {
        text-align: center;
        padding: 40px;
        color: #999;
    }

    /* LEBAR KOLOM YANG LEBIH FLEKSIBEL */
    .col-id { width: 70px; }
    .col-meja { width: 70px; }
    .col-tipe { width: 100px; }
    .col-metode { width: 100px; }
    .col-total { width: 130px; }
    .col-status { width: 120px; }
    .col-tanggal { width: 150px; }
    .col-aksi { min-width: 250px; } /* GANTI width JADI min-width */
</style>

<div class="card">
    <div class="header">
        <h3>📋 Daftar Transaksi</h3>
        <a href="<?= base_url('admin/transaksi/tambah') ?>" class="btn-tambah">
            + Tambah Transaksi Manual
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
                                <a href="<?= base_url('admin/transaksi/detail/' . $t['id']) ?>" class="btn-detail">🔍 Detail</a>
                                <a href="<?= base_url('admin/transaksi/edit/' . $t['id']) ?>" class="btn-edit">✏️ Edit</a>
                                <a href="<?= base_url('admin/transaksi/hapus/' . $t['id']) ?>" 
                                   class="btn-hapus"
                                   onclick="return confirm('Yakin ingin menghapus transaksi ini?')">🗑 Hapus</a>
                                <?php if ($t['status'] != 'lunas'): ?>
                                    <a href="<?= base_url('admin/transaksi/konfirmasi/' . $t['id']) ?>"
                                       class="btn-konfirmasi"
                                       onclick="return confirm('Konfirmasi pembayaran dan kurangi stok?')">✅ Konfirmasi</a>
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