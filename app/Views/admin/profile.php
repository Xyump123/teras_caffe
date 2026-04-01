<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #2c1f17, #6f4e37, #a67c52);
        min-height: 100vh;
        background-attachment: fixed;
    }

    body::before {
        content: "";
        position: fixed;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at top left, rgba(255, 255, 255, 0.15), transparent),
            radial-gradient(circle at bottom right, rgba(0, 0, 0, 0.2), transparent);
        z-index: -1;
    }

    /* WRAPPER */
    .container {
        max-width: 900px;
        margin: auto;
        padding: 20px;
    }

    /* TITLE */
    .title {
        text-align: center;
        color: white;
        margin-bottom: 25px;
        letter-spacing: 1px;
    }

    /* CARD */
    .card {
        padding: 30px;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        color: white;
    }

    /* HEADER */
    .profile-header {
        display: flex;
        gap: 25px;
        align-items: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        padding-bottom: 20px;
        margin-bottom: 25px;
    }

    /* FOTO */
    .avatar {
        position: relative;
    }

    .avatar img {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid rgba(255, 255, 255, 0.8);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
    }

    .avatar::before {
        content: "";
        position: absolute;
        top: -8px;
        left: -8px;
        width: 125px;
        height: 125px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.3), transparent);
        z-index: -1;
    }

    /* INFO */
    .profile-info h3 {
        margin: 0;
        font-size: 22px;
    }

    .profile-info p {
        margin: 5px 0;
        color: #eee;
    }

    /* BADGE */
    .badge {
        display: inline-block;
        background: linear-gradient(135deg, #fff, #ddd);
        color: #3b2a21;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    /* DETAIL */
    .detail-box {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        padding: 20px;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .detail-item {
        margin-bottom: 15px;
    }

    .label {
        font-size: 12px;
        color: #ddd;
    }

    .value {
        margin-top: 5px;
        font-size: 15px;
    }

    /* BUTTON */
    .btn-group {
        margin-top: 25px;
        display: flex;
        gap: 15px;
    }

    .btn {
        flex: 1;
        text-align: center;
        padding: 12px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;
        transition: .25s;
    }

    /* PRIMARY */
    .btn-primary {
        background: linear-gradient(135deg, #ffffff, #ddd);
        color: #3b2a21;
        font-weight: 600;
    }

    .btn-primary:hover {
        transform: scale(1.05);
    }

    /* SECONDARY */
    .btn-secondary {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.35);
    }

    /* RESPONSIVE */
    @media (max-width: 600px) {
        .profile-header {
            flex-direction: column;
            text-align: center;
        }

        .btn-group {
            flex-direction: column;
        }
    }
</style>


<div class="container">

    <h2 class="title">Profile Saya</h2>

    <div class="card">

        <!-- HEADER -->
        <div class="profile-header">

            <div class="avatar">
                <img src="<?= session('foto') ? base_url('uploads/' . session('foto')) : 'https://ui-avatars.com/api/?name=' . session('nama') ?>">
            </div>

            <div class="profile-info">
                <h3><?= session('nama') ?></h3>
                <p><?= session('email') ?></p>
                <span class="badge"><?= strtoupper(session('role')) ?></span>
            </div>

        </div>

        <!-- DETAIL -->
        <div class="detail-box">

            <div class="detail-item">
                <div class="label">Username</div>
                <div class="value"><?= session('username') ?></div>
            </div>

            <div class="detail-item">
                <div class="label">Bio</div>
                <div class="value">
                    <?= session('bio') ?: 'Belum ada bio' ?>
                </div>
            </div>

        </div>

        <!-- BUTTON -->
        <div class="btn-group">
            <a href="<?= base_url('admin/edit-profile') ?>" class="btn btn-primary">
                ✏️ Edit Profile
            </a>

            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary">
                ⬅️ Kembali
            </a>
        </div>

    </div>

</div>