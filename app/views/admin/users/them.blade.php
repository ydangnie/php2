<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thêm Người Dùng</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f8f9fa; font-family: 'Montserrat', sans-serif; }
        
        /* Layout Admin */
        .admin-content {
            margin-left: 260px; /* Khớp với sidebar của bạn */
            padding: 30px;
            transition: all 0.3s;
        }
        @media (max-width: 768px) {
            .admin-content { margin-left: 0; }
        }

        /* Card Style */
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .form-label { font-weight: 600; font-size: 0.9rem; color: #333; }
        .form-control, .form-select {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #dee2e6;
        }
        .form-control:focus, .form-select:focus {
            border-color: #000;
            box-shadow: 0 0 0 0.25rem rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    @include('layout.admin_sidebar');

    <div class="admin-content">
        <div class="container py-4">
            
            <div class="card shadow-sm border-0 rounded-3" style="max-width: 700px; margin: 0 auto;">
                <div class="card-header bg-white p-4 border-bottom-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-uppercase"><i class="fas fa-user-plus me-2"></i>Thêm Người Dùng Mới</h5>
                    <a href="/users/index" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <i class="fas fa-arrow-left me-1"></i> Quay lại
                    </a>
                </div>

                <div class="card-body p-4 pt-0">
                    
                    <form action="/users/luu" method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-4">
                            <label class="form-label">Họ và Tên</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-user"></i></span>
                                <input type="text" name="ten" class="form-control border-start-0 ps-0" required placeholder="Nhập tên người dùng...">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control border-start-0 ps-0" placeholder="Nhập địa chỉ email...">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Mật khẩu</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock"></i></span>
                                <input type="password" name="matkhau" class="form-control border-start-0 ps-0" required placeholder="Nhập mật khẩu...">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Vai trò (Role)</label>
                            <select name="role" class="form-select">
                                <option value="nguoidung">Người dùng (Khách hàng)</option>
                                <option value="admin">Quản trị viên (Admin)</option>
                            </select>
                            <div class="form-text text-muted small mt-1">Chọn cấp độ truy cập cho tài khoản này.</div>
                        </div>

                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-dark py-3 rounded-pill fw-bold text-uppercase shadow-sm">
                                <i class="fas fa-save me-2"></i> Lưu Tài Khoản
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>