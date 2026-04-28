<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    .card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 25px;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .header h3 {
        margin: 0;
        color: #333;
    }

    .btn-back {
        background: #6c757d;
        color: #fff;
        padding: 6px 12px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 14px;
        transition: background 0.3s;
    }

    .btn-back:hover {
        background: #5a6268;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        box-sizing: border-box;
        transition: border 0.3s, box-shadow 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: #80bdff;
        box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
    }

    .table th,
    .table td {
        border: 1px solid #ddd;
        padding: 10px;
        vertical-align: top;
    }

    .table th {
        background: #f5f5f5;
        font-weight: 600;
    }

    .btn-add {
        background: #28a745;
        color: #fff;
        padding: 8px 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        margin-bottom: 20px;
        transition: background 0.3s;
    }

    .btn-add:hover {
        background: #218838;
    }

    .btn-remove {
        background: #dc3545;
        color: #fff;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 12px;
        transition: background 0.3s;
    }

    .btn-remove:hover {
        background: #c82333;
    }

    .total-box {
        background: #e9ecef;
        padding: 15px 20px;
        margin: 20px 0;
        text-align: right;
        border-radius: 5px;
    }

    .total-box h4 {
        margin: 0;
        color: #333;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 20px;
    }

    .btn-update {
        background: #ffc107;
        color: #212529;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.3s;
    }

    .btn-update:hover {
        background: #e0a800;
    }

    .btn-batal {
        background: #6c757d;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 14px;
        text-align: center;
        transition: background 0.3s;
    }

    .btn-batal:hover {
        background: #5a6268;
    }
</style>

<div class="card">
    <div class="header">
        <h3>✏️ Edit Transaksi #<?= $transaksi['id'] ?></h3>
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
                <option value="cash" <?= $transaksi['metode_pembayaran'] == 'cash' ? 'selected' : '' ?>>💵 Cash</option>
                <option value="qris" <?= $transaksi['metode_pembayaran'] == 'qris' ? 'selected' : '' ?>>📱 QRIS</option>
            </select>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="pending" <?= $transaksi['status'] == 'pending' ? 'selected' : '' ?>>⏳ Pending</option>
                <option value="menunggu_konfirmasi" <?= $transaksi['status'] == 'menunggu_konfirmasi' ? 'selected' : '' ?>>🔄 Menunggu Konfirmasi</option>
                <option value="lunas" <?= $transaksi['status'] == 'lunas' ? 'selected' : '' ?>>✅ Lunas</option>
            </select>
        </div>

        <h4>📝 Daftar Pesanan</h4>
        <div style="overflow-x: auto;">
            <table class="table" id="tabelItem">
                <thead>
                    <tr>
                        <th width="40%">Menu</th>
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
                                        <option value="<?= $m['id'] ?>" data-harga="<?= $m['harga'] ?>" <?= $item['id_menu'] == $m['id'] ? 'selected' : '' ?>>
                                            <?= $m['nama_menu'] ?> - Rp <?= number_format($m['harga'], 0, ',', '.') ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="items[<?= $index ?>][qty]" class="form-control qty" value="<?= $item['qty'] ?>" min="1" required>
                            </td>
                            <td>
                                <select name="items[<?= $index ?>][level_pedas]" class="form-control">
                                    <option value="">🌶 Tidak Pedas</option>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <option value="<?= $i ?>" <?= $item['level_pedas'] == $i ? 'selected' : '' ?>>🌶️ Level <?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </td>
                            <td style="text-align: center;">
                                <button type="button" class="btn-remove">🗑 Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <button type="button" id="tambahItem" class="btn-add">+ Tambah Item</button>

        <div class="total-box">
            <h4>💰 Total: Rp <span id="totalDisplay"><?= number_format($transaksi['total'], 0, ',', '.') ?></span></h4>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-update">🔄 Update Transaksi</button>
            <a href="<?= base_url('admin/transaksi') ?>" class="btn-batal">Batal</a>
        </div>
    </form>
</div>

<script>
    let itemIndex = <?= count($detail) ?>;

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const select = row.querySelector('.menu-select');
            const selectedOption = select.options[select.selectedIndex];
            const harga = selectedOption ? (parseInt(selectedOption.dataset.harga) || 0) : 0;
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
            alert('Minimal harus ada 1 item pesanan!');
        }
    }

    function attachEvents() {
        document.querySelectorAll('.btn-remove').forEach(btn => {
            btn.removeEventListener('click', removeRow);
            btn.addEventListener('click', removeRow);
        });
        document.querySelectorAll('.menu-select, .qty').forEach(el => {
            el.removeEventListener('change', calculateTotal);
            el.removeEventListener('keyup', calculateTotal);
            el.addEventListener('change', calculateTotal);
            el.addEventListener('keyup', calculateTotal);
        });
    }

    document.getElementById('tambahItem').addEventListener('click', function() {
        const tbody = document.getElementById('itemList');
        const newRow = document.createElement('tr');
        newRow.className = 'item-row';
        
        let menuOptions = '<option value="">-- Pilih Menu --</option>';
        <?php foreach ($menu as $m): ?>
            menuOptions += `<option value="<?= $m['id'] ?>" data-harga="<?= $m['harga'] ?>">
                <?= addslashes($m['nama_menu']) ?> - Rp <?= number_format($m['harga'], 0, ',', '.') ?>
            </option>`;
        <?php endforeach; ?>
        
        let levelOptions = '<option value="">🌶 Tidak Pedas</option>';
        <?php for ($i = 1; $i <= 5; $i++): ?>
            levelOptions += `<option value="<?= $i ?>">🌶️ Level <?= $i ?></option>`;
        <?php endfor; ?>
        
        newRow.innerHTML = `
            <tr>
                <select name="items[${itemIndex}][id_menu]" class="form-control menu-select" required>
                    ${menuOptions}
                </select>
            </td>
            <td>
                <input type="number" name="items[${itemIndex}][qty]" class="form-control qty" value="1" min="1" required>
            </td>
            <td>
                <select name="items[${itemIndex}][level_pedas]" class="form-control">
                    ${levelOptions}
                </select>
            </td>
            <td style="text-align: center;">
                <button type="button" class="btn-remove">🗑 Hapus</button>
            </td>
        `;
        tbody.appendChild(newRow);
        itemIndex++;
        attachEvents();
        calculateTotal();
    });

    document.getElementById('formTransaksi').addEventListener('submit', function(e) {
        let hasError = false;
        let errorMessage = '';
        
        document.querySelectorAll('.item-row').forEach((row, idx) => {
            const select = row.querySelector('.menu-select');
            const qty = row.querySelector('.qty');
            
            if (!select.value) {
                hasError = true;
                errorMessage = `Item ke-${idx + 1}: Silakan pilih menu!`;
                select.focus();
            } else if (!qty.value || parseInt(qty.value) < 1) {
                hasError = true;
                errorMessage = `Item ke-${idx + 1}: Qty minimal 1!`;
                qty.focus();
            }
        });
        
        if (hasError) {
            e.preventDefault();
            alert(errorMessage);
        }
    });

    attachEvents();
    calculateTotal();
</script>

<?= $this->endSection() ?>