<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    .card {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
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
        background: #8B6914;
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-tambah:hover { background: #6B4F12; transform: translateY(-2px); }
    .btn-edit {
        background: #8B6914;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 11px;
    }
    .btn-detail {
        background: #1e3a5f;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 11px;
    }
    .btn-konfirmasi {
        background: #1a5a3a;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        font-size: 11px;
        transition: all 0.2s;
    }
    .btn-konfirmasi:hover { background: #0d4028; transform: scale(1.05); }
    .btn-konfirmasi:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
    .table-wrapper { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    th {
        background: #60450b;
        color: white;
        padding: 12px;
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
    .badge {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: bold;
        display: inline-block;
    }
    /* ============================================================
       WARNA STATUS
       ============================================================ */
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
    .badge.kasir {
        background: #ffe0e0;
        color: #8a1f1f;
    }
    .badge.meja {
        background: #e2e3ff;
        color: #383d8a;
    }
    @keyframes highlightNew {
        0% { background-color: #d4edda; }
        100% { background-color: transparent; }
    }
    .new-row { animation: highlightNew 1s ease; }
</style>

<div class="card">
    <div class="header">
        <h3>Daftar Transaksi</h3>
        <a href="<?= base_url('admin/transaksi/tambah') ?>" class="btn-tambah">+ Tambah Transaksi</a>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Meja</th><th>Tipe</th><th>Metode</th><th>Total</th><th>Status</th><th>Tanggal</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody id="transaksiTableBody">
                <?php if (!empty($transaksi)): ?>
                    <?php foreach ($transaksi as $t): ?>
                    <tr id="transaksi-<?= $t['id'] ?>" data-id="<?= $t['id'] ?>">
                        <td><strong>#<?= esc($t['id']) ?></strong></td>
                        <td><?= esc($t['meja']) ?></td>
                        <td><span class="badge <?= strtolower($t['tipe_pembayaran'] ?? 'meja') ?>"><?= strtoupper($t['tipe_pembayaran'] ?? 'MEJA') ?></span></td>
                        <td><span class="badge <?= strtolower($t['metode_pembayaran'] ?? 'cash') ?>"><?= strtoupper($t['metode_pembayaran'] ?? 'CASH') ?></span></td>
                        <td>Rp <?= number_format($t['total'], 0, ',', '.') ?></td>
                        <td>
                            <span class="badge <?= strtolower($t['status']) ?>">
                                <?= strtoupper($t['status']) ?>
                            </span>
                        </td>
                        <td><?= date('d-m-Y H:i', strtotime($t['created_at'])) ?></td>
                        <td>
                            <a href="<?= base_url('admin/transaksi/detail/' . $t['id']) ?>" class="btn-detail">Detail</a>
                            <a href="<?= base_url('admin/transaksi/edit/' . $t['id']) ?>" class="btn-edit">Edit</a>
                            <?php if ($t['status'] != 'lunas'): ?>
                                <button type="button" class="btn-konfirmasi" data-id="<?= $t['id'] ?>">Konfirmasi</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8" style="text-align:center; padding:30px; color:#999;">Belum ada transaksi</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// ==================== CSRF TOKEN ====================
function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    if (meta) {
        return meta.getAttribute('content');
    }
    const name = '<?= csrf_token() ?>';
    const cookies = document.cookie.split(';');
    for (let cookie of cookies) {
        const [key, value] = cookie.trim().split('=');
        if (key === name) {
            return decodeURIComponent(value);
        }
    }
    return '';
}

function getCsrfName() {
    const meta = document.querySelector('meta[name="csrf-name"]');
    if (meta) {
        return meta.getAttribute('content');
    }
    return '<?= csrf_token() ?>';
}

// ==================== KONFIRMASI HANDLER ====================
function attachKonfirmasiEvents() {
    document.querySelectorAll('.btn-konfirmasi').forEach(btn => {
        btn.removeEventListener('click', konfirmasiHandler);
        btn.addEventListener('click', konfirmasiHandler);
    });
}

async function konfirmasiHandler(e) {
    const btn = e.currentTarget;
    const id = btn.dataset.id;
    
    if (!confirm(`Konfirmasi transaksi #${id} sebagai LUNAS?`)) return;
    
    const original = btn.innerHTML;
    btn.innerHTML = '⏳...';
    btn.disabled = true;
    
    try {
        const baseUrl = '<?= base_url() ?>';
        const csrfName = getCsrfName();
        const csrfToken = getCsrfToken();
        
        const postData = {};
        postData[csrfName] = csrfToken;
        
        const response = await fetch(baseUrl + 'admin/transaksi/konfirmasi-ajax/' + id, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'Cache-Control': 'no-cache',
                'X-CSRF-TOKEN': csrfToken
            },
            credentials: 'same-origin',
            body: JSON.stringify(postData)
        });
        
        if (!response.ok) {
            throw new Error('HTTP ' + response.status + ': ' + response.statusText);
        }
        
        const data = await response.json();
        console.log('Response konfirmasi:', data);
        
        if (data.success) {
            showToast('success', '✅ ' + data.message);
            await refreshTransaksiTable();
        } else {
            showToast('error', '❌ ' + data.message);
            btn.innerHTML = original;
            btn.disabled = false;
        }
    } catch(error) {
        console.error('Error konfirmasi:', error);
        showToast('error', '❌ Terjadi kesalahan: ' + error.message);
        btn.innerHTML = original;
        btn.disabled = false;
    }
}

// ==================== REFRESH TABEL ====================
async function refreshTransaksiTable() {
    try {
        const baseUrl = '<?= base_url() ?>';
        const response = await fetch(baseUrl + 'admin/transaksi/get-transaksi-data', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Cache-Control': 'no-cache'
            }
        });
        
        if (!response.ok) {
            throw new Error('HTTP ' + response.status);
        }
        
        const data = await response.json();
        console.log('Refresh table response:', data);
        
        if (data.success) {
            const tbody = document.getElementById('transaksiTableBody');
            const oldIds = Array.from(tbody.querySelectorAll('tr')).map(row => row.dataset?.id);
            
            tbody.innerHTML = data.html;
            
            const newRows = tbody.querySelectorAll('tr');
            newRows.forEach(row => {
                if (row.dataset?.id && !oldIds.includes(row.dataset.id)) {
                    row.classList.add('new-row');
                }
            });
            
            attachKonfirmasiEvents();
        }
    } catch(error) {
        console.error('Error refreshing table:', error);
    }
}

// ==================== TOAST NOTIFICATION ====================
function showToast(type, message) {
    let container = document.getElementById('toastContainer');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toastContainer';
        container.style.cssText = 'position:fixed; top:80px; right:20px; z-index:99999;';
        document.body.appendChild(container);
    }
    
    const toast = document.createElement('div');
    const colors = {
        success: 'background: #d4edda; color: #155724; border-left: 4px solid #28a745;',
        error: 'background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545;',
        info: 'background: #cce5ff; color: #004085; border-left: 4px solid #17a2b8;'
    };
    
    toast.style.cssText = `
        padding: 12px 20px;
        margin-bottom: 10px;
        border-radius: 8px;
        font-size: 13px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        animation: slideIn 0.3s ease;
        min-width: 200px;
        max-width: 400px;
        ${colors[type] || colors.info}
    `;
    toast.innerHTML = message;
    
    container.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(50px)';
        toast.style.transition = 'all 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// ==================== CEK NOTIFIKASI ====================
let lastCount = 0;

async function cekDanRefresh() {
    try {
        const timestamp = new Date().getTime();
        const baseUrl = '<?= base_url() ?>';
        const response = await fetch(baseUrl + 'admin/transaksi/cek-pesanan-baru?_=' + timestamp, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Cache-Control': 'no-cache'
            }
        });
        
        if (!response.ok) {
            throw new Error('HTTP ' + response.status);
        }
        
        const data = await response.json();
        console.log('Cek notifikasi response:', data);
        
        if (data.success) {
            const count = data.total_baru;
            const notifCount = document.getElementById('notificationCount');
            
            if (count > 0) {
                notifCount.innerText = count;
                notifCount.style.display = 'inline-block';
                
                const bell = document.querySelector('.notification-bell i');
                bell.classList.add('pulse');
                setTimeout(() => bell.classList.remove('pulse'), 500);
                
                if (count > lastCount) {
                    await refreshTransaksiTable();
                }
            } else {
                notifCount.style.display = 'none';
            }
            lastCount = count;
        }
    } catch(error) {
        console.error('Error checking notifications:', error);
    }
}

// ==================== INIT ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Transaksi page loaded');
    console.log('Base URL:', '<?= base_url() ?>');
    attachKonfirmasiEvents();
    
    setInterval(cekDanRefresh, 5000);
    setTimeout(cekDanRefresh, 2000);
});

document.addEventListener('visibilitychange', function() {
    if (!document.hidden) {
        cekDanRefresh();
    }
});

if (!document.getElementById('toastStyle')) {
    const style = document.createElement('style');
    style.id = 'toastStyle';
    style.textContent = `
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }
    `;
    document.head.appendChild(style);
}
</script>

<?= $this->endSection() ?>