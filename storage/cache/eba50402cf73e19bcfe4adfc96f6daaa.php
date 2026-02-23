<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa danh mục - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa; /* Nền xám nhạt cho trang admin đỡ mỏi mắt */
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
        .current-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 1px solid #eee;
            padding: 3px;
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

    <?php echo $__env->make('layout.admin_sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="admin-container">
                
                <div class="page-header">
                    <h3 class="fw-bold text-uppercase m-0">Sửa Danh Mục</h3>
                    <a href="/contacts/index" class="text-muted small text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i> Quay lại
                    </a>
                </div>

                <form action="/contacts/update/<?= $contact['id'] ?>" method="POST" enctype="multipart/form-data">
                    
                    <div class="row g-4">
                           <div class="col-12">
                            <label class="form-label">Full name</label>
                            <input type="text" class="form-control" name="full_name" required
                                placeholder="Nhập tên đầy đủ..." value="<?= $contacts['full_name'] ?>">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required placeholder="Nhập email..." value="<?= $contacts['email'] ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" required
                                placeholder="Nhập số điện thoại..." value="<?= $contacts['phone'] ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Subject</label>
                            <input type="text" class="form-control" name="subject" required placeholder="Nhập chủ đề..." value="<?= $contacts['subject'] ?>">
                        </div>
                          <div class="col-12">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" name="message" required placeholder="Nhập nội dung tin nhắn..."><?= $contacts['message'] ?></textarea>
                        </div>


                

                        <div class="col-12 mt-4 pt-3 border-top d-flex justify-content-end gap-3">
                            <a href="/contacts/index" class="btn btn-outline-cancel">Hủy bỏ</a>
                            <button type="submit" class="btn btn-dark-custom">
                                <i class="fas fa-save me-2"></i> Lưu Thay Đổi
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\all_php\php11\app\views/admin/contacts/edit.blade.php ENDPATH**/ ?>