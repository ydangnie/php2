<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm thương hiệu - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .admin-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .form-label {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #555;
            margin-bottom: 0.5rem;
        }
        .form-control, .form-select {
            border-radius: 0;
            padding: 10px 15px;
            border: 1px solid #ddd;
            background-color: #fff;
            font-size: 0.95rem;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: none;
            border-color: #000;
            background-color: #fff;
        }
        .btn-dark-custom {
            background-color: #000;
            color: #fff;
            border: 1px solid #000;
            border-radius: 0;
            padding: 12px 30px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }
        .btn-dark-custom:hover {
            background-color: #333;
            color: #fff;
        }
        .btn-outline-cancel {
            border: 1px solid #ddd;
            border-radius: 0;
            color: #666;
            padding: 12px 30px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
        }
        .btn-outline-cancel:hover {
            background-color: #f1f1f1;
            color: #000;
        }
        .page-header {
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    @include('layout.admin_sidebar')

    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="admin-container">
                
                <div class="page-header">
                    <h3 class="fw-bold text-uppercase m-0">Thêm thương hiệu</h3>
                    <a href="/thuonghieu/index" class="text-muted small text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i> Quay lại
                    </a>
                </div>

                <form action="/thuonghieu/luu" method="POST" enctype="multipart/form-data">
                    
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label">Tên thương hiệu</label>
                            <input type="text" class="form-control" name="tenthuonghieu" required placeholder="Nhập tên thương hiệu...">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Hình Ảnh</label>
                            <input type="file" class="form-control" name="img" required>
                            <div class="form-text mt-2 small text-muted">Định dạng hỗ trợ: .jpg, .png, .jpeg</div>
                        </div>

                        <div class="col-12 mt-4 pt-3 border-top d-flex justify-content-end gap-3">
                            <a href="/thuonghieu/index" class="btn btn-outline-cancel">Hủy bỏ</a>
                            <button type="submit" class="btn btn-dark-custom">
                                <i class="fas fa-plus me-2"></i> Thêm thương hiệu
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </main>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>