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
        font-weight: 600;
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

    .form-control:focus {
        outline: none;
        border-color: #8B6914;
    }

    h4 {
        margin: 20px 0 12px 0;
        font-size: 15px;
        font-weight: 600;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .table th,
    .table td {
        border: 1px solid #ddd;
        padding: 6px 8px;
        vertical-align: middle;
    }

    .table th {
        background: #60450b;
        text-align: center;
    }

    .table td {
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

    .table .form-control {
        padding: 4px 6px;
        font-size: 12px;
    }

    .table select.form-control {
        min-width: 120px;
    }

    .table input.qty {
        width: 60px;
        text-align: center;
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

    .btn-add {
        background: #28a745;
        color: white;
        padding: 5px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 12px;
        margin-bottom: 15px;
    }

    .total-box {
        background: #f8f9fa;
        padding: 10px 15px;
        margin: 15px 0;
        text-align: right;
        border-radius: 8px;
        border-left: 3px solid #8B6914;
    }

    .total-box h4 {
        margin: 0;
        font-size: 15px;
    }

    .total-box h4 span {
        color: #8B6914;
        font-size: 18px;
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
        padding: 6px 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
    }

    .btn-batal {
        background: #6c757d;
        color: white;
        padding: 6px 16px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        text-align: center;
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
                        <th>Menu</th>
                        <th>Stok</th>
                        <th>Qty</th>
                        <th>Level Pedas</th>
                        <th>Aksi</th>
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
                        <td>
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
        stokBadge.className = 'stok-badge ' + getStokClass(stok);
        stokBadge.innerHTML = getStokText(stok);
        
        const qtyInput = row.querySelector('.qty');
        const maxStok = Math.min(stok, 30);
        qtyInput.max = maxStok;
        qtyInput.disabled = (stok <= 0);
        
        if (qtyInput.disabled) qtyInput.value = 0;
        else if (parseInt(qtyInput.value) > maxStok) qtyInput.value = maxStok;
    }

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const select = row.querySelector('.menu-select');
            const opt = select.options[select.selectedIndex];
            const harga = opt && opt.dataset.harga ? parseInt(opt.dataset.harga) : 0;
            const qty = parseInt(row.querySelector('.qty').value) || 0;
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
                } else alert('Minimal 1 item!');
            };
        });
        
        document.querySelectorAll('.menu-select').forEach(select => {
            select.onchange = function() {
                const row = this.closest('.item-row');
                const stok = parseInt(this.options[this.selectedIndex]?.dataset.stok) || 0;
                updateStokInfo(row, stok);
                calculateTotal();
            };
            select.onchange(); // trigger awal
        });
        
        document.querySelectorAll('.qty').forEach(qty => {
            qty.oninput = calculateTotal;
        });
    }

    document.getElementById('tambahItem').onclick = function() {
        const tbody = document.getElementById('itemList');
        const newRow = document.createElement('tr');
        newRow.className = 'item-row';
        
        let menuOpts = '<option value="">-- Pilih Menu --</option>';
        <?php foreach ($menu as $m): ?>
            menuOpts += `<option value="<?= $m['id'] ?>" data-harga="<?= $m['harga'] ?>" data-stok="<?= $m['stok'] ?>" data-nama="<?= addslashes($m['nama_menu']) ?>"><?= addslashes($m['nama_menu']) ?></option>`;
        <?php endforeach; ?>
        
        let levelOpts = '<option value="">🌶 Tidak</option>';
        <?php for ($i=1;$i<=5;$i++): ?> levelOpts += `<option value="<?= $i ?>">Level <?= $i ?></option>`; <?php endfor; ?>
        
        newRow.innerHTML = `
            <td><select name="items[${itemIndex}][id_menu]" class="form-control menu-select" required>${menuOpts}</select></td>
            <td class="stok-cell"><span class="stok-badge">-</span></td>
            <td><input type="number" name="items[${itemIndex}][qty]" class="form-control qty" value="1" min="1" step="1"></td>
            <td><select name="items[${itemIndex}][level_pedas]" class="form-control">${levelOpts}</select></td>
            <td><button type="button" class="btn-remove">Hapus</button></td>
        `;
        tbody.appendChild(newRow);
        
        const newSelect = newRow.querySelector('.menu-select');
        const stok = parseInt(newSelect.options[newSelect.selectedIndex]?.dataset.stok) || 0;
        updateStokInfo(newRow, stok);
        
        itemIndex++;
        attachEvents();
        calculateTotal();
    };

    document.getElementById('formTransaksi').onsubmit = function(e) {
        let err = false, msg = '';
        document.querySelectorAll('.item-row').forEach((row, i) => {
            const select = row.querySelector('.menu-select');
            const qty = row.querySelector('.qty');
            const opt = select.options[select.selectedIndex];
            const stok = parseInt(opt?.dataset.stok) || 0;
            const nama = opt?.dataset.nama || '';
            const val = parseInt(qty.value) || 0;
            
            if (!select.value) { err = true; msg = `Item ${i+1}: Pilih menu!`; select.focus(); }
            else if (val < 1) { err = true; msg = `Item ${i+1}: Qty minimal 1!`; qty.focus(); }
            else if (val > 30) { err = true; msg = `Item ${i+1}: Maksimal 30!`; qty.focus(); }
            else if (val > stok) { err = true; msg = `Item ${i+1}: Stok ${nama} sisa ${stok}!`; qty.focus(); }
            if (err) return;
        });
        if (err) { e.preventDefault(); alert(msg); }
    };

    attachEvents();
    calculateTotal();
</script>

<?= $this->endSection() ?>