<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - MyShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {

            background-color: #fff;
        }

        .auth-container {
            max-width: 500px;
            /* Rộng hơn form login một chút */
            width: 100%;
            padding: 40px;
            border: 1px solid #eee;
        }

        .form-control {
            border-radius: 0;
            padding: 12px 15px;
            border: 1px solid #ddd;
            background-color: #fafafa;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #000;
            background-color: #fff;
        }

        .btn-dark-custom {
            background-color: #000;
            color: #fff;
            border: 1px solid #000;
            border-radius: 0;
            padding: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: all 0.3s;
        }

        .btn-dark-custom:hover {
            background-color: #fff;
            color: #000;
        }

        .auth-title {
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 0.5rem;
        }

        .auth-subtitle {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        .link-custom {
            color: #000;
            text-decoration: underline;
            font-weight: 600;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <?php echo $__env->make('layout.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="flex-grow-1 d-flex align-items-center justify-content-center py-5">
        <div class="auth-container shadow-sm">
            <div class="text-center">
                <h2 class="auth-title text-uppercase">Tạo Tài Khoản</h2>
                <p class="auth-subtitle">Trở thành thành viên để nhận ưu đãi độc quyền.</p>
            </div>

            <form action="/auth/luu" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label small fw-bold text-uppercase">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com"
                        required>
                </div>
                <div class="mb-3">
                    <label for="fullname" class="form-label small fw-bold text-uppercase">Họ và tên</label>
                    <input type="text" class="form-control" id="fullname" name="ten" placeholder="Nguyễn Văn A"
                        required>
                </div>



                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label small fw-bold text-uppercase">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="matkhau" placeholder="••••••••"
                            required>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="confirm_password" class="form-label small fw-bold text-uppercase">Nhập lại</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                            placeholder="••••••••" required>
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input rounded-0" type="checkbox" id="terms" required>
                    <label class="form-check-label small text-muted" for="terms">
                        Tôi đồng ý với <a href="#" class="text-dark text-decoration-underline">Điều khoản dịch vụ</a> và
                        <a href="#" class="text-dark text-decoration-underline">Chính sách bảo mật</a>
                    </label>
                </div>

                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-dark-custom">
                        Đăng Ký
                    </button>
                </div>
                <div class="text-center text-muted small mb-3" style="position: relative;">
                    <span style="background: #fff; padding: 0 10px; position: relative; z-index: 1;">HOẶC</span>
                    <hr
                        style="position: absolute; top: 50%; left: 0; right: 0; margin: 0; z-index: 0; border-top: 1px solid #ddd;">
                </div>

                <div class="d-grid mb-4">
                    <a href="/auth/dnhapgoogle" class="btn btn-outline-danger text-uppercase"
                        style="border-radius: 0; padding: 12px; font-weight: 700;">
                        <i class="fab fa-google me-2"></i> Đăng ký bằng Google
                    </a>
                </div>

                <div class="text-center small">
                    Đã có tài khoản?
                    <a href="/auth/login" class="link-custom">Đăng nhập</a>
                </div>
            </form>
        </div>
    </main>

    <?php echo $__env->make('layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html><?php /**PATH C:\xampp\htdocs\all_php\php11\app\views/auth/register.blade.php ENDPATH**/ ?>