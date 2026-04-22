<!DOCTYPE html>
<html>

<head>

    <!-- FAVICON -->
    <link rel="icon" href="<?= base_url('uploads/favicon.jpeg') ?>">

    <title>Login Admin - Teras Caffe</title>
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
        }

        /* BOX */
        .login-box {
            width: 360px;
            padding: 40px;
            border-radius: 20px;

            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(14px);

            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35);
            text-align: center;

            animation: fadeInUp 0.8s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* TITLE */
        .title {
            font-size: 24px;
            font-weight: 600;
            color: #3b2a21;
            margin-bottom: 5px;
        }

        .subtitle {
            font-size: 13px;
            color: #777;
            margin-bottom: 25px;
        }

        /* ERROR */
        .error {
            background: #ffe8e8;
            color: #b30000;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 13px;
            animation: fadeShake 0.4s ease;
        }

        @keyframes fadeShake {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }

            50% {
                opacity: 1;
                transform: translateX(5px);
            }

            75% {
                transform: translateX(-5px);
            }

            100% {
                transform: translateX(0);
            }
        }

        /* INPUT */
        .input-group {
            margin-bottom: 18px;
            text-align: left;
        }

        .input-group label {
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
            transition: 0.3s;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 12px;
            cursor: pointer;
        }

        input {
            width: 100%;
            padding: 11px 38px;
            border-radius: 10px;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        input:focus {
            border-color: #6f4e37;
            box-shadow: 0 0 8px rgba(111, 78, 55, 0.3);
            outline: none;
        }

        input:focus+i,
        .input-wrapper:hover i {
            color: #6f4e37;
        }

        /* BUTTON */
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
            letter-spacing: 0.5px;
        }

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

        /* LINK */
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

        /* FOOTER */
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #aaa;
        }
    </style>

</head>

<body>

    <div class="login-box">

        <div class="title">
            <i class="fa fa-mug-hot"></i> TERAS CAFFE
        </div>

        <div class="subtitle">
            Admin Login Panel
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form id="loginForm" action="<?= base_url('admin/loginProcess') ?>" method="post" autocomplete="off">

            <?= csrf_field() ?>

            <div class="input-group">
                <label>Username</label>
                <div class="input-wrapper">
                    <i class="fa fa-user"></i>
                    <input type="text" name="username" required>
                </div>
            </div>

            <div class="input-group">
                <label>Password</label>
                <div class="input-wrapper">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" id="password" required>
                    <i class="fa fa-eye toggle-password" id="eye" onclick="togglePassword()"></i>
                </div>
            </div>

            <button id="btnLogin" type="submit">
                <i class="fa fa-sign-in-alt"></i> Login
            </button>
<<<<<<< HEAD
=======

>>>>>>> e9f1942ae234a1fd2fd67a15ae606484ee415c16
        </form>

        <div class="footer">
            Teras Caffe © <?= date('Y') ?>
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
        document.getElementById("loginForm").addEventListener("submit", function() {
            const btn = document.getElementById("btnLogin");
            btn.classList.add("loading");
            btn.innerHTML = 'Loading <span class="spinner"></span>';
        });
    </script>

</body>

</html>
```