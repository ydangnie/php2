<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        /* Style bảng chuẩn Admin */
        .table-admin {
            background: #fff;
            border: 1px solid #e0e0e0;
        }
        .table-admin th {
            background-color: #000;
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            padding: 15px;
            white-space: nowrap; /* Giữ tiêu đề không bị xuống dòng */
        }
        .table-admin td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle !important; /* QUAN TRỌNG: Căn giữa dọc để không bị lệch */
        }
        
        /* Ảnh thumbnail chuẩn size */
        .img-thumb-wrapper {
            width: 50px;
            height: 50px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #eee;
            background: #f9f9f9;
        }
        .img-thumb-wrapper img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        /* Nút hành động */
        .btn-action {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd;
            color: #555;
            background: #fff;
            transition: all 0.2s;
            border-radius: 0;
        }
        .btn-action:hover {
            background-color: #000;
            color: #fff;
            border-color: #000;
        }
        .btn-action.delete:hover {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        
        /* Container phẳng */
        .admin-card {
            background: #fff;
            border: 1px solid #eee;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <?php echo $__env->make('layout.admin_sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="flex-grow-1 py-5">
        <div class="container">
            
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-dark">
                <div>
                    <h3 class="fw-bold text-uppercase m-0">Danh Mục</h3>
                    <small class="text-muted">Quản lý phân loại sản phẩm</small>
                </div>
                <a href="/danhmuc/them" class="btn btn-dark rounded-0 fw-bold">
                    <i class="fas fa-plus me-1"></i> THÊM MỚI
                </a>
            </div>

            <div class="admin-card">
                <div class="table-responsive">
                    <table class="table table-admin mb-0">
                        <thead>
                            <tr>
                                <th class="text-center" width="60">ID</th>
                                <th width="100">Hình ảnh</th>
                                <th>Tên danh mục</th>
                                <th class="text-end" width="120">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($danhmuc) && count($danhmuc) > 0): ?>
                                <?php foreach ($danhmuc as $dm): ?>
                                <tr>
                                    <td class="text-center fw-bold text-secondary">#<?= $dm['id'] ?></td>
                                    
                                    <td>
                                        <div class="img-thumb-wrapper">
                                            <?php if(!empty($dm['img'])): ?>
                                                <img src="/uploads/<?= $dm['img'] ?>" alt="Img">
                                            <?php else: ?>
                                                <i class="fas fa-image text-muted"></i>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <span class="fw-bold text-dark"><?= $dm['tendanhmuc'] ?></span>
                                    </td>
                                    
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="/danhmuc/edit/<?= $dm['id'] ?>" class="btn-action" title="Sửa">
                                                <i class="fas fa-pen small"></i>
                                            </a>
                                            <a href="/danhmuc/delete/<?= $dm['id'] ?>" 
                                               class="btn-action delete" 
                                               title="Xóa"
                                               onclick="return confirm('Bạn có chắc muốn xóa danh mục: <?= $dm['tendanhmuc'] ?>?')">
                                                <i class="fas fa-trash small"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="fas fa-folder-open fa-2x mb-3 d-block opacity-50"></i>
                                        Không có dữ liệu danh mục.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\all_php\php11\app\views/admin/danhmuc/index.blade.php ENDPATH**/ ?>