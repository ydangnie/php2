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
        body {
            background-color: #f8f9fa;
            font-family: 'Montserrat', sans-serif;
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #eee;
        }

        .table img {
            border-radius: 5px;
            object-fit: cover;
        }

        .admin-content {
            margin-left: 260px;
            padding: 30px;
            transition: all 0.3s;
        }

        @media (max-width: 768px) {
            .admin-content {
                margin-left: 0;
            }
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        }

        .variant-badge {
            font-size: 0.75rem;
            background: #f1f1f1;
            color: #333;
            border: 1px solid #ddd;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
            margin-right: 3px;
            margin-bottom: 3px;
        }
    </style>
</head>

<body>

    <?php echo $__env->make('layout.admin_sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="admin-content">
        <div class="container py-4">

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header p-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-boxes me-2"></i>Danh sách sản phẩm</h5>
                    <a href="/products/add" class="btn btn-dark btn-sm rounded-0 px-3">
                        <i class="fas fa-plus me-1"></i> Thêm mới
                    </a>
                </div>

                <div class="card-body">

                    <?php if (isset($_SESSION['thongbao'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-1"></i> <?= $_SESSION['thongbao']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php    unset($_SESSION['thongbao']) ?>
                    <?php endif; ?>

                    <form action="/products/index" method="GET" class="row g-2 mb-4">
                        <div class="col-auto">
                            <div class="input-group">
                                <input type="text" name="tukhoa" class="form-control rounded-0"
                                    placeholder="Nhập tên sản phẩm..." value="<?= $tukhoa ?? '' ?>">
                                <button class="btn btn-dark rounded-0" type="submit">
                                    <i class="fas fa-search"></i> Tìm
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle border">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Phân loại (Size / Màu)</th>
                                    <th>Giá bán</th>
                                    <th>Danh mục | Thương hiệu</th>
                                    <th class="text-center">Kho</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($products)): ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-5">
                                        Không tìm thấy sản phẩm nào!
                                    </td>
                                </tr>
                                <?php else: ?>
                                <?php    foreach ($products as $product): ?>
                                <tr>
                                    <td class="text-center text-muted small">#<?= $product['id'] ?></td>
                                    <td class="text-center">
                                        <?php        if (!empty($product['img'])): ?>
                                        <img src="/uploads/<?= $product['img'] ?>" width="50" height="50">
                                        <?php        else: ?>
                                        <span class="badge bg-light text-dark border">No IMG</span>
                                        <?php        endif; ?>
                                    </td>
                                    <td class="fw-bold text-dark">
                                        <?= $product['name'] ?>
                                    </td>
                                    <td style="max-width: 200px;">
                                        <?php        if (!empty($product['list_size'])): ?>
                                        <div class="mb-1">
                                            <small class="text-muted fw-bold">Size:</small><br>
                                            <span class="text-dark small"><?= $product['list_size'] ?></span>
                                        </div>
                                        <?php        endif; ?>

                                        <?php        if (!empty($product['list_color'])): ?>
                                        <div>
                                            <small class="text-muted fw-bold">Màu:</small><br>
                                            <span class="text-dark small"><?= $product['list_color'] ?></span>
                                        </div>
                                        <?php        endif; ?>

                                        <?php        if (empty($product['list_size']) && empty($product['list_color'])): ?>
                                        <span class="text-muted small">--</span>
                                        <?php        endif; ?>
                                    </td>
                                    <td class="text-danger fw-bold">
                                        <?= number_format($product['price']) ?> đ
                                    </td>
                                    <td>

                                        <small class="text-muted fw-bold">Tên danh mục:</small>
                                        <span class="text-dark small"><?= $product['tendanhmuc'] ?>
                                        </span>
<br>
                                        <small class="text-muted fw-bold">Tên thương hiệu:</small>
                                        <span class="text-dark small"><?= $product['tenthuonghieu'] ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-bold"><?= $product['soluong'] ?></span>
                                    </td>
                                    <td class="text-center">
                                        <a href="/products/edit/<?= $product['id'] ?>"
                                            class="btn btn-sm btn-outline-dark rounded-0 me-1" title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/products/delete/<?= $product['id'] ?>"
                                            onclick="return confirm('Xóa sản phẩm này và toàn bộ biến thể?')"
                                            class="btn btn-sm btn-danger rounded-0">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php    endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <nav>
                            <ul class="pagination pagination-sm">
                                <?php $searchParams = !empty($tukhoa) ? '&tukhoa=' . $tukhoa : ''; ?>

                                <?php if ($page > 1): ?>
                                <li class="page-item"><a class="page-link text-dark"
                                        href="/products/index?page=<?= $page - 1 ?><?= $searchParams ?>">Trước</a></li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                    <a class="page-link <?= ($i == $page) ? 'bg-dark border-dark text-white' : 'text-dark' ?>"
                                        href="/products/index?page=<?= $i ?><?= $searchParams ?>"><?= $i ?></a>
                                </li>
                                <?php endfor; ?>

                                <?php if ($page < $totalPages): ?>
                                <li class="page-item"><a class="page-link text-dark"
                                        href="/products/index?page=<?= $page + 1 ?><?= $searchParams ?>">Sau</a></li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html><?php /**PATH C:\xampp\htdocs\all_php\php11\app\views/admin/products/index.blade.php ENDPATH**/ ?>