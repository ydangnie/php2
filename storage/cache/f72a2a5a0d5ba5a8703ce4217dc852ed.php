<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f8f9fa; }
        .admin-container {
            max-width: 800px; margin: 0 auto; background: #fff; padding: 40px;
            border: 1px solid #e0e0e0; box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .form-label { font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: #555; margin-bottom: 0.5rem; }
        .form-control, .form-select { border-radius: 0; padding: 10px 15px; border: 1px solid #ddd; background-color: #fff; font-size: 0.95rem; }
        .form-control:focus, .form-select:focus { box-shadow: none; border-color: #000; }
        .btn-dark-custom { background-color: #000; color: #fff; border: 1px solid #000; border-radius: 0; padding: 12px 30px; font-weight: 700; text-transform: uppercase; transition: all 0.3s; }
        .btn-dark-custom:hover { background-color: #333; color: #fff; }
        .btn-outline-cancel { border: 1px solid #ddd; border-radius: 0; color: #666; padding: 12px 30px; font-weight: 600; text-decoration: none; display: inline-block; }
        .btn-outline-cancel:hover { background-color: #f1f1f1; color: #000; }
        .page-header { border-bottom: 2px solid #000; padding-bottom: 15px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <?php echo $__env->make('layout.admin_sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="admin-container">
                
                <div class="page-header">
                    <h3 class="fw-bold text-uppercase m-0">Thêm Sản Phẩm Mới</h3>
                    <a href="/products/index" class="text-muted small text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i> Quay lại
                    </a>
                </div>

                <form action="/products/them" method="POST" enctype="multipart/form-data">
                    
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label">Tên Sản Phẩm</label>
                            <input type="text" class="form-control" name="name" required placeholder="Nhập tên sản phẩm...">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Giá (VNĐ)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="price" required placeholder="0">
                                <span class="input-group-text rounded-0 bg-light">đ</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Số Lượng Tổng</label>
                            <input type="number" class="form-control" name="soluong" required placeholder="0">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Danh Mục</label>
                            <select class="form-select" name="danhmuc_id" required>
                                <option value="">-- Chọn danh mục --</option>
                                <?php if(isset($danhmuc)): ?>
                                    <?php foreach ($danhmuc as $dm): ?>
                                        <option value="<?= $dm['id'] ?>"><?= $dm['tendanhmuc'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Thương Hiệu</label>
                            <select class="form-select" name="thuonghieu_id" required>
                                <option value="">-- Chọn thương hiệu --</option>
                                <?php if(isset($thuonghieu)): ?>
                                    <?php foreach ($thuonghieu as $th): ?>
                                        <option value="<?= $th['id'] ?>"><?= $th['tenthuonghieu'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Mô tả sản phẩm</label>
                            <textarea class="form-control" name="mota" rows="3" placeholder="Nhập thông tin chi tiết sản phẩm..."></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Hình Ảnh Chính</label>
                            <input type="file" class="form-control" name="img" required>
                            <div class="form-text mt-2 small text-muted">Định dạng hỗ trợ: .jpg, .png, .jpeg</div>
                        </div>
                        
                        <div class="col-12 mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">
                                <label class="form-label mb-0 text-primary">Biến thể sản phẩm (Màu/Size)</label>
                                <button type="button" class="btn btn-sm btn-dark rounded-0" id="btn-add-variant">
                                    <i class="fas fa-plus me-1"></i> Thêm dòng
                                </button>
                            </div>
                            <div class="alert alert-light border small text-muted">
                                Nếu sản phẩm có nhiều màu hoặc size, hãy thêm bên dưới.
                            </div>
                            
                            <div id="variant-container">
                                </div>
                        </div>

                        <div class="col-12 mt-4 pt-3 border-top d-flex justify-content-end gap-3">
                            <a href="/products/index" class="btn btn-outline-cancel">Hủy bỏ</a>
                            <button type="submit" class="btn btn-dark-custom">
                                <i class="fas fa-plus me-2"></i> Thêm Sản Phẩm
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('btn-add-variant').addEventListener('click', function() {
            const container = document.getElementById('variant-container');
            const html = `
                <div class="row g-2 mb-2 border p-2 bg-white align-items-end variant-item position-relative">
                    <div class="col-md-3">
                        <label class="small text-muted">Màu sắc</label>
                        <input type="text" name="variants_color[]" class="form-control form-control-sm" placeholder="Vd: Đỏ" required>
                    </div>
                    <div class="col-md-2">
                        <label class="small text-muted">Size</label>
                        <input type="text" name="variants_size[]" class="form-control form-control-sm" placeholder="Vd: XL" required>
                    </div>
                    <div class="col-md-2">
                        <label class="small text-muted">Số lượng</label>
                        <input type="number" name="variants_soluong[]" class="form-control form-control-sm" value="1" required>
                    </div>
                    <div class="col-md-4">
                        <label class="small text-muted">Ảnh riêng (Tùy chọn)</label>
                        <input type="file" name="variants_img[]" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-1 text-end">
                         <button type="button" class="btn btn-danger btn-sm rounded-0" onclick="this.closest('.variant-item').remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\all_php\php11\app\views/admin/products/add.blade.php ENDPATH**/ ?>