<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sửa Mã Giảm Giá</title>
    
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
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); }
        .form-label { font-weight: 600; font-size: 0.9rem; color: #555; }
    </style>
</head>

<body>

    @include('layout.admin_sidebar')

    <div class="admin-content">
        <div class="container py-4">
            
            <div class="card shadow-sm border-0 rounded-3" style="max-width: 800px; margin: 0 auto;">
                <div class="card-header p-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-edit me-2"></i>Sửa Mã: <span class="text-primary"><?= $ma['ma_code'] ?></span>
                    </h5>
                    <a href="/magiamgia/index" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <i class="fas fa-arrow-left me-1"></i> Quay lại
                    </a>
                </div>

                <div class="card-body p-4">
                    
                    <form action="/magiamgia/capnhat/<?= $ma['id'] ?>" method="POST">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Mã Code</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-barcode"></i></span>
                                    <input type="text" name="ma_code" class="form-control text-uppercase" 
                                           value="<?= $ma['ma_code'] ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Loại Giảm</label>
                                <select name="loai" class="form-select">
                                    <option value="fixed" <?= $ma['loai'] == 'fixed' ? 'selected' : '' ?>>Tiền mặt (VNĐ)</option>
                                    <option value="percent" <?= $ma['loai'] == 'percent' ? 'selected' : '' ?>>Phần trăm (%)</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Giá Trị</label>
                                <div class="input-group">
                                    <input type="number" name="gia_tri" class="form-control" 
                                           value="<?= $ma['gia_tri'] ?>" required>
                                    <span class="input-group-text bg-light"><i class="fas fa-tag"></i></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Số Lượng</label>
                                <input type="number" name="so_luong" class="form-control" 
                                       value="<?= $ma['so_luong'] ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ngày Hết Hạn</label>
                            <input type="date" name="ngay_het_han" class="form-control" 
                                   value="<?= date('Y-m-d', strtotime($ma['ngay_het_han'])) ?>" required>
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch p-0 ps-5">
                                <input class="form-check-input ms-0 me-2" type="checkbox" name="trang_thai" id="statusCheck" 
                                       style="float: none;" <?= $ma['trang_thai'] == 1 ? 'checked' : '' ?>>
                                <label class="form-check-label fw-semibold" for="statusCheck">Đang hoạt động</label>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning rounded-pill fw-bold py-2 text-white">
                                <i class="fas fa-check-circle me-2"></i> CẬP NHẬT THAY ĐỔI
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</body>
</html>