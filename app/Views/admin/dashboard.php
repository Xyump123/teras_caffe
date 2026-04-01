<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    /* ================= ANIMATION ================= */
    @keyframes cardEnter {
        0% {
            opacity: 0;
            transform: translateY(30px) scale(0.95);
        }

        60% {
            opacity: 1;
            transform: translateY(-5px) scale(1.02);
        }

        100% {
            transform: translateY(0) scale(1);
            opacity: 1;
        }
    }

    /* ================= STAT ================= */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        position: relative;
        background: white;
        padding: 20px;
        border-radius: 14px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.3s ease;

        opacity: 0;
        animation: cardEnter 0.7s ease forwards;
    }

    .delay-1 {
        animation-delay: 0.1s;
    }

    .delay-2 {
        animation-delay: 0.2s;
    }

    .delay-3 {
        animation-delay: 0.3s;
    }

    .delay-4 {
        animation-delay: 0.4s;
    }

    .delay-5 {
        animation-delay: 0.5s;
    }

    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    /* glow */
    .stat-card::after {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 14px;
        opacity: 0;
        transition: 0.3s;
        box-shadow: 0 0 20px rgba(111, 78, 55, 0.2);
    }

    .stat-card:hover::after {
        opacity: 1;
    }

    .stat-info h4 {
        margin: 0;
        font-size: 14px;
        color: #777;
    }

    .stat-info h2 {
        margin-top: 5px;
        font-size: 24px;
        color: #3b2a21;
    }

    .stat-icon {
        font-size: 24px;
        background: #f3efe7;
        padding: 12px;
        border-radius: 10px;
        color: #6f4e37;
        transition: 0.4s;
    }

    .stat-card:hover .stat-icon {
        transform: rotate(8deg) scale(1.15);
    }

    /* ================= TABLE ================= */
    .card {
        background: #fff;
        padding: 25px;
        border-radius: 14px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        animation: cardEnter 0.7s ease forwards;
        animation-delay: 0.6s;
        opacity: 0;
    }

    .table-title {
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
        transition: 0.2s;
    }

    tr:hover td {
        background: #fafafa;
    }

    .empty {
        text-align: center;
        padding: 30px;
        color: #888;
    }

    /* ================= BADGE ================= */
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

    .badge.menunggu_konfirmasi {
        background: #cce5ff;
        color: #004085;
    }

    .badge.lunas {
        background: #d4edda;
        color: #155724;
    }

    .badge.qris {
        background: #cce5ff;
        color: #004085;
    }

    .badge.cash {
        background: #d4edda;
        color: #155724;
    }

    .badge.meja {
        background: #e2e3ff;
        color: #383d8a;
    }

    .badge.kasir {
        background: #ffe0e0;
        color: #8a1f1f;
    }
</style>

<?php
$totalTransaksi = count($transaksi);

$totalPendapatan = array_sum(array_column(
    array_filter($transaksi, fn($t) => strtolower($t['status']) == 'lunas'),
    'total'
));

$totalLunas = count(array_filter($transaksi, fn($t) => strtolower($t['status']) == 'lunas'));
$totalPending = count(array_filter($transaksi, fn($t) => strtolower($t['status']) == 'pending'));
$totalMenunggu = count(array_filter($transaksi, fn($t) => strtolower($t['status']) == 'menunggu_konfirmasi'));
?>

<!-- ================= STAT ================= -->
<div class="stat-grid">
    <div class="stat-card delay-1">
        <div class="stat-info">
            <h4>Total Transaksi</h4>
            <h2 class="count" data-target="<?= $totalTransaksi ?>">0</h2>
        </div>
        <div class="stat-icon"><i class="fa fa-receipt"></i></div>
    </div>

    <div class="stat-card delay-2">
        <div class="stat-info">
            <h4>Pendapatan</h4>
            <h2 class="count" data-target="<?= $totalPendapatan ?>">0</h2>
        </div>
        <div class="stat-icon"><i class="fa fa-money-bill"></i></div>
    </div>

    <div class="stat-card delay-3">
        <div class="stat-info">
            <h4>Lunas</h4>
            <h2 class="count" data-target="<?= $totalLunas ?>">0</h2>
        </div>
        <div class="stat-icon"><i class="fa fa-check-circle"></i></div>
    </div>

    <div class="stat-card delay-4">
        <div class="stat-info">
            <h4>Pending</h4>
            <h2 class="count" data-target="<?= $totalPending ?>">0</h2>
        </div>
        <div class="stat-icon"><i class="fa fa-clock"></i></div>
    </div>

    <div class="stat-card delay-5">
        <div class="stat-info">
            <h4>Menunggu</h4>
            <h2 class="count" data-target="<?= $totalMenunggu ?>">0</h2>
        </div>
        <div class="stat-icon"><i class="fa fa-hourglass-half"></i></div>
    </div>
</div>

<!-- ================= TABLE ================= -->
<div class="card">
    <div class="table-title">
        <h3>Data Transaksi Terbaru</h3>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Meja</th>
            <th>Tipe</th>
            <th>Metode</th>
            <th>Total</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>

        <?php if (empty($transaksi)): ?>
            <tr>
                <td colspan="7" class="empty">Belum ada transaksi</td>
            </tr>
        <?php else: ?>
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
                        <span class="badge <?= strtolower($t['metode_pembayaran'] ?? '') ?>">
                            <?= strtoupper($t['metode_pembayaran'] ?? '-') ?>
                        </span>
                    </td>
                    <td>Rp <?= number_format($t['total'], 0, ',', '.') ?></td>
                    <td>
                        <span class="badge <?= strtolower($t['status']) ?>">
                            <?= strtoupper($t['status']) ?>
                        </span>
                    </td>
                    <td><?= isset($t['created_at']) ? date('d-m-Y H:i', strtotime($t['created_at'])) : '-' ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</div>

<!-- ================= JS ================= -->
<script>
    // COUNT ANIMATION
    const counters = document.querySelectorAll('.count');

    counters.forEach(counter => {
        const update = () => {
            const target = +counter.getAttribute('data-target');
            const current = +counter.innerText;
            const increment = target / 50;

            if (current < target) {
                counter.innerText = Math.ceil(current + increment);
                setTimeout(update, 20);
            } else {
                counter.innerText = target.toLocaleString('id-ID');
            }
        };
        update();
    });

    // MOUSE PARALLAX EFFECT
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const rotateX = (y / rect.height - 0.5) * 8;
            const rotateY = (x / rect.width - 0.5) * -8;

            card.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.03)`;
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = '';
        });
    });
</script>

<?= $this->endSection() ?>