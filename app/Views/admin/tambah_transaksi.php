<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    .card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        padding: 20px;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #8B6914;
    }

    .header h3 {
        margin: 0;
        font-size: 18px;
    }

    .btn-back {
        background: #6c757d;
        color: white;
        padding: 5px 10px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 12px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        font-size: 13px;
    }

    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 13px;
    }

    h4 {
        margin: 20px 0 12px 0;
        font-size: 15px;
        font-weight: 600;
    }

    /* SEARCH STYLE */
    .search-section {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .search-box {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .search-box input {
        flex: 1;
    }

    .btn-reset {
        background: #6c757d;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
        white-space: nowrap;
    }

    .btn-reset:hover {
        background: #5a6268;
    }

    .search-info {
        font-size: 11px;
        color: #6c757d;
        margin-top: 8px;
    }

    /* TABEL MENU */
    .table-menu {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .table-menu th,
    .table-menu td {
        border: 1px solid #ddd;
        padding: 8px;
        vertical-align: middle;
    }

    .table-menu th {
        background: #60450b;
        text-align: center;
        color: white;  /* ✅ TEKS PUTIH */
    }

    .table-menu td {
        text-align: center;
    }

    .stok-badge {
        display: inline-block;
        font-size: 11px;
        padding: 2px 8px;
        border-radius: 20px;
    }

    .stok-aman { background: #d4edda; color: #155724; }
    .stok-menipis { background: #fff3cd; color: #856404; }
    .stok-habis { background: #f8d7da; color: #721c24; }

    .btn-pilih {
        background: #28a745;
        color: white;
        padding: 4px 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 11px;
    }

    .btn-pilih:hover {
        background: #1e7e34;
    }

    .btn-pilih:disabled {
        background: #ccc;
        cursor: not-allowed;
    }

    /* TABEL PESANAN */
    .table-order {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .table-order th,
    .table-order td {
        border: 1px solid #ddd;
        padding: 6px 8px;
        vertical-align: middle;
        text-align: center;
    }

    .table-order th {
        background: #60450b;
        color: white;  /* ✅ TEKS PUTIH */
    }

    .btn-remove {
        background: #dc3545;
        color: white;
        padding: 3px 8px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 11px;
    }

    .total-box {
        background: #f8f9fa;
        padding: 10px 15px;
        margin: 15px 0;
        text-align: right;
        border-radius: 8px;
    }

    .btn-simpan {
        background: #8B6914;
        color: white;
        padding: 8px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    .btn-batal {
        background: #6c757d;
        color: white;
        padding: 8px 20px;
        border-radius: 6px;
        text-decoration: none;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 15px;
    }
</style>

<div class="card">
    <div class="header">
        <h3>Tambah Transaksi</h3>
        <a href="<?= base_url('admin/transaksi') ?>" class="btn-back">← Kembali</a>
    </div>

    <form action="<?= base_url('admin/transaksi/simpan') ?>" method="post" id="formTransaksi">
        <?= csrf_field() ?>

        <div class="form-group">
            <label>Nomor Meja</label>
            <input type="number" name="meja" class="form-control" placeholder="Masukkan nomor meja" required>
        </div>

        <div class="form-group">
            <label>Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-control" required>
                <option value="cash">💵 Cash</option>
                <option value="qris">📱 QRIS</option>
            </select>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="lunas">✅ Lunas</option>
                <option value="menunggu_konfirmasi">⏳ Menunggu Konfirmasi</option>
            </select>
        </div>

        <!-- SEARCH MENU -->
        <div class="search-section">
            <div class="search-box">
                <input type="text" id="searchMenu" class="form-control" placeholder="🔍 Cari menu... (ketik nama menu)">
                <button type="button" id="btnResetSearch" class="btn-reset">Reset</button>
            </div>
            <div class="search-info">
                <i class="fa fa-info-circle"></i> Mengetik akan langsung memfilter daftar menu di bawah
            </div>
        </div>

        <h4>Daftar Menu</h4>
        <div style="overflow-x: auto; max-height: 300px; overflow-y: auto;">
            <table class="table-menu">
                <thead>
                    <tr>
                        <th>Nama Menu</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="menuList">
                    <?php foreach ($menu as $m): ?>
                    <tr class="menu-row" data-namamenux="<?= strtolower(esc($m['nama_menu'])) ?>">
                        <td style="text-align: left;"><?= esc($m['nama_menu']) ?></td>
                        <td>Rp <?= number_format($m['harga'], 0, ',', '.') ?></td>
                        <td>
                            <?php
                            $stok = $m['stok'];
                            if ($stok <= 0) {
                                echo '<span class="stok-badge stok-habis">❌ Habis</span>';
                            } elseif ($stok <= 5) {
                                echo '<span class="stok-badge stok-menipis">⚠️ ' . $stok . '</span>';
                            } else {
                                echo '<span class="stok-badge stok-aman">✅ ' . $stok . '</span>';
                            }
                            ?>
                        </td>
                        <td>
                            <button type="button" class="btn-pilih" 
                                    data-id="<?= $m['id'] ?>"
                                    data-nama="<?= esc($m['nama_menu']) ?>"
                                    data-harga="<?= $m['harga'] ?>"
                                    data-stok="<?= $m['stok'] ?>"
                                    <?= $m['stok'] <= 0 ? 'disabled' : '' ?>>
                                + Pilih
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <h4>Daftar Pesanan</h4>
        <div style="overflow-x: auto;">
            <table class="table-order">
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Level Pedas</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="orderList">
                    <tr class="empty-order">
                        <td colspan="6" style="text-align: center; color: #999;">Belum ada pesanan</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="total-box">
            <strong>Total: Rp <span id="totalDisplay">0</span></strong>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan">Simpan Transaksi</button>
            <a href="<?= base_url('admin/transaksi') ?>" class="btn-batal">Batal</a>
        </div>
    </form>
</div>

<script>
// ==================== DATA PESANAN ====================
let orderItems = [];
let nextOrderId = 1;

// ==================== DATA STOK REAL-TIME ====================
let menuStok = {};

// Inisialisasi stok dari data awal
document.querySelectorAll('.btn-pilih').forEach(btn => {
    const menuId = btn.dataset.id;
    const stokAwal = parseInt(btn.dataset.stok);
    menuStok[menuId] = stokAwal;
});

// ==================== SEARCH MENU ====================
const searchInput = document.getElementById('searchMenu');
const menuRows = document.querySelectorAll('#menuList .menu-row');
const resetBtn = document.getElementById('btnResetSearch');

function filterMenu() {
    const keyword = searchInput.value.toLowerCase().trim();
    menuRows.forEach(row => {
        const namaMenu = row.getAttribute('data-namamenux') || '';
        if (keyword === '' || namaMenu.includes(keyword)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function resetSearch() {
    searchInput.value = '';
    menuRows.forEach(row => row.style.display = '');
    searchInput.focus();
}

searchInput.addEventListener('keyup', filterMenu);
resetBtn.addEventListener('click', resetSearch);

// ==================== UPDATE TAMPILAN STOK ====================
function updateStokDisplay(menuId) {
    const btn = document.querySelector(`.btn-pilih[data-id="${menuId}"]`);
    if (!btn) return;
    
    const stokSisa = menuStok[menuId];
    const row = btn.closest('tr');
    const stokCell = row.querySelector('td:nth-child(3)');
    
    if (stokCell) {
        if (stokSisa <= 0) {
            stokCell.innerHTML = '<span class="stok-badge stok-habis">❌ Habis</span>';
            btn.disabled = true;
        } else if (stokSisa <= 5) {
            stokCell.innerHTML = `<span class="stok-badge stok-menipis">⚠️ ${stokSisa}</span>`;
            btn.disabled = false;
        } else {
            stokCell.innerHTML = `<span class="stok-badge stok-aman">✅ ${stokSisa}</span>`;
            btn.disabled = false;
        }
    }
    btn.dataset.stok = stokSisa;
}

// ==================== RENDER PESANAN ====================
function renderOrderList() {
    const tbody = document.getElementById('orderList');
    const totalSpan = document.getElementById('totalDisplay');
    let total = 0;
    
    if (orderItems.length === 0) {
        tbody.innerHTML = '<tr class="empty-order"><td colspan="6" style="text-align: center; color: #999;">Belum ada pesanan</td></tr>';
        totalSpan.innerText = '0';
        return;
    }
    
    let html = '';
    orderItems.forEach((item, index) => {
        const subtotal = item.harga * item.qty;
        total += subtotal;
        
        let levelOptions = '<option value="">🌶 Tidak</option>';
        for (let i = 1; i <= 5; i++) {
            levelOptions += `<option value="${i}" ${item.level_pedas == i ? 'selected' : ''}>Level ${i}</option>`;
        }
        
        html += `
            <tr data-order-id="${item.id}" data-menu-id="${item.id_menu}">
                <td style="text-align: left;">${item.nama_menu}</td>
                <td>Rp ${item.harga.toLocaleString('id-ID')}</td>
                <td>
                    <input type="number" class="form-control qty-input" 
                           style="width: 60px; text-align: center;"
                           value="${item.qty}" min="1" max="30" step="1">
                    <small style="font-size: 9px; color: #666;">Stok: ${menuStok[item.id_menu]}</small>
                </td>
                <td><select class="form-control level-select">${levelOptions}</select></td>
                <td>Rp ${subtotal.toLocaleString('id-ID')}</td>
                <td><button type="button" class="btn-remove">Hapus</button></td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
    totalSpan.innerText = total.toLocaleString('id-ID');
    
    // Event qty
    document.querySelectorAll('.qty-input').forEach((input, idx) => {
        input.addEventListener('change', function() {
            let newQty = parseInt(this.value) || 1;
            const item = orderItems[idx];
            const stokTersedia = menuStok[item.id_menu];
            
            if (newQty > 30) {
                alert(`Maksimal pemesanan ${item.nama_menu} adalah 30`);
                newQty = item.qty;
                this.value = item.qty;
            } else if (newQty > stokTersedia + item.qty) {
                alert(`Stok tidak cukup! Stok tersisa ${stokTersedia}`);
                newQty = item.qty;
                this.value = item.qty;
            }
            
            if (newQty < 1) newQty = 1;
            
            if (newQty !== item.qty) {
                menuStok[item.id_menu] += item.qty;
                menuStok[item.id_menu] -= newQty;
                item.qty = newQty;
                updateStokDisplay(item.id_menu);
                renderOrderList();
            }
        });
    });
    
    // Event level pedas
    document.querySelectorAll('.level-select').forEach((select, idx) => {
        select.addEventListener('change', function() {
            orderItems[idx].level_pedas = this.value;
        });
    });
    
    // Event hapus
    document.querySelectorAll('.btn-remove').forEach((btn, idx) => {
        btn.addEventListener('click', function() {
            const item = orderItems[idx];
            menuStok[item.id_menu] += item.qty;
            updateStokDisplay(item.id_menu);
            orderItems.splice(idx, 1);
            renderOrderList();
        });
    });
}

// ==================== TOMBOL PILIH MENU ====================
document.querySelectorAll('.btn-pilih').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = parseInt(this.dataset.id);
        const nama = this.dataset.nama;
        const harga = parseInt(this.dataset.harga);
        let stok = menuStok[id];
        
        if (stok <= 0) {
            alert(`Stok ${nama} habis!`);
            return;
        }
        
        const existingIndex = orderItems.findIndex(item => item.id_menu === id);
        
        if (existingIndex !== -1) {
            const currentQty = orderItems[existingIndex].qty;
            if (currentQty + 1 > 30) {
                alert(`Maksimal pemesanan ${nama} adalah 30`);
                return;
            }
            menuStok[id]--;
            orderItems[existingIndex].qty++;
        } else {
            orderItems.push({
                id: nextOrderId++,
                id_menu: id,
                nama_menu: nama,
                harga: harga,
                qty: 1,
                level_pedas: ''
            });
            menuStok[id]--;
        }
        
        updateStokDisplay(id);
        renderOrderList();
    });
});

// ==================== SUBMIT FORM ====================
document.getElementById('formTransaksi').addEventListener('submit', function(e) {
    if (orderItems.length === 0) {
        e.preventDefault();
        alert('Minimal 1 item pesanan!');
        return;
    }
    
    orderItems.forEach((item, idx) => {
        const inputIdMenu = document.createElement('input');
        inputIdMenu.type = 'hidden';
        inputIdMenu.name = `items[${idx}][id_menu]`;
        inputIdMenu.value = item.id_menu;
        this.appendChild(inputIdMenu);
        
        const inputQty = document.createElement('input');
        inputQty.type = 'hidden';
        inputQty.name = `items[${idx}][qty]`;
        inputQty.value = item.qty;
        this.appendChild(inputQty);
        
        const inputLevel = document.createElement('input');
        inputLevel.type = 'hidden';
        inputLevel.name = `items[${idx}][level_pedas]`;
        inputLevel.value = item.level_pedas || '';
        this.appendChild(inputLevel);
    });
});
</script>

<?= $this->endSection() ?>