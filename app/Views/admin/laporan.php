<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h2>Laporan Penjualan</h2>

<br>

<div class="card">

    <form method="post" style="display:flex; gap:20px; flex-wrap:wrap;">

        <div>
            <label>Harian</label>
            <br>
            <input type="date" name="tanggal">
        </div>

        <div>
            <label>Bulanan</label>
            <br>
            <input type="month" name="bulan">
        </div>

        <div>
            <label>Tahunan</label>
            <br>
            <input type="number" name="tahun" placeholder="2026">
        </div>

        <div style="align-self:flex-end;">
            <button type="submit">Filter</button>
        </div>

    </form>

</div>

<br>

<div style="display:flex; gap:20px; margin-bottom:30px;">

    <div class="card" style="flex:1;">
        <h4>Total Transaksi</h4>
        <h2><?= count($transaksi) ?></h2>
    </div>

    <div class="card" style="flex:1;">
        <h4>Total Pendapatan</h4>
        <h2>
            Rp <?= number_format(array_sum(array_column($transaksi, 'total')), 0, ',', '.') ?>
        </h2>
    </div>

</div>

<div class="card">

    <h3>Grafik Penjualan</h3>

    <canvas id="chartPenjualan"></canvas>

</div>

<br>

<div class="card">

    <h3>Data Transaksi</h3>

    <br>

    <table>

        <tr>
            <th>ID</th>
            <th>Meja</th>
            <th>Total</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>

        <?php foreach ($transaksi as $t): ?>

            <tr>

                <td>#<?= $t['id'] ?></td>

                <td><?= $t['meja'] ?></td>

                <td>
                    Rp <?= number_format($t['total'], 0, ',', '.') ?>
                </td>

                <td><?= strtoupper($t['status']) ?></td>

                <td><?= $t['created_at'] ?></td>

            </tr>

        <?php endforeach; ?>

    </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('chartPenjualan');

    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: <?= json_encode($label) ?>,

            datasets: [{
                label: 'Pendapatan',
                data: <?= json_encode($total) ?>,
                backgroundColor: '#7b553c'
            }]

        },

        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }

    });
</script>

<?= $this->endSection() ?>