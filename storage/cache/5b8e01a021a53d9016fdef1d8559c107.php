<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch Sử Đơn Hàng - MyShop</title>
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

    <main class="container py-5 min-vh-100">
        <div class="row g-4">
            <aside class="col-lg-3">
                <div class="card border-dark rounded-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <img src="/uploads/<?php echo e($user_info['avatar'] ?? 'default-avatar.png'); ?>" class="avatar-preview mb-3">
                        <h5 class="fw-bold"><?php echo e($user_info['name']); ?></h5>
                        <p class="text-muted small"><?php echo e($user_info['email']); ?></p>
                    </div>
                    <div class="list-group list-group-flush sidebar-menu rounded-0 border-top border-dark">
                        <a href="/profile" class="list-group-item list-group-item-action rounded-0 py-3"><i class="fas fa-user-edit me-2"></i> Thông tin tài khoản</a>
                        <a href="/profile/lichsu" class="list-group-item list-group-item-action active rounded-0 py-3"><i class="fas fa-box me-2"></i> Lịch sử đơn hàng</a>
                        <a href="/auth/logout" class="list-group-item list-group-item-action rounded-0 py-3 text-danger"><i class="fas fa-sign-out-alt me-2"></i> Đăng xuất</a>
                    </div>
                </div>
            </aside>

<section class="col-lg-9">
                
                <?php if(isset($_SESSION['success'])): ?>
                    <div class="alert alert-success rounded-0"><i class="fas fa-check-circle me-2"></i><?php echo e($_SESSION['success']); ?> <?php unset($_SESSION['success']); ?></div>
                <?php endif; ?>
                <?php if(isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger rounded-0"><i class="fas fa-exclamation-triangle me-2"></i><?php echo e($_SESSION['error']); ?> <?php unset($_SESSION['error']); ?></div>
                <?php endif; ?>

                <div class="card border-dark rounded-0 shadow-sm mb-4">
                    <div class="card-header bg-dark text-white rounded-0 fw-bold text-uppercase py-3">Đơn hàng của tôi</div>
                    <div class="card-body p-4">
                        <?php if(empty($orders)): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Bạn chưa có đơn hàng nào.</p>
                                <a href="/view/sanpham" class="btn btn-dark rounded-0 px-4">Mua sắm ngay</a>
                            </div>
                        <?php else: ?>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $od): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border border-dark mb-4 p-3 position-relative">
                                <div class="position-absolute top-0 end-0 mt-3 me-3">
                                    <?php if($od['trang_thai_don'] == 'cho_xac_nhan'): ?> <span class="badge bg-secondary rounded-0">Chờ xác nhận</span>
                                    <?php elseif($od['trang_thai_don'] == 'dang_giao'): ?> <span class="badge bg-primary rounded-0">Đang giao hàng</span>
                                    <?php elseif($od['trang_thai_don'] == 'hoan_thanh'): ?> <span class="badge bg-success rounded-0">Đã giao thành công</span>
                                    <?php else: ?> <span class="badge bg-danger rounded-0">Đã hủy</span> <?php endif; ?>
                                </div>
                                
                                <h6 class="fw-bold text-uppercase mb-1">Mã đơn: #DH<?php echo e($od['id']); ?></h6>
                                <p class="small text-muted mb-3">Ngày đặt: <?php echo e(date('d/m/Y H:i', strtotime($od['created_at']))); ?></p>
                                
                                <hr class="border-secondary">
                                
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        <p class="mb-1 small text-muted">
                                            Thanh toán: 
                                            <span class="fw-bold <?php echo e($od['trang_thai_tt'] == 'da_thanh_toan' ? 'text-success' : 'text-danger'); ?>">
                                                <?php echo e($od['trang_thai_tt'] == 'da_thanh_toan' ? 'Đã thanh toán' : 'Chưa thanh toán (COD)'); ?>

                                            </span>
                                        </p>
                                        
                                        <?php if($od['trang_thai_don'] == 'cho_xac_nhan'): ?>
                                            <a href="/profile/huydon/<?php echo e($od['id']); ?>" class="btn btn-outline-danger btn-sm rounded-0 mt-2 fw-bold" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không? Thao tác này không thể hoàn tác.');">
                                                <i class="fas fa-times me-1"></i> Hủy đơn hàng
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <p class="mb-0 fw-bold text-end">Tổng tiền: <br><span class="text-danger fs-5"><?php echo e(number_format($od['tong_tien'])); ?>đ</span></p>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <?php echo $__env->make('layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\all_php\php11\app\views/view/lichsu_donhang.blade.php ENDPATH**/ ?>