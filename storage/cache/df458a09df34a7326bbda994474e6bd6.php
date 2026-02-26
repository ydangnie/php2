<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết Đơn Hàng #DH<?php echo e($order['id']); ?> - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">

    <?php echo $__env->make('layout.admin_sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="p-4 min-vh-100" style="margin-left: 260px;">
        
        <div class="mx-auto" style="max-width: 950px; background: #fff; padding: 25px; border: 1px solid #ddd; box-shadow: 0 0 10px rgba(0,0,0,0.05);">

            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <h2 class="fw-bold text-uppercase mb-0 fs-4">Chi tiết Đơn hàng #DH<?php echo e($order['id']); ?></h2>
                <a href="/admin/donhang" class="btn btn-outline-dark rounded-0 btn-sm"><i class="fas fa-arrow-left me-2"></i>Quay lại</a>
            </div>

            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success rounded-0"><i class="fas fa-check-circle me-2"></i><?php echo e($_SESSION['success']); ?> <?php unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger rounded-0"><i class="fas fa-exclamation-triangle me-2"></i><?php echo e($_SESSION['error']); ?> <?php unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <div class="row g-4 mb-4">
                <div class="col-md-7">
                    <div class="card rounded-0 border-dark h-100 shadow-none">
                        <div class="card-header bg-dark text-white rounded-0 fw-bold text-uppercase small">Thông tin giao hàng</div>
                        <div class="card-body">
                            <table class="table table-borderless mb-0 small">
                                <tr><th width="120" class="text-muted p-1">Người nhận:</th><td class="fw-bold p-1"><?php echo e($order['ten_nguoi_nhan']); ?></td></tr>
                                <tr><th class="text-muted p-1">SĐT:</th><td class="fw-bold p-1"><?php echo e($order['sdt']); ?></td></tr>
                                <tr><th class="text-muted p-1">Địa chỉ:</th><td class="p-1"><?php echo e($order['dia_chi']); ?></td></tr>
                                <tr><th class="text-muted p-1">Ghi chú:</th><td class="p-1"><?php echo e($order['ghi_chu'] ?: 'Không có'); ?></td></tr>
                                <tr><th class="text-muted p-1">Ngày đặt:</th><td class="p-1"><?php echo e(date('d/m/Y H:i', strtotime($order['created_at']))); ?></td></tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card rounded-0 border-dark h-100 shadow-none">
                        <div class="card-header bg-dark text-white rounded-0 fw-bold text-uppercase small">Xử lý trạng thái</div>
                        <div class="card-body">
                            <form action="/admin/capNhatDonHang/<?php echo e($order['id']); ?>" method="POST">
                                <?php 
                                    $tt = $order['trang_thai_don'];
                                    $is_locked = ($tt == 'hoan_thanh' || $tt == 'da_huy');
                                ?>
                                
                                <div class="mb-3">
                                    <label class="fw-bold small text-uppercase mb-1">Trạng thái TT:</label>
                                    <select name="trang_thai_tt" class="form-select form-select-sm rounded-0 border-dark" <?php echo e($is_locked ? 'disabled' : ''); ?>>
                                        <option value="chua_thanh_toan" <?php echo e($order['trang_thai_tt'] == 'chua_thanh_toan' ? 'selected' : ''); ?>>Chưa thanh toán</option>
                                        <option value="da_thanh_toan" <?php echo e($order['trang_thai_tt'] == 'da_thanh_toan' ? 'selected' : ''); ?>>Đã thanh toán</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-bold small text-uppercase mb-1">Trạng thái Đơn:</label>
                                    <select name="trang_thai_don" class="form-select form-select-sm rounded-0 border-dark" <?php echo e($is_locked ? 'disabled' : ''); ?>>
                                        <option value="cho_xac_nhan" <?php echo e($tt == 'cho_xac_nhan' ? 'selected' : ''); ?> <?php echo e($tt != 'cho_xac_nhan' ? 'disabled' : ''); ?>>Chờ xác nhận</option>
                                        <option value="dang_giao" <?php echo e($tt == 'dang_giao' ? 'selected' : ''); ?>>Đang giao hàng</option>
                                        <option value="hoan_thanh" <?php echo e($tt == 'hoan_thanh' ? 'selected' : ''); ?>>Hoàn thành</option>
                                        <option value="da_huy" <?php echo e($tt == 'da_huy' ? 'selected' : ''); ?> <?php echo e($tt == 'dang_giao' ? 'disabled' : ''); ?>>Đã hủy</option>
                                    </select>
                                </div>
                                
                                <?php if($is_locked): ?>
                                    <div class="alert alert-warning small rounded-0 border-dark py-2 mb-0">
                                        <i class="fas fa-lock me-1"></i> Đơn hàng đã chốt.
                                    </div>
                                <?php else: ?>
                                    <button type="submit" class="btn btn-dark btn-sm w-100 rounded-0 fw-bold text-uppercase">Cập nhật</button>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-dark rounded-0 shadow-none">
                <div class="card-header bg-white border-bottom border-dark rounded-0 fw-bold text-uppercase small">Chi tiết sản phẩm</div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3 py-2">Sản phẩm</th>
                                <th>Phân loại</th>
                                <th>Đơn giá</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-end pe-3">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="ps-3 py-2">
                                    <div class="d-flex align-items-center">
                                        <img src="/uploads/<?php echo e($item['img']); ?>" width="40" height="40" style="object-fit: cover;" class="me-3 border"> 
                                        <span class="fw-bold"><?php echo e($item['name']); ?></span>
                                    </div>
                                </td>
                                <td>Size: <?php echo e($item['size']); ?> | Màu: <?php echo e($item['color']); ?></td>
                                <td><?php echo e(number_format($item['gia'])); ?>đ</td>
                                <td class="text-center"><?php echo e($item['so_luong']); ?></td>
                                <td class="text-end pe-3 fw-bold text-danger"><?php echo e(number_format($item['gia'] * $item['so_luong'])); ?>đ</td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="4" class="text-end py-3 fw-bold text-uppercase border-top border-dark">Tổng tiền đơn hàng:</td>
                                <td class="text-end pe-3 fs-5 fw-bold text-danger border-top border-dark"><?php echo e(number_format($order['tong_tien'])); ?>đ</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div> </div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\all_php\php11\app\views/admin/donhang/chitiet.blade.php ENDPATH**/ ?>