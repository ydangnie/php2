<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản lý danh mục</title>
    
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
                <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-envelope me-2"></i>Danh sách liên hệ</h5>
                <a href="/contacts/them" class="btn btn-primary btn-sm rounded-pill px-3">
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

                <form action="/contacts/index" method="GET" class="row g-2 mb-4">
                    <div class="col-auto">
                        <div class="input-group">
                            <input type="text" name="tukhoa" class="form-control" placeholder="Nhập tên danh mục..." value="<?= $_GET['tukhoa'] ?? '' ?>">
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
                                <th>Full name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($contacts)): ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        <i class="fas fa-box-open fa-2x mb-2"></i><br>
                                        Không tìm thấy kết quả nào phù hợp!
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($contacts as $con): ?>
                                    <tr>
                                        <td>#<?= $con['full_name'] ?></td>
                                        <td><?= $con['email'] ?></td>
                                        <td><?= $con['phone'] ?></td>
                                        <td><?= $con['subject'] ?></td>
                                        <td><?= $con['message'] ?></td>
                                        
                                        </td>

                                        <td class="text-center">
                                            <a href="/contacts/edit/<?= $con['id'] ?>" class="btn btn-sm btn-outline-primary border-0" title="Sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="/contacts/delete/<?= $con['id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')" class="btn btn-sm btn-outline-danger border-0" title="Xóa">
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
</html>