<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<style>
    .profile-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        max-width: 700px;
        margin: 0 auto;
        overflow: hidden;
    }
    .profile-header {
        background: linear-gradient(135deg, #3b2a21, #6f4e37);
        padding: 35px 25px 25px;
        text-align: center;
    }
    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid rgba(255,255,255,0.3);
        margin-bottom: 12px;
    }
    .profile-name {
        color: #fff;
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 4px;
    }
    .profile-role {
        display: inline-block;
        background: rgba(255,255,255,0.2);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
        color: #fff;
    }
    .profile-stats {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-top: 18px;
    }
    .stat-number {
        font-size: 20px;
        font-weight: 700;
        color: #fff;
    }
    .stat-label {
        font-size: 10px;
        color: rgba(255,255,255,0.7);
    }
    .profile-body { padding: 25px; }
    .info-section {
        background: #f8f9fa;
        border-radius: 14px;
        padding: 18px;
        margin-bottom: 20px;
    }
    .info-section h4 {
        font-size: 14px;
        font-weight: 600;
        color: #3b2a21;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 2px solid #f0e6d8;
    }
    .info-row {
        display: flex;
        margin-bottom: 10px;
        padding: 5px 0;
    }
    .info-label {
        width: 100px;
        font-weight: 600;
        color: #777;
        font-size: 12px;
    }
    .info-value {
        flex: 1;
        font-size: 13px;
        color: #333;
    }
    .info-value i { margin-right: 6px; color: #8B6914; }
    .bio-text {
        background: #fff;
        padding: 12px;
        border-radius: 10px;
        font-size: 12px;
        color: #666;
        border-left: 3px solid #8B6914;
    }
    .btn-edit {
        display: inline-block;
        background: #8B6914;
        color: #fff;
        padding: 10px 24px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        transition: 0.3s;
    }
    .btn-edit:hover { background: #6B4F12; transform: translateY(-2px); }
    @media (max-width: 600px) {
        .profile-header { padding: 25px 20px; }
        .info-row { flex-direction: column; }
        .info-label { width: 100%; margin-bottom: 4px; }
        .profile-stats { gap: 20px; }
    }
</style>

<div class="profile-card">
    <div class="profile-header">
        <img class="profile-avatar" 
             src="<?= session('foto') ? base_url('uploads/' . session('foto')) : 'https://ui-avatars.com/api/?name=' . urlencode(session('nama') ?? session('username')) . '&background=8B6914&color=fff' ?>">
        <div class="profile-name"><?= session('nama') ?? session('username') ?></div>
        <div class="profile-role"><i class="fa fa-shield-alt"></i> <?= strtoupper(session('role')) ?></div>
        
        <?php
        $db = \Config\Database::connect();
        $totalMenu = $db->table('menu')->countAll();
        $totalTransaksi = $db->table('transaksi')->countAll();
        ?>
        <div class="profile-stats">
            <div><div class="stat-number"><?= $totalMenu ?></div><div class="stat-label">Menu</div></div>
            <div><div class="stat-number"><?= $totalTransaksi ?></div><div class="stat-label">Transaksi</div></div>
        </div>
    </div>

    <div class="profile-body">
        <div class="info-section">
            <h4><i class="fa fa-user-circle"></i> Informasi Pribadi</h4>
            <div class="info-row">
                <div class="info-label"><i class="fa fa-user"></i> Username</div>
                <div class="info-value"><?= session('username') ?></div>
            </div>
            <div class="info-row">
                <div class="info-label"><i class="fa fa-envelope"></i> Email</div>
                <div class="info-value"><?= session('email') ?: '<span style="color:#999;">-</span>' ?></div>
            </div>
            <div class="info-row">
                <div class="info-label"><i class="fa fa-calendar"></i> Bergabung</div>
                <div class="info-value"><?= date('d M Y', strtotime(session('created_at') ?? 'now')) ?></div>
            </div>
        </div>

        <div class="info-section">
            <h4><i class="fa fa-pencil-alt"></i> Bio</h4>
            <div class="bio-text"><?= session('bio') ?: '<span style="color:#999;">Belum ada bio</span>' ?></div>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <a href="<?= base_url('admin/edit-profile') ?>" class="btn-edit">
                <i class="fa fa-edit"></i> Edit Profile
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>