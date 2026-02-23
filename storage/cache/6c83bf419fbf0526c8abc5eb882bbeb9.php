<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sửa Người Dùng</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f8f9fa; font-family: 'Montserrat', sans-serif; }
        
        .admin-content {
            margin-left: 260px; /* Khớp với sidebar */
            padding: 30px;
            transition: all 0.3s;
        }
        
        @media (max-width: 768px) {
            .admin-content { margin-left: 0; }
        }

        .card { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .form-control, .form-select { border-radius: 8px; padding: 12px; }
        .form-control:focus { border-color: #000; box-shadow: 0 0 0 0.2rem rgba(0,0,0,0.1); }
    </style>
</head>

<body>

    <?php echo $__env->make('layout.admin_sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="admin-content">
        <div class="container py-4">
            
            <div class="card shadow-sm border-0 rounded-3" style="max-width: 700px; margin: 0 auto;">
                <div class="card-header bg-white p-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-uppercase">
                        <i class="fas fa-user-edit me-2"></i>Sửa: <span class="text-primary"><?= $user['ten'] ?></span>
                    </h5>
                    <a href="/users/index" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <i class="fas fa-arrow-left me-1"></i> Quay lại
                    </a>
                </div>

                <div class="card-body p-4 pt-0">
                    
                    <form action="/users/update/<?= $user['id'] ?>" method="POST">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Họ và Tên</label>
                            <input type="text" name="ten" class="form-control" value="<?= $user['ten'] ?>" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= $user['email'] ?? '' ?>" placeholder="Chưa cập nhật email">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Mật khẩu mới</label>
                            <input type="password" name="matkhau" class="form-control" placeholder="Để trống nếu không muốn thay đổi">
                            <div class="form-text">Chỉ nhập nếu bạn muốn đổi mật khẩu mới cho user này.</div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-bold">Vai trò</label>
                            <select name="role" class="form-select">
                                <option value="0" <?= $user['role'] == 0 ? 'selected' : '' ?>>Người dùng (Member)</option>
                                <option value="1" <?= $user['role'] == 1 ? 'selected' : '' ?>>Quản trị viên (Admin)</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning py-3 rounded-pill fw-bold text-white shadow-sm">
                                <i class="fas fa-check-circle me-2"></i> Cập nhật thay đổi
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\all_php\php11\app\views/admin/users/edit.blade.php ENDPATH**/ ?>