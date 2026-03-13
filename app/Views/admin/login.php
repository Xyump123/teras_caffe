<!DOCTYPE html>
<html>

<head>

    <!-- FAVICON -->
    <link rel="icon" type="image/jpeg" href="<?= base_url('uploads/favicon.jpeg') ?>">
    <link rel="shortcut icon" type="image/jpeg" href="<?= base_url('uploads/favicon.jpeg') ?>">

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
                linear-gradient(rgba(59, 42, 33, 0.85), rgba(59, 42, 33, 0.85)),
                url("https://images.unsplash.com/photo-1509042239860-f550ce710b93");

            background-size: cover;
            background-position: center;
        }

        /* LOGIN BOX */

        .login-box {
            width: 360px;
            padding: 40px;
            border-radius: 18px;

            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(8px);

            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            text-align: center;

            animation: fadeIn 0.7s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(25px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
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
        }

        /* INPUT */

        .input-group {
            margin-bottom: 18px;
            text-align: left;
        }

        .input-group label {
            font-size: 13px;
            color: #555;
        }

        .input-wrapper {
            position: relative;
            margin-top: 5px;
        }

        .input-wrapper i {
            position: absolute;
            left: 12px;
            top: 12px;
            color: #888;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 12px;
            cursor: pointer;
            color: #888;
        }

        input {
            width: 100%;
            padding: 11px 35px 11px 35px;
            border-radius: 10px;
            border: 1px solid #ddd;
            transition: 0.3s;
        }

        input:focus {
            border-color: #6f4e37;
            outline: none;
        }

        /* BUTTON */

        button {
            width: 100%;
            padding: 12px;
            border: none;
            background: #3b2a21;
            color: white;
            border-radius: 25px;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 5px;
        }

        button:hover {
            background: #6f4e37;
            transform: scale(1.03);
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

        <form action="<?= base_url('admin/loginProcess') ?>" method="post">

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
                    <i class="fa fa-eye toggle-password" onclick="togglePassword()"></i>
                </div>
            </div>

            <button type="submit">
                <i class="fa fa-sign-in-alt"></i> Login
            </button>

        </form>

        <div class="footer">
            Teras Caffe © <?= date('Y') ?>
        </div>

    </div>

    <script>
        function togglePassword() {

            var pass = document.getElementById("password");

            if (pass.type === "password") {
                pass.type = "text";
            } else {
                pass.type = "password";
            }

        }
    </script>

</body>

</html>