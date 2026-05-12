<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    .card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
        padding: 30px;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #8B6914;
    }

    .header h3 {
        margin: 0;
        color: #333;
        font-size: 24px;
        font-weight: 600;
    }

    .btn-back {
        background: #6c757d;
        color: white;
        padding: 8px 16px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-back:hover {
        background: #5a6268;
        transform: translateX(-3px);
    }

    .btn-print {
        background: #17a2b8;
        color: white;
        padding: 8px 16px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-left: 10px;
    }

    .btn-print:hover {
        background: #138496;
        transform: translateY(-2px);
    }

    .action-buttons {
        display: flex;
        gap: 10px;
    }

    .info-table {
        width: 100%;
        background: #f8f9fa;
        border-radius: 12px;
        margin-top: 20px;
        margin-bottom: 30px;
        border-collapse: collapse;
        overflow: hidden;
    }

    .info-table tr {
        border-bottom: 1px solid #e9ecef;
    }

    .info-table tr:last-child {
        border-bottom: none;
    }

    .info-table td {
        padding: 14px 20px;
        font-size: 14px;
    }

    .info-table td:first-child {
        font-weight: 700;
        color: #555;
        width: 180px;
        background: #f1f3f5;
    }

    .info-table td:last-child {
        color: #333;
        font-weight: 500;
    }

    .badge-status {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-lunas {
        background: #d4edda;
        color: #155724;
    }

    .badge-menunggu_konfirmasi {
        background: #fff3cd;
        color: #856404;
    }

    .badge-pending {
        background: #f8d7da;
        color: #721c24;
    }

    h4 {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin: 25px 0 15px 0;
        padding-bottom: 8px;
        border-bottom: 1px solid #eee;
    }

    .order-table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .order-table th {
        background: #1a1a1a;
        color: white;
        padding: 12px 15px;
        text-align: center;
        font-weight: 600;
        font-size: 13px;
    }

    .order-table td {
        padding: 12px 15px;
        text-align: center;
        border-bottom: 1px solid #eee;
        font-size: 14px;
    }

    .order-table tbody tr:hover {
        background: #fafafa;
    }

    .total-box {
        background: #f8f9fa;
        padding: 20px;
        margin-top: 25px;
        text-align: right;
        border-radius: 12px;
        border-left: 4px solid #8B6914;
    }

    .total-box h3 {
        margin: 0;
        color: #333;
        font-size: 20px;
    }

    .total-box h3 span {
        color: #8B6914;
        font-size: 26px;
        font-weight: 700;
    }

    .empty-order {
        text-align: center;
        padding: 40px;
        color: #999;
        font-size: 14px;
    }

    /* ========== STYLE KHUSUS UNTUK PRINT ========== */
    @media print {
        .sidebar, .top-bar, .header, .btn-back, .btn-print, .action-buttons, .footer {
            display: none !important;
        }
        
        .main-content {
            margin: 0 !important;
            padding: 0 !important;
        }
        
        .card {
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        
        body {
            background: white !important;
        }
        
        .print-header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        .print-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            font-size: 10px;
        }
        
        .invoice-title {
            font-size: 22px;
            font-weight: bold;
            color: #3b2a21;
        }
        
        .invoice-subtitle {
            font-size: 11px;
            color: #666;
        }
        
        .order-table th {
            background: #333 !important;
            color: white !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        .badge-status {
            border: 1px solid #ccc;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>

<div class="card">
    <div class="header">
        <h3>Detail Transaksi #<?= $transaksi['id'] ?></h3>
        <div class="action-buttons">
            <a href="<?= base_url('admin/transaksi') ?>" class="btn-back">← Kembali</a>
            <button onclick="window.print()" class="btn-print">
                <i class="fa fa-print"></i> Cetak Invoice
            </button>
        </div>
    </div>

    <!-- AREA YANG AKAN DICETAK -->
    <div id="printArea">
        <!-- Header untuk print (hanya muncul saat print) -->
        <div class="print-header" style="display: none;">
            <div class="invoice-title">☕ TERAS CAFFE</div>
            <div class="invoice-subtitle">Jl. Contoh No. 123, Kota</div>
            <div class="invoice-subtitle">Telp: 0812-3456-7890</div>
            <div class="invoice-subtitle">===================================</div>
        </div>

        <!-- Informasi Transaksi -->
        <table class="info-table">
            <tr>
                <td>Nomor Meja</td>
                <td>: <strong><?= $transaksi['meja'] ?></strong></td>
            </tr>
            <tr>
                <td>Metode Pembayaran</td>
                <td>: <strong><?= strtoupper($transaksi['metode_pembayaran']) ?></strong></td>
            </tr>
            <tr>
                <td>Tipe Pembayaran</td>
                <td>: <strong><?= strtoupper($transaksi['tipe_pembayaran'] ?? 'MEJA') ?></strong></td>
            </tr>
            <tr>
                <td>Status</td>
                <td>: 
                    <?php
                    $statusClass = '';
                    $statusText = strtoupper($transaksi['status']);
                    if ($transaksi['status'] == 'lunas') {
                        $statusClass = 'badge-lunas';
                    } elseif ($transaksi['status'] == 'menunggu_konfirmasi') {
                        $statusClass = 'badge-menunggu_konfirmasi';
                    } else {
                        $statusClass = 'badge-pending';
                    }
                    ?>
                    <span class="badge-status <?= $statusClass ?>"><?= $statusText ?></span>
                 </td>
             </tr>
             <tr>
                 <td>Tanggal Transaksi</td>
                 <td>: <strong><?= date('d-m-Y H:i:s', strtotime($transaksi['created_at'])) ?></strong></td>
             </tr>
         </table>

         <h4>📋 Daftar Pesanan</h4>
         
         <?php if (!empty($detail)): ?>
             <table class="order-table">
                 <thead>
                     <tr>
                         <th>Menu</th>
                         <th>Qty</th>
                         <th>Level Pedas</th>
                         <th>Harga</th>
                         <th>Subtotal</th>
                      </tr>
                 </thead>
                 <tbody>
                     <?php foreach ($detail as $d): ?>
                     <tr>
                         <td style="text-align: left;"><strong><?= esc($d['nama_menu']) ?></strong></td>
                         <td><?= $d['qty'] ?></td>
                         <td><?= $d['level_pedas'] ? "🌶️ Level {$d['level_pedas']}" : '🌶 Tidak Pedas' ?></td>
                         <td>Rp <?= number_format($d['harga'], 0, ',', '.') ?></td>
                         <td><strong>Rp <?= number_format($d['subtotal'], 0, ',', '.') ?></strong></td>
                     </tr>
                     <?php endforeach; ?>
                 </tbody>
             </table>
         <?php else: ?>
             <div class="empty-order">
                 Tidak ada pesanan dalam transaksi ini
             </div>
         <?php endif; ?>

         <div class="total-box">
             <h3>TOTAL: <span>Rp <?= number_format($transaksi['total'], 0, ',', '.') ?></span></h3>
         </div>

         <!-- Footer untuk print -->
         <div class="print-footer" style="display: none;">
             <div>===================================</div>
             <div>Terima kasih telah memesan di Teras Caffe</div>
             <div>© <?= date('Y') ?> Teras Caffe</div>
         </div>
     </div>
 </div>

 <script>
     // Override print untuk menampilkan header dan footer yang disembunyikan
     window.onbeforeprint = function() {
         var headers = document.querySelectorAll('.print-header');
         var footers = document.querySelectorAll('.print-footer');
         headers.forEach(function(el) { el.style.display = 'block'; });
         footers.forEach(function(el) { el.style.display = 'block'; });
     };
     
     window.onafterprint = function() {
         var headers = document.querySelectorAll('.print-header');
         var footers = document.querySelectorAll('.print-footer');
         headers.forEach(function(el) { el.style.display = 'none'; });
         footers.forEach(function(el) { el.style.display = 'none'; });
     };
 </script>

 <?= $this->endSection() ?>