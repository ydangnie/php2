<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hồ Sơ Của Tôi - MyShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/public/css/nav.css">
    <style>
        .avatar-preview { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 2px solid #000; }
        .sidebar-menu a { color: #555; font-weight: 500; border-left: 3px solid transparent; }
        .sidebar-menu a:hover, .sidebar-menu a.active { color: #000; font-weight: bold; border-left-color: #000; background: #f8f9fa; }
    </style>
</head>
<body class="bg-light">
    <?php echo $__env->make('layout.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="container py-5">
        <div class="row g-4">
            <aside class="col-lg-3">
                <div class="card border-dark rounded-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <img src="/uploads/<?php echo e($user_info['avatar'] ?? 'default-avatar.png'); ?>" class="avatar-preview mb-3">
                        <h5 class="fw-bold"><?php echo e($user_info['ten']); ?></h5>
                        <p class="text-muted small"><?php echo e($user_info['email']); ?></p>
                    </div>
                    <div class="list-group list-group-flush sidebar-menu rounded-0 border-top border-dark">
                        <a href="/profile" class="list-group-item list-group-item-action active rounded-0 py-3"><i class="fas fa-user-edit me-2"></i> Thông tin tài khoản</a>
                        <a href="/profile/lichsu" class="list-group-item list-group-item-action rounded-0 py-3"><i class="fas fa-box me-2"></i> Lịch sử đơn hàng</a>
                        <a href="#" class="list-group-item list-group-item-action rounded-0 py-3"><i class="fas fa-key me-2"></i> Đổi mật khẩu</a>
                        <a href="/auth/logout" class="list-group-item list-group-item-action rounded-0 py-3 text-danger"><i class="fas fa-sign-out-alt me-2"></i> Đăng xuất</a>
                    </div>
                </div>
            </aside>

            <section class="col-lg-9">
                <?php if(isset($_SESSION['success'])): ?>
                    <div class="alert alert-success rounded-0"><i class="fas fa-check-circle me-2"></i><?php echo e($_SESSION['success']); ?> <?php unset($_SESSION['success']); ?></div>
                <?php endif; ?>

                <div class="card border-dark rounded-0 shadow-sm mb-4">
                    <div class="card-header bg-dark text-white rounded-0 fw-bold text-uppercase py-3">Hồ sơ của tôi</div>
                    <div class="card-body p-4">
                        <form action="/profile/update" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="old_avatar" value="<?php echo e($user_info['avatar'] ?? 'default-avatar.png'); ?>">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="fw-bold small text-uppercase">Họ và tên</label>
                                        <input type="text" name="name" class="form-control rounded-0 border-dark" value="<?php echo e($user_info['ten']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="fw-bold small text-uppercase">Email đăng nhập (Không thể đổi)</label>
                                        <input type="email" class="form-control rounded-0 border-secondary bg-light" value="<?php echo e($user_info['email']); ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center border-start">
                                    <label class="fw-bold small text-uppercase mb-2 d-block">Ảnh đại diện</label>
                                    <input type="file" name="avatar" class="form-control form-control-sm rounded-0 border-dark mb-2" accept="image/*">
                                    <small class="text-muted">Dung lượng tối đa 2MB. Định dạng: JPEG, PNG.</small>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dark rounded-0 px-4 fw-bold text-uppercase mt-3">Lưu Thay Đổi</button>
                        </form>
                    </div>
                </div>

                <div class="card border-dark rounded-0 shadow-sm">
                    <div class="card-header bg-white border-bottom border-dark rounded-0 fw-bold text-uppercase py-3 d-flex justify-content-between align-items-center">
                        <span>Sổ địa chỉ nhận hàng</span>
                        <button class="btn btn-sm btn-outline-dark rounded-0" data-bs-toggle="modal" data-bs-target="#modalAddAddress"><i class="fas fa-plus"></i> Thêm địa chỉ mới</button>
                    </div>
                    <div class="card-body p-4">
                        <?php if(empty($addresses)): ?>
                            <p class="text-muted text-center my-3">Bạn chưa có địa chỉ nào được lưu.</p>
                        <?php else: ?>
                            <div class="row g-3">
                                <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-12">
                                    <div class="p-3 border <?php echo e($addr['is_default'] ? 'border-dark bg-light' : 'border-secondary'); ?>">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="fw-bold mb-1"><?php echo e($addr['ten_nguoi_nhan']); ?> | <?php echo e($addr['sdt']); ?></h6>
                                            <?php if($addr['is_default']): ?> <span class="badge bg-dark rounded-0">Mặc định</span> <?php endif; ?>
                                        </div>
                                        <p class="mb-0 text-muted"><?php echo e($addr['dia_chi']); ?></p>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <div class="modal fade" id="modalAddAddress" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content rounded-0 border-dark">
                <div class="modal-header bg-dark text-white rounded-0">
                    <h5 class="modal-title fw-bold text-uppercase">Thêm Địa Chỉ Mới</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="/profile/addAddress" method="POST">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="fw-bold small text-uppercase">Họ tên người nhận</label>
                            <input type="text" name="ten_nguoi_nhan" class="form-control rounded-0 border-dark" required>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold small text-uppercase">Số điện thoại</label>
                            <input type="text" name="sdt" class="form-control rounded-0 border-dark" required>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold small text-uppercase">Địa chỉ chi tiết (Số nhà, Phường, Quận)</label>
                            <textarea name="dia_chi" class="form-control rounded-0 border-dark" rows="3" required></textarea>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input border-dark" type="checkbox" name="is_default" id="is_default" value="1">
                            <label class="form-check-label fw-bold" for="is_default">Đặt làm địa chỉ mặc định</label>
                        </div>
                    </div>
                    <div class="modal-footer border-top border-dark">
                        <button type="button" class="btn btn-outline-dark rounded-0" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-dark rounded-0 fw-bold px-4">Lưu Địa Chỉ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php echo $__env->make('layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\all_php\php11\app\views/view/profile.blade.php ENDPATH**/ ?>