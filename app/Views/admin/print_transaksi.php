<?php
$transaksi = $transaksi ?? [];
$detail = $detail ?? [];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Struk #<?= $transaksi['id'] ?></title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family: Consolas, "Courier New", monospace;
    font-size:12px;
    color:#000;
    background:#fff;
}

.receipt{
    width:100%;
    max-width:100%;
    padding:10px;
}

.center{
    text-align:center;
}

.bold{
    font-weight:bold;
}

.line{
    border-top:1px dashed #000;
    margin:8px 0;
}

.row{
    display:flex;
    justify-content:space-between;
    margin:2px 0;
}

.menu{
    margin:6px 0;
}

.menu-name{
    font-weight:bold;
}

.total{
    display:flex;
    justify-content:space-between;
    font-weight:bold;
    font-size:15px;
    margin-top:10px;
}

.footer{
    text-align:center;
    margin-top:15px;
}

.actions{
    text-align:center;
    margin-top:20px;
}

.btn{
    padding:10px 18px;
    border:none;
    background:#8B6914;
    color:white;
    border-radius:6px;
    cursor:pointer;
}

@media print {

    .actions{
        display:none;
    }

    body{
        margin:0;
        padding:0;
    }

    .receipt{
        width:100%;
        padding:3mm;
    }

    @page{
        margin:0;
    }
}

</style>
</head>
<body>

<div class="receipt">

    <div class="center">
        <div class="bold" style="font-size:18px">
            TERAS CAFFE
        </div>

        <div>Jl. Contoh No.123</div>
        <div>Subang</div>
        <div>0812-3456-7890</div>
    </div>

    <div class="line"></div>

    <div>ID Transaksi : #<?= $transaksi['id'] ?></div>
    <div>Meja : <?= $transaksi['meja'] ?></div>
    <div>Metode : <?= strtoupper($transaksi['metode_pembayaran']) ?></div>
    <div>Status : <?= strtoupper($transaksi['status']) ?></div>
    <div>Tanggal : <?= date('d-m-Y H:i', strtotime($transaksi['created_at'])) ?></div>

    <div class="line"></div>

    <?php foreach($detail as $d): ?>

        <div class="menu">

            <div class="menu-name">
                <?= esc($d['nama_menu']) ?>
            </div>

            <div class="row">
                <span>
                    <?= $d['qty'] ?> x Rp <?= number_format($d['harga'],0,',','.') ?>
                </span>

                <span>
                    Rp <?= number_format($d['subtotal'],0,',','.') ?>
                </span>
            </div>

            <?php if(!empty($d['level_pedas'])): ?>
                <div>
                    Level Pedas : <?= $d['level_pedas'] ?>
                </div>
            <?php endif; ?>

        </div>

    <?php endforeach; ?>

    <div class="line"></div>

    <div class="total">
        <span>TOTAL</span>
        <span>
            Rp <?= number_format($transaksi['total'],0,',','.') ?>
        </span>
    </div>

    <div class="line"></div>

    

    <div class="footer">

        Terima Kasih<br>
        Selamat Menikmati

        <br><br>

        <?= date('d-m-Y H:i:s') ?>

    </div>

</div>

<div class="actions">
    <button onclick="window.print()" class="btn">
        Cetak Struk
    </button>
</div>

<script>

window.onload = function(){

    setTimeout(function(){
        window.print();
    },500);

};

window.onafterprint = function(){
    window.close();
};

</script>

</body>
</html>