<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - MyShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
    
            background-color: #fff;
        }
        .auth-container {
            max-width: 450px;
            width: 100%;
            padding: 40px;
            /* Border mỏng tinh tế */
            border: 1px solid #eee; 
        }
        .form-control {
            border-radius: 0; /* Vuông góc */
            padding: 12px 15px;
            border: 1px solid #ddd;
            background-color: #fafafa;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #000; /* Border đen khi click vào */
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
        .link-custom:hover {
            color: #555;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    
    @include('layout.nav')

    <main class="flex-grow-1 d-flex align-items-center justify-content-center py-5">
        <div class="auth-container shadow-sm">
            <div class="text-center">
                <h2 class="auth-title text-uppercase">Đăng Nhập</h2>
                <p class="auth-subtitle">Chào mừng trở lại. Vui lòng nhập thông tin.</p>
            </div>

            <form action="/auth/ktra" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label small fw-bold text-uppercase">Tên đăng nhập</label>
                    <input type="text" class="form-control" id="email" name="ten" placeholder="Tên đăng nhập" required>
                </div>
                
                <div class="mb-4">
                    <div class="d-flex justify-content-between">
                        <label for="password" class="form-label small fw-bold text-uppercase">Mật khẩu</label>
                        <a href="#" class="text-muted small text-decoration-none">Quên mật khẩu?</a>
                    </div>
                    <input type="password" class="form-control" id="password" name="matkhau" placeholder="••••••••" required>
                </div>

                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-dark-custom">
                        Đăng Nhập
                    </button>
                </div>

                <div class="text-center small">
                    Chưa có tài khoản? 
                    <a href="/auth/dangky" class="link-custom">Đăng ký ngay</a>
                </div>
            </form>
        </div>
    </main>

    @include('layout.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>