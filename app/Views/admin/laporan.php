<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    .card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }

    .filter-form {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        align-items: flex-end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .filter-group label {
        font-size: 12px;
        font-weight: 600;
        color: #555;
    }

    .filter-group input, .filter-group select {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

    .btn-filter {
        background: #3b2a21;
        color: white;
        padding: 8px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-filter:hover {
        background: #5a3c2e;
    }

    .stats {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .stat-card {
        flex: 1;
        text-align: center;
    }

    .stat-card h4 {
        margin: 0 0 5px 0;
        font-size: 14px;
        color: #666;
    }

    .stat-card h2 {
        margin: 0;
        font-size: 28px;
        color: #3b2a21;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #3b2a21;
        color: white;
        padding: 10px;
        text-align: left;
        font-size: 13px;
    }

    td {
        padding: 8px 10px;
        border-bottom: 1px solid #eee;
        font-size: 13px;
    }

    tr:hover {
        background: #faf7f2;
    }

    .badge {
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge.pending { background: #fff3cd; color: #856404; }
    .badge.menunggu_konfirmasi { background: #cce5ff; color: #004085; }
    .badge.lunas { background: #d4edda; color: #155724; }

    /* PAGINATION */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 5px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .pagination a, .pagination span {
        padding: 6px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-decoration: none;
        color: #3b2a21;
        font-size: 13px;
    }

    .pagination a:hover {
        background: #3b2a21;
        color: white;
        border-color: #3b2a21;
    }

    .pagination .active {
        background: #3b2a21;
        color: white;
        border-color: #3b2a21;
    }

    .pagination .disabled {
        color: #ccc;
        pointer-events: none;
    }

    .info {
        text-align: center;
        margin-top: 10px;
        font-size: 12px;
        color: #666;
    }
</style>

<h2>Laporan Penjualan</h2>

<!-- FORM FILTER (TIDAK DIUBAH) -->
<div class="card">
    <form method="post" class="filter-form">
        <div class="filter-group">
            <label>Harian</label>
            <input type="date" name="tanggal" value="<?= $tanggal ?? '' ?>">
        </div>
        <div class="filter-group">
            <label>Bulanan</label>
            <input type="month" name="bulan" value="<?= $bulan ?? '' ?>">
        </div>
        <div class="filter-group">
            <label>Tahunan</label>
            <input type="number" name="tahun" placeholder="2026" value="<?= $tahun ?? '' ?>">
        </div>
        <div class="filter-group">
            <button type="submit" class="btn-filter">Filter</button>
        </div>
    </form>
</div>

<!-- STATISTIK (TIDAK DIUBAH) -->
<div class="stats">
    <div class="card stat-card">
        <h4>Total Transaksi</h4>
        <h2><?= number_format($totalTransaksi) ?></h2>
    </div>
    <div class="card stat-card">
        <h4>Total Pendapatan</h4>
        <h2>Rp <?= number_format($totalPendapatan, 0, ',', '.') ?></h2>
    </div>
</div>

<!-- GRAFIK (TIDAK DIUBAH) -->
<div class="card">
    <h3> Grafik Penjualan</h3>
    <canvas id="chartPenjualan" height="100"></canvas>
</div>

<!-- DATA TRANSAKSI DENGAN PAGINATION (HANYA INI YANG DIUBAH) -->
<div class="card">
    <h3>Data Transaksi</h3>
    
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Meja</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($transaksiPerPage)): ?>
                    <?php foreach ($transaksiPerPage as $t): ?>
                        <tr>
                            <td>#<?= $t['id'] ?></td>
                            <td><?= $t['meja'] ?></td>
                            <td>Rp <?= number_format($t['total'], 0, ',', '.') ?></td>
                            <td>
                                <span class="badge <?= strtolower($t['status']) ?>">
                                    <?= strtoupper($t['status']) ?>
                                </span>
                            </td>
                            <td><?= date('d-m-Y H:i', strtotime($t['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr class="empty-row">
                        <td colspan="5" style="text-align: center;">Tidak ada data transaksi</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- PAGINATION (TAMBAHAN) -->
    <?php if ($totalHalaman > 1): ?>
    <div class="pagination">
        <?php if ($halamanAktif > 1): ?>
            <a href="?page=<?= $halamanAktif - 1 ?>&<?= http_build_query($queryParams) ?>">« Sebelumnya</a>
        <?php else: ?>
            <span class="disabled">« Sebelumnya</span>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalHalaman; $i++): ?>
            <?php if ($i == $halamanAktif): ?>
                <span class="active"><?= $i ?></span>
            <?php else: ?>
                <a href="?page=<?= $i ?>&<?= http_build_query($queryParams) ?>"><?= $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($halamanAktif < $totalHalaman): ?>
            <a href="?page=<?= $halamanAktif + 1 ?>&<?= http_build_query($queryParams) ?>">Selanjutnya »</a>
        <?php else: ?>
            <span class="disabled">Selanjutnya »</span>
        <?php endif; ?>
    </div>
    <div class="info">
        Menampilkan <?= $mulai + 1 ?> - <?= min($mulai + $perPage, $totalTransaksi) ?> dari <?= $totalTransaksi ?> transaksi
    </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartPenjualan');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($label) ?>,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: <?= json_encode($total) ?>,
                backgroundColor: '#7b553c',
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>

<?= $this->endSection() ?>