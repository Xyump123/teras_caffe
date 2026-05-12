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
    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }
    .table th, .table td {
        border: 1px solid #ddd;
        padding: 6px 8px;
        vertical-align: middle;
        text-align: center;
    }
    .table th {
        background: #60450b;
    }
    .btn-add {
        background: #28a745;
        color: white;
        padding: 5px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-bottom: 15px;
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
    .btn-update {
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
    .stok-badge {
        display: inline-block;
        font-size: 11px;
        padding: 2px 8px;
        border-radius: 20px;
    }
    .stok-aman { background: #d4edda; color: #155724; }
    .stok-menipis { background: #fff3cd; color: #856404; }
    .stok-habis { background: #f8d7da; color: #721c24; }
</style>

<div class="card">
    <div class="header">
        <h3>Edit Transaksi #<?= $transaksi['id'] ?></h3>
        <a href="<?= base_url('admin/transaksi') ?>" class="btn-back">← Kembali</a>
    </div>

    <form action="<?= base_url('admin/transaksi/update/' . $transaksi['id']) ?>" method="post" id="formTransaksi">
        <?= csrf_field() ?>

        <div class="form-group">
            <label>Nomor Meja</label>
            <input type="number" name="meja" class="form-control" value="<?= $transaksi['meja'] ?>" required>
        </div>

        <div class="form-group">
            <label>Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-control" required>
                <option value="cash" <?= $transaksi['metode_pembayaran'] == 'cash' ? 'selected' : '' ?>>Cash</option>
                <option value="qris" <?= $transaksi['metode_pembayaran'] == 'qris' ? 'selected' : '' ?>>QRIS</option>
            </select>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="pending" <?= $transaksi['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="menunggu_konfirmasi" <?= $transaksi['status'] == 'menunggu_konfirmasi' ? 'selected' : '' ?>>Menunggu</option>
                <option value="lunas" <?= $transaksi['status'] == 'lunas' ? 'selected' : '' ?>>Lunas</option>
            </select>
        </div>

        <h4>Daftar Pesanan</h4>
        <div style="overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th width="35%">Menu</th>
                        <th width="15%">Stok</th>
                        <th width="15%">Qty</th>
                        <th width="25%">Level Pedas</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody id="itemList">
                    <?php foreach ($detail as $index => $item): ?>
                    <tr class="item-row">
                        <td>
                            <select name="items[<?= $index ?>][id_menu]" class="form-control menu-select" required>
                                <option value="">-- Pilih Menu --</option>
                                <?php foreach ($menu as $m): ?>
                                    <option value="<?= $m['id'] ?>" 
                                            data-harga="<?= $m['harga'] ?>" 
                                            data-stok="<?= $m['stok'] ?>"
                                            <?= $item['id_menu'] == $m['id'] ? 'selected' : '' ?>>
                                        <?= $m['nama_menu'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td class="stok-cell">
                            <span class="stok-badge">-</span>
                        </td>
                        <td>
                            <input type="number" name="items[<?= $index ?>][qty]" class="form-control qty" value="<?= $item['qty'] ?>" min="1" required>
                        </td>
                        <td>
                            <select name="items[<?= $index ?>][level_pedas]" class="form-control">
                                <option value="">🌶 Tidak</option>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <option value="<?= $i ?>" <?= $item['level_pedas'] == $i ? 'selected' : '' ?>>Level <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </td>
                        <td>
                            <button type="button" class="btn-remove">Hapus</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <button type="button" id="tambahItem" class="btn-add">+ Tambah Item</button>

        <div class="total-box">
            <strong>Total: Rp <span id="totalDisplay"><?= number_format($transaksi['total'], 0, ',', '.') ?></span></strong>
        </div>

        <div style="display: flex; gap: 10px; justify-content: flex-end;">
            <button type="submit" class="btn-update">Update Transaksi</button>
            <a href="<?= base_url('admin/transaksi') ?>" class="btn-batal">Batal</a>
        </div>
    </form>
</div>

<script>
let itemIndex = <?= count($detail) ?>;

function getStokClass(stok) {
    if (stok <= 0) return 'stok-habis';
    if (stok <= 5) return 'stok-menipis';
    return 'stok-aman';
}

function getStokText(stok) {
    if (stok <= 0) return '❌ Habis';
    if (stok <= 5) return '⚠️ ' + stok;
    return '✅ ' + stok;
}

function updateStokInfo(row, stok) {
    const stokCell = row.querySelector('.stok-cell');
    if (!stokCell) return;
    const stokBadge = stokCell.querySelector('.stok-badge');
    stokBadge.className = 'stok-badge ' + getStokClass(stok);
    stokBadge.innerHTML = getStokText(stok);
    
    const qtyInput = row.querySelector('.qty');
    const maxStok = Math.min(stok, 30);
    qtyInput.max = maxStok;
    if (stok <= 0) {
        qtyInput.disabled = true;
        qtyInput.value = 0;
    } else {
        qtyInput.disabled = false;
        if (parseInt(qtyInput.value) > maxStok) qtyInput.value = maxStok;
    }
}

function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        const select = row.querySelector('.menu-select');
        const harga = select.options[select.selectedIndex]?.dataset.harga || 0;
        const qty = row.querySelector('.qty').value || 0;
        total += harga * qty;
    });
    document.getElementById('totalDisplay').innerText = total.toLocaleString('id-ID');
}

function attachEvents() {
    document.querySelectorAll('.btn-remove').forEach(btn => {
        btn.onclick = function() {
            if (document.querySelectorAll('.item-row').length > 1) {
                this.closest('.item-row').remove();
                calculateTotal();
            } else {
                alert('Minimal 1 item');
            }
        };
    });
    
    document.querySelectorAll('.menu-select').forEach(select => {
        select.onchange = function() {
            const row = this.closest('.item-row');
            const stok = this.options[this.selectedIndex]?.dataset.stok || 0;
            updateStokInfo(row, stok);
            calculateTotal();
        };
        const row = select.closest('.item-row');
        const stok = select.options[select.selectedIndex]?.dataset.stok || 0;
        updateStokInfo(row, stok);
    });
    
    document.querySelectorAll('.qty').forEach(qty => {
        qty.oninput = calculateTotal;
    });
}

document.getElementById('tambahItem').onclick = function() {
    const tbody = document.getElementById('itemList');
    const newRow = document.createElement('tr');
    newRow.className = 'item-row';
    
    let menuOptions = '<option value="">-- Pilih Menu --</option>';
    <?php foreach ($menu as $m): ?>
        menuOptions += `<option value="<?= $m['id'] ?>" data-harga="<?= $m['harga'] ?>" data-stok="<?= $m['stok'] ?>"><?= addslashes($m['nama_menu']) ?></option>`;
    <?php endforeach; ?>
    
    let levelOptions = '<option value="">🌶 Tidak</option>';
    <?php for ($i = 1; $i <= 5; $i++): ?>
        levelOptions += `<option value="<?= $i ?>">Level <?= $i ?></option>`;
    <?php endfor; ?>
    
    newRow.innerHTML = `
        <td><select name="items[${itemIndex}][id_menu]" class="form-control menu-select" required>${menuOptions}</select></td>
        <td class="stok-cell"><span class="stok-badge">-</span></td>
        <td><input type="number" name="items[${itemIndex}][qty]" class="form-control qty" value="1" min="1"></td>
        <td><select name="items[${itemIndex}][level_pedas]" class="form-control">${levelOptions}</select></td>
        <td><button type="button" class="btn-remove">Hapus</button></td>
    `;
    tbody.appendChild(newRow);
    itemIndex++;
    attachEvents();
    calculateTotal();
};

attachEvents();
calculateTotal();
</script>

<?= $this->endSection() ?>