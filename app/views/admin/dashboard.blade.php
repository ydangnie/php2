<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Quản Trị</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { 
            background-color: #f0f2f5; 
            font-family: 'Montserrat', sans-serif; 
        }
        
        /* Layout Fix */
        .admin-content {
            margin-left: 260px; /* Bằng chiều rộng Sidebar */
            padding: 30px;
            min-height: 100vh;
            transition: all 0.3s;
        }

        /* Card Stats */
        .stat-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.2s;
            background: #fff;
            overflow: hidden;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .icon-box {
            width: 60px; height: 60px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
            opacity: 0.2;
        }
        
        /* Table Style */
        .table-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
            border: none;
        }
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #eee;
            color: #6c757d;
            font-size: 0.85rem;
            text-transform: uppercase;
        }
    </style>
</head>

<body>

    @include('layout.admin_sidebar')

    <div class="admin-content">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-0">Dashboard</h3>
                <p class="text-muted small">Chào mừng trở lại, quản trị viên.</p>
            </div>
            <button class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fas fa-plus me-2"></i>Thêm Mới
            </button>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="stat-card p-3 d-flex align-items-center justify-content-between border-start border-5 border-primary">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Sản phẩm</span>
                        <h2 class="fw-bold mb-0 text-dark">{{ $countProducts ?? 0 }}</h2>
                    </div>
                    <div class="icon-box bg-primary text-primary">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card p-3 d-flex align-items-center justify-content-between border-start border-5 border-success">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Doanh thu</span>
                        <h2 class="fw-bold mb-0 text-dark">15.2M</h2>
                    </div>
                    <div class="icon-box bg-success text-success">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card p-3 d-flex align-items-center justify-content-between border-start border-5 border-warning">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Đơn hàng</span>
                        <h2 class="fw-bold mb-0 text-dark">{{ $countOrders ?? 0 }}</h2>
                    </div>
                    <div class="icon-box bg-warning text-warning">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card p-3 d-flex align-items-center justify-content-between border-start border-5 border-info">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Khách hàng</span>
                        <h2 class="fw-bold mb-0 text-dark">{{ $countUsers ?? 0 }}</h2>
                    </div>
                    <div class="icon-box bg-info text-info">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card table-card h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="mb-0 fw-bold">Đơn hàng gần đây</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 table-hover">
                            <thead>
                                <tr>
                                    <th>Mã đơn</th>
                                    <th>Khách hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#ORD-001</td>
                                    <td>Nguyễn Văn A</td>
                                    <td>1,200,000đ</td>
                                    <td><span class="badge bg-success bg-opacity-10 text-success">Hoàn thành</span></td>
                                </tr>
                                <tr>
                                    <td>#ORD-002</td>
                                    <td>Trần Thị B</td>
                                    <td>550,000đ</td>
                                    <td><span class="badge bg-warning bg-opacity-10 text-warning">Chờ xử lý</span></td>
                                </tr>
                                <tr>
                                    <td>#ORD-003</td>
                                    <td>Lê Văn C</td>
                                    <td>2,100,000đ</td>
                                    <td><span class="badge bg-danger bg-opacity-10 text-danger">Hủy</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                 <div class="card table-card mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Thông báo hệ thống</h6>
                        <div class="d-flex align-items-start mb-3">
                            <i class="fas fa-info-circle text-primary mt-1 me-2"></i>
                            <div>
                                <small class="fw-bold d-block">Bảo trì hệ thống</small>
                                <small class="text-muted">Hệ thống sẽ bảo trì vào 12:00 PM.</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-start">
                            <i class="fas fa-check-circle text-success mt-1 me-2"></i>
                            <div>
                                <small class="fw-bold d-block">Cập nhật thành công</small>
                                <small class="text-muted">Phiên bản v2.0 đã được cài đặt.</small>
                            </div>
                        </div>
                    </div>
                 </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>