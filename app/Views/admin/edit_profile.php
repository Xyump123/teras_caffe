 <link rel="icon" type="image/jpeg" href="<?= base_url('uploads/favicon.jpeg') ?>">
 <link rel="shortcut icon" type="image/jpeg" href="<?= base_url('uploads/favicon.jpeg') ?>">

 <style>
     /* ===== BACKGROUND ===== */
     body {
         margin: 0;
         font-family: 'Segoe UI', sans-serif;
         background: linear-gradient(135deg, #2c1f17, #6f4e37, #a67c52);
         min-height: 100vh;

         display: flex;
         justify-content: center;
         align-items: center;
     }

     body::before {
         content: "";
         position: fixed;
         width: 100%;
         height: 100%;
         background:
             radial-gradient(circle at top left, rgba(255, 255, 255, 0.15), transparent),
             radial-gradient(circle at bottom right, rgba(0, 0, 0, 0.25), transparent);
         z-index: -1;
     }

     /* ===== CONTAINER ===== */
     .container {
         width: 100%;
         max-width: 460px;
         padding: 20px;
     }

     /* TITLE */
     .title {
         text-align: center;
         color: white;
         margin-bottom: 25px;
         font-weight: 600;
         letter-spacing: 0.5px;
     }

     /* CARD */
     .card {
         padding: 28px;
         border-radius: 18px;
         background: rgba(255, 255, 255, 0.12);
         backdrop-filter: blur(18px);
         border: 1px solid rgba(255, 255, 255, 0.2);
         box-shadow: 0 15px 35px rgba(0, 0, 0, 0.35);
         color: white;
     }

     /* ALERT */
     .alert {
         background: rgba(0, 255, 150, 0.15);
         border: 1px solid rgba(0, 255, 150, 0.3);
         padding: 12px;
         border-radius: 10px;
         margin-bottom: 20px;
         font-size: 14px;
     }

     /* FORM */
     .form-group {
         margin-bottom: 20px;
         position: relative;
     }

     /* INPUT */
     .form-group input,
     .form-group textarea {
         width: 100%;
         padding: 14px;
         border-radius: 10px;
         border: 1px solid rgba(255, 255, 255, 0.25);
         background: rgba(255, 255, 255, 0.15);
         color: white;
         outline: none;
         font-size: 14px;
         transition: 0.2s;
     }

     .form-group input:focus,
     .form-group textarea:focus {
         border-color: #fff;
         background: rgba(255, 255, 255, 0.2);
     }

     /* LABEL */
     .form-group label {
         position: absolute;
         top: -8px;
         left: 12px;
         font-size: 11px;
         color: #eee;
         background: rgba(0, 0, 0, 0.4);
         padding: 2px 6px;
         border-radius: 6px;
     }

     /* FOTO */
     .photo-wrapper {
         text-align: center;
         margin-bottom: 10px;
     }

     .photo-wrapper img {
         width: 90px;
         height: 90px;
         border-radius: 50%;
         border: 3px solid white;
         object-fit: cover;
         box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
     }

     /* FILE INPUT */
     .file-input {
         display: block;
         text-align: center;
         background: rgba(255, 255, 255, 0.2);
         padding: 10px;
         border-radius: 10px;
         cursor: pointer;
         font-size: 13px;
         transition: 0.2s;
     }

     .file-input:hover {
         background: rgba(255, 255, 255, 0.35);
     }

     input[type="file"] {
         display: none;
     }

     /* BUTTON */
     .btn-group {
         display: flex;
         gap: 10px;
         margin-top: 25px;
     }

     .btn {
         flex: 1;
         padding: 12px;
         border-radius: 10px;
         border: none;
         cursor: pointer;
         font-size: 14px;
         transition: 0.2s;
     }

     /* PRIMARY */
     .btn-primary {
         background: linear-gradient(135deg, #ffffff, #e0e0e0);
         color: #3b2a21;
         font-weight: 600;
     }

     .btn-primary:hover {
         transform: translateY(-1px);
     }

     /* SECONDARY */
     .btn-secondary {
         background: rgba(255, 255, 255, 0.2);
         color: white;
         text-align: center;
         text-decoration: none;
     }

     .btn-secondary:hover {
         background: rgba(255, 255, 255, 0.35);
     }
 </style>


 <div class="container">

     <h2 class="title">Edit Profile</h2>

     <div class="card">

         <?php if (session()->getFlashdata('success')): ?>
             <div class="alert">
                 <?= session('success') ?>
             </div>
         <?php endif; ?>

         <form action="<?= base_url('admin/update-profile') ?>" method="post" enctype="multipart/form-data">

             <div class="form-group">
                 <input type="text" name="nama" value="<?= session('nama') ?>">
                 <label>Nama</label>
             </div>

             <div class="form-group">
                 <input type="email" name="email" value="<?= session('email') ?>">
                 <label>Email</label>
             </div>

             <div class="form-group">
                 <textarea name="bio" rows="3"><?= session('bio') ?></textarea>
                 <label>Bio</label>
             </div>

             <!-- FOTO -->
             <div class="form-group">
                 <div class="photo-wrapper">
                     <img id="preview"
                         src="<?= session('foto') ? base_url('uploads/' . session('foto')) : 'https://ui-avatars.com/api/?name=' . session('nama') ?>">
                 </div>

                 <label class="file-input">
                     📷 Pilih Foto
                     <input type="file" name="foto" onchange="previewImage(event)">
                 </label>
             </div>

             <div class="btn-group">
                 <button type="submit" class="btn btn-primary">
                     💾 Simpan
                 </button>

                 <a href="<?= base_url('admin/profile') ?>" class="btn btn-secondary">
                     ⬅️ Batal
                 </a>
             </div>

         </form>

     </div>

 </div>

 <script>
     function previewImage(event) {
         const reader = new FileReader();
         reader.onload = function() {
             document.getElementById('preview').src = reader.result;
         }
         reader.readAsDataURL(event.target.files[0]);
     }
 </script>