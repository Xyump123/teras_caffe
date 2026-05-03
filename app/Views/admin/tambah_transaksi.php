<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    .card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
        padding: 25px;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #8B6914;
    }

    .header h3 {
        margin: 0;
        color: #333;
        font-size: 20px;
        font-weight: 600;
    }

    .btn-back {
        background: #6c757d;
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background: #5a6268;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        color: #333;
        font-size: 13px;
    }

    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 13px;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: #8B6914;
    }

    .hint {
        font-size: 11px;
        color: #888;
        margin-top: 3px;
    }

    h4 {
        margin: 20px 0 12px 0;
        color: #333;
        font-size: 16px;
        font-weight: 600;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
        font-size: 13px;
    }

    .table th,
    .table td {
        border: 1px solid #ddd;
        padding: 8px 10px;
        vertical-align: middle;
    }

    .table th {
        background: #f5f5f5;
        font-weight: 600;
        text-align: center;
        color: #000000; 
    }

    .table td {
        text-align: center;
    }

    /* STOK BADGE */
    .stok-badge {
        display: inline-block;
        font-size: 11px;
        padding: 2px 8px;
        border-radius: 20px;
        font-weight: 500;
    }

    .stok-aman {
        background: #d4edda;
        color: #155724;
    }

    .stok-menipis {
        background: #fff3cd;
        color: #856404;
    }

    .stok-habis {
        background: #f8d7da;
        color: #721c24;
    }

    /* FORM CONTROL DI TABEL */
    .table .form-control {
        padding: 6px 8px;
        font-size: 12px;
        width: 100%;
    }

    .table select.form-control {
        width: 100%;
        min-width: 120px;
    }

    .table input.qty {
        width: 70px;
        text-align: center;
    }

    .btn-remove {
        background: #dc3545;
        color: white;
        padding: 4px 8px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 11px;
        transition: 0.2s;
    }

    .btn-remove:hover {
        background: #c82333;
    }

    .btn-add {
        background: #28a745;
        color: white;
        padding: 6px 12px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 500;
        margin-bottom: 15px;
    }

    .btn-add:hover {
        background: #218838;
    }

    .total-box {
        background: #f8f9fa;
        padding: 12px 20px;
        margin: 15px 0;
        text-align: right;
        border-radius: 10px;
        border-left: 4px solid #8B6914;
    }

    .total-box h4 {
        margin: 0;
        font-size: 16px;
    }

    .total-box h4 span {
        color: #8B6914;
        font-size: 20px;
        font-weight: 700;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 15px;
    }

    .btn-simpan {
        background: #8B6914;
        color: white;
        padding: 8px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 600;
    }

    .btn-simpan:hover {
        background: #6B4F12;
    }

    .btn-batal {
        background: #6c757d;
        color: white;
        padding: 8px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        text-align: center;
    }

    .btn-batal:hover {
        background: #5a6268;
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

        <h4>Daftar Pesanan</h4>
        
        <div style="overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:35%">Menu</th>
                        <th style="width:15%">Stok</th>
                        <th style="width:15%">Qty</th>
                        <th style="width:25%">Level Pedas</th>
                        <th style="width:10%">Aksi</th>
                    </tr>
                </thead>
                <tbody id="itemList">
                    <tr class="item-row">
                        <td>
                            <select name="items[0][id_menu]" class="form-control menu-select" required>
                                <option value="">-- Pilih Menu --</option>
                                <?php foreach ($menu as $m): ?>
                                    <option value="<?= $m['id'] ?>" 
                                            data-harga="<?= $m['harga'] ?>" 
                                            data-stok="<?= $m['stok'] ?>"
                                            data-nama="<?= esc($m['nama_menu']) ?>">
                                        <?= esc($m['nama_menu']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td class="stok-cell">
                            <span class="stok-badge">-</span>
                        </td>
                        <td>
                            <input type="number" name="items[0][qty]" class="form-control qty" value="1" min="1" step="1">
                        </td>
                        <td>
                            <select name="items[0][level_pedas]" class="form-control">
                                <option value="">🌶 Tidak</option>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <option value="<?= $i ?>">Level <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </td>
                        <td style="text-align:center">
                            <button type="button" class="btn-remove">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <button type="button" id="tambahItem" class="btn-add">+ Tambah Item</button>

        <div class="total-box">
            <h4>Total: <span id="totalDisplay">0</span></h4>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan">Simpan</button>
            <a href="<?= base_url('admin/transaksi') ?>" class="btn-batal">Batal</a>
        </div>
    </form>
</div>

<script>
    let itemIndex = 1;

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
        const className = getStokClass(stok);
        const text = getStokText(stok);
        
        stokBadge.className = 'stok-badge ' + className;
        stokBadge.innerHTML = text;
        
        const qtyInput = row.querySelector('.qty');
        const maxStok = Math.min(stok, 30);
        qtyInput.max = maxStok;
        
        if (stok <= 0) {
            qtyInput.disabled = true;
            qtyInput.value = 0;
        } else {
            qtyInput.disabled = false;
            if (parseInt(qtyInput.value) > maxStok) {
                qtyInput.value = maxStok;
            }
        }
    }

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const select = row.querySelector('.menu-select');
            const selectedOption = select.options[select.selectedIndex];
            const harga = selectedOption && selectedOption.dataset.harga ? parseInt(selectedOption.dataset.harga) : 0;
            const qty = parseInt(row.querySelector('.qty').value) || 0;
            total += harga * qty;
        });
        document.getElementById('totalDisplay').innerText = total.toLocaleString('id-ID');
    }

    function removeRow(e) {
        const rows = document.querySelectorAll('.item-row');
        if (rows.length > 1) {
            e.target.closest('.item-row').remove();
            calculateTotal();
        } else {
            alert('Minimal 1 item!');
        }
    }

    function attachEvents() {
        document.querySelectorAll('.btn-remove').forEach(btn => {
            btn.onclick = removeRow;
        });
        
        document.querySelectorAll('.menu-select').forEach(select => {
            select.onchange = function() {
                const row = this.closest('.item-row');
                const stok = parseInt(this.options[this.selectedIndex]?.dataset.stok) || 0;
                updateStokInfo(row, stok);
                calculateTotal();
            };
            // Trigger untuk baris pertama
            if (select === document.querySelector('.menu-select')) {
                const row = select.closest('.item-row');
                const stok = parseInt(select.options[select.selectedIndex]?.dataset.stok) || 0;
                updateStokInfo(row, stok);
            }
        });
        
        document.querySelectorAll('.qty').forEach(qty => {
            qty.onchange = calculateTotal;
            qty.onkeyup = calculateTotal;
        });
    }

    document.getElementById('tambahItem').onclick = function() {
        const tbody = document.getElementById('itemList');
        const newRow = document.createElement('tr');
        newRow.className = 'item-row';
        
        let menuOptions = '<option value="">-- Pilih Menu --</option>';
        <?php foreach ($menu as $m): ?>
            menuOptions += `<option value="<?= $m['id'] ?>" 
                data-harga="<?= $m['harga'] ?>" 
                data-stok="<?= $m['stok'] ?>"
                data-nama="<?= addslashes($m['nama_menu']) ?>">
                <?= addslashes($m['nama_menu']) ?>
            </option>`;
        <?php endforeach; ?>
        
        let levelOptions = '<option value="">🌶 Tidak</option>';
        <?php for ($i = 1; $i <= 5; $i++): ?>
            levelOptions += `<option value="<?= $i ?>">Level <?= $i ?></option>`;
        <?php endfor; ?>
        
        newRow.innerHTML = `
            <td>
                <select name="items[${itemIndex}][id_menu]" class="form-control menu-select" required>
                    ${menuOptions}
                </select>
            </td>
            <td class="stok-cell">
                <span class="stok-badge">-</span>
            </td>
            <td>
                <input type="number" name="items[${itemIndex}][qty]" class="form-control qty" value="1" min="1" step="1">
            </td>
            <td>
                <select name="items[${itemIndex}][level_pedas]" class="form-control">
                    ${levelOptions}
                </select>
            </td>
            <td style="text-align:center">
                <button type="button" class="btn-remove">Hapus</button>
            </td>
        `;
        tbody.appendChild(newRow);
        
        const newSelect = newRow.querySelector('.menu-select');
        const stok = parseInt(newSelect.options[newSelect.selectedIndex]?.dataset.stok) || 0;
        updateStokInfo(newRow, stok);
        
        itemIndex++;
        attachEvents();
        calculateTotal();
    };

    // Validasi sebelum submit
    document.getElementById('formTransaksi').onsubmit = function(e) {
        let hasError = false;
        let errorMessage = '';
        
        document.querySelectorAll('.item-row').forEach((row, idx) => {
            const select = row.querySelector('.menu-select');
            const qty = row.querySelector('.qty');
            const selectedOption = select.options[select.selectedIndex];
            const maxStok = parseInt(selectedOption?.dataset.stok) || 0;
            const menuNama = selectedOption?.dataset.nama || '';
            const qtyValue = parseInt(qty.value) || 0;
            
            if (!select.value) {
                hasError = true;
                errorMessage = `Item ${idx + 1}: Pilih menu!`;
                select.focus();
            } else if (qtyValue < 1) {
                hasError = true;
                errorMessage = `Item ${idx + 1}: Qty minimal 1!`;
                qty.focus();
            } else if (qtyValue > 30) {
                hasError = true;
                errorMessage = `Item ${idx + 1}: Maksimal 30!`;
                qty.focus();
            } else if (qtyValue > maxStok) {
                hasError = true;
                errorMessage = `Item ${idx + 1}: Stok ${menuNama} sisa ${maxStok}!`;
                qty.focus();
            }
        });
        
        if (hasError) {
            e.preventDefault();
            alert(errorMessage);
        }
    };

    attachEvents();
    calculateTotal();
</script>

<?= $this->endSection() ?>