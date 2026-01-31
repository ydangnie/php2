<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản lý mã giảm giá</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f8f9fa; font-family: 'Montserrat', sans-serif; }
        .card-header { background: #fff; border-bottom: 1px solid #eee; }
        .admin-content {
            margin-left: 260px; 
            padding: 30px;
            transition: all 0.3s;
        }

        @media (max-width: 768px) {
            .admin-content { margin-left: 0; }
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }
        .badge-percent { background-color: #e3f2fd; color: #0d6efd; border: 1px solid #9ec5fe; }
        .badge-fixed { background-color: #d1e7dd; color: #0f5132; border: 1px solid #a3cfbb; }
    </style>
</head>

<body>

    <?php echo $__env->make('layout.admin_sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="admin-content">
        <div class="container py-4">
            
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header p-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-ticket-alt me-2"></i>Danh sách Mã giảm giá</h5>
                    <a href="/magiamgia/them" class="btn btn-primary btn-sm rounded-pill px-3">
                        <i class="fas fa-plus me-1"></i> Thêm mã mới
                    </a>
                </div>

                <div class="card-body">
                    
                    
                    <?php if (isset($_SESSION['thongbao'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-1"></i> <?= $_SESSION['thongbao']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['thongbao']) ?>
                    <?php endif; ?>

                    
                    <form action="/magiamgia/index" method="GET" class="row g-2 mb-4">
                        <div class="col-auto">
                            <div class="input-group">
                                <input type="text" name="tukhoa" class="form-control" placeholder="Nhập mã code..." value="<?= $_GET['tukhoa'] ?? '' ?>">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fas fa-search"></i> Tìm
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Mã Code</th>
                                    <th>Loại giảm</th>
                                    <th>Giá trị</th>
                                    <th>Số lượng</th>
                                    <th>Hạn sử dụng</th>
                                    <th>Trạng thái</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($ds_ma)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            <i class="fas fa-ticket-alt fa-2x mb-2"></i><br>
                                            Chưa có mã giảm giá nào được tạo!
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    
                                    <?php foreach ($ds_ma as $ma): ?>
                                        <tr>
                                            <td>#<?= $ma['id'] ?></td>
                                            
                                            <td class="fw-bold text-primary text-uppercase">
                                                <?= $ma['ma_code'] ?>
                                            </td>
                                            
                                            <td>
                                                <?php if($ma['loai'] == 'percent'): ?>
                                                    <span class="badge badge-percent">Phần trăm (%)</span>
                                                <?php else: ?>
                                                    <span class="badge badge-fixed">Tiền mặt (VNĐ)</span>
                                                <?php endif; ?>
                                            </td>

                                            <td class="fw-bold">
                                                <?= number_format($ma['gia_tri']) ?> 
                                                <?= $ma['loai'] == 'percent' ? '%' : 'đ' ?>
                                            </td>

                                            <td><?= number_format($ma['so_luong']) ?></td>
                                            
                                            <td>
                                                <?= date('d/m/Y', strtotime($ma['ngay_het_han'])) ?>
                                            </td>
                                            
                                            <td>
                                                <?php if($ma['trang_thai'] == 1): ?>
                                                    <span class="badge bg-success bg-opacity-75">Đang bật</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Đang tắt</span>
                                                <?php endif; ?>
                                            </td>

                                            <td class="text-center">
                                                <a href="/magiamgia/sua/<?= $ma['id'] ?>" class="btn btn-sm btn-outline-primary border-0" title="Sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="/magiamgia/xoa/<?= $ma['id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa mã <?= $ma['ma_code'] ?> này không?')" class="btn btn-sm btn-outline-danger border-0" title="Xóa">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    
                    
                    
                </div>
            </div>
        </div>
    </div>

</body>
</html><?php /**PATH C:\xampp\htdocs\all_php\php11\app\views/admin/magiamgia/index.blade.php ENDPATH**/ ?>