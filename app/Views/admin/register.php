<!DOCTYPE html>
<html>

<head>

    <link rel="icon" href="<?= base_url('uploads/favicon.jpeg') ?>">
    <title>Register Admin - Teras Caffe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Poppins", sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;

            background:
                linear-gradient(rgba(59, 42, 33, 0.75), rgba(59, 42, 33, 0.75)),
                url("https://images.unsplash.com/photo-1509042239860-f550ce710b93");

            background-size: cover;
            background-position: center;

            transition: opacity 0.35s ease;
        }

        /* ANIMASI MASUK (lebih smooth) */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .box {
            width: 380px;
            padding: 40px;
            border-radius: 20px;

            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(14px);

            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35);
            text-align: center;

            animation: fadeUp 0.7s ease;
        }

        h2 {
            margin-bottom: 5px;
            color: #3b2a21;
        }

        .subtitle {
            font-size: 13px;
            color: #777;
            margin-bottom: 25px;
        }

        .error {
            background: #ffe8e8;
            color: #b30000;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 13px;
            animation: fadeShake 0.4s ease;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 13px;
        }

        @keyframes fadeShake {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }

            50% {
                opacity: 1;
                transform: translateX(4px);
            }

            75% {
                transform: translateX(-4px);
            }

            100% {
                transform: translateX(0);
            }
        }

        .input {
            margin-bottom: 18px;
            text-align: left;
        }

        .input label {
            font-size: 13px;
            color: #444;
        }

        .input-wrapper {
            position: relative;
            margin-top: 6px;
        }

        .input-wrapper i {
            position: absolute;
            left: 12px;
            top: 12px;
            color: #aaa;
            transition: 0.25s;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 12px;
            cursor: pointer;
        }

        .input input {
            width: 100%;
            padding: 11px 38px;
            border-radius: 10px;
            border: 1px solid #ddd;
            transition: all 0.25s ease;
            font-size: 14px;
        }

        /* FIX: hapus scale biar nggak “loncat” */
        .input input:focus {
            border-color: #6f4e37;
            box-shadow: 0 0 8px rgba(111, 78, 55, 0.3);
            outline: none;
        }

        .input-wrapper:hover i,
        .input input:focus+i {
            color: #6f4e37;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            background: linear-gradient(135deg, #3b2a21, #6f4e37);
            color: white;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.25s ease;
            font-weight: 500;
        }

        /* FIX: hover lebih soft */
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
        }

        button:active {
            transform: scale(0.98);
        }

        button.loading {
            pointer-events: none;
            opacity: 0.85;
        }

        .spinner {
            border: 2px solid #fff;
            border-top: 2px solid transparent;
            border-radius: 50%;
            width: 14px;
            height: 14px;
            display: inline-block;
            animation: spin 0.6s linear infinite;
            margin-left: 6px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .link {
            margin-top: 15px;
            font-size: 13px;
        }

        .link a {
            color: #6f4e37;
            text-decoration: none;
            font-weight: 500;
            transition: 0.2s;
        }

        .link a:hover {
            text-decoration: underline;
        }
    </style>

</head>

<body>

    <div class="box">

        <h2><i class="fa fa-user-plus"></i> Register</h2>
        <div class="subtitle">Buat akun admin baru</div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form id="registerForm" method="post" action="<?= base_url('admin/registerProcess') ?>" autocomplete="off">

            <?= csrf_field() ?>

            <div class="input">
                <label>Username</label>
                <div class="input-wrapper">
                    <i class="fa fa-user"></i>
                    <input type="text" name="username" required>
                </div>
            </div>

            <div class="input">
                <label>Password</label>
                <div class="input-wrapper">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" id="password" required>
                    <i class="fa fa-eye toggle-password" id="eye" onclick="togglePassword()"></i>
                </div>
            </div>

            <button id="btnRegister" type="submit">
                <i class="fa fa-user-plus"></i> Register
            </button>

        </form>

        <div class="link">
            Sudah punya akun?
            <a href="<?= base_url('admin/login') ?>">Login</a>
        </div>

    </div>

    <script>
        function togglePassword() {
            const pass = document.getElementById("password");
            const eye = document.getElementById("eye");

            if (pass.type === "password") {
                pass.type = "text";
                eye.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                pass.type = "password";
                eye.classList.replace("fa-eye-slash", "fa-eye");
            }
        }

        // loading button
        document.getElementById("registerForm").addEventListener("submit", function() {
            const btn = document.getElementById("btnRegister");
            btn.classList.add("loading");
            btn.innerHTML = 'Loading <span class="spinner"></span>';
        });

        // smooth pindah halaman (lebih halus)
        document.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function(e) {
                const target = this.getAttribute('href');

                if (target && !target.includes('#')) {
                    e.preventDefault();

                    document.body.style.opacity = 0;

                    setTimeout(() => {
                        window.location.href = target;
                    }, 250);
                }
            });
        });
    </script>

</body>

</html>
```