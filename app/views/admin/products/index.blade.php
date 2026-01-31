<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản lý sản phẩm</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f8f9fa; font-family: 'Montserrat', sans-serif; }
        .card-header { background: #fff; border-bottom: 1px solid #eee; }
        .table img { border-radius: 5px; object-fit: cover; }
        .admin-content {
            margin-left: 260px; 
            padding: 30px;
            transition: all 0.3s;
        }

        /* Responsive: Trên mobile thì bỏ margin (Sidebar sẽ ẩn hoặc hiện dạng slide) */
        @media (max-width: 768px) {
            .admin-content { margin-left: 0; }
        }

        /* Style chung cho Card */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }
    </style>
</head>

<body>

    @include('layout.admin_sidebar')
<div class="admin-content">
    <div class="container py-4">
        
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header p-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-boxes me-2"></i>Danh sách sản phẩm</h5>
                <a href="/products/add" class="btn btn-primary btn-sm rounded-pill px-3">
                    <i class="fas fa-plus me-1"></i> Thêm mới
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

                <form action="/products/index" method="GET" class="row g-2 mb-4">
                    <div class="col-auto">
                        <div class="input-group">
                            <input type="text" name="tukhoa" class="form-control" placeholder="Nhập tên sản phẩm..." value="<?= $_GET['tukhoa'] ?? '' ?>">
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
                                <th>Ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th style="width: 20%;">Mô tả</th>
                                <th>Danh mục</th>
                                <th>Thương hiệu</th>
                                <th>SL</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($products)): ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        <i class="fas fa-box-open fa-2x mb-2"></i><br>
                                        Không tìm thấy kết quả nào phù hợp!
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td>#<?= $product['id'] ?></td>
                                        <td>
                                            <?php if(!empty($product['img'])): ?>
                                                <img src="/uploads/<?= $product['img'] ?>" alt="" width="50" height="50">
                                            <?php else: ?>
                                                <span class="badge bg-secondary">No Image</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="fw-semibold"><?= $product['name'] ?></td>
                                        <td class="text-danger fw-bold"><?= number_format($product['price']) ?>đ</td>
                                        <td><small class="text-muted"><?= substr($product['mota'], 0, 50) ?>...</small></td>
                                        <td><span class="badge bg-info text-dark bg-opacity-10 border border-info"><?=  $product['tendanhmuc'] ?? 'N/A' ?></span></td>
                                        <td><span class="badge bg-warning text-dark bg-opacity-10 border border-warning"><?= $product['tenthuonghieu'] ?? 'N/A' ?></span></td>
                                        <td><?= $product['soluong'] ?></td>
                                        <td class="text-center">
                                            <a href="/products/edit/<?= $product['id'] ?>" class="btn btn-sm btn-outline-primary border-0" title="Sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="/products/delete/<?= $product['id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')" class="btn btn-sm btn-outline-danger border-0" title="Xóa">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <nav>
                        <ul class="pagination pagination-sm">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                    <a class="page-link" href="/products/index?page=<?= $i ?>&tukhoa=<?= $_GET['tukhoa'] ?? '' ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </div>

    </div>
</body>
</html>