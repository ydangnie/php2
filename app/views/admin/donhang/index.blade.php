<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Đơn Hàng - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container-fluid p-0">
        <div class="d-flex min-vh-100">
            
            @include('layout.admin_sidebar')

            <div class="mx-auto" style="max-width: 1300px;">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-4">
                    <h2 class="fw-bold text-uppercase mb-0">Quản lý Đơn hàng</h2>
                </div>

                <div class="card border-dark rounded-0 shadow-sm">
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="ps-3 py-3">Mã ĐH</th>
                                    <th>Khách hàng</th>
                                    <th>Ngày đặt</th>
                                    <th>Tổng tiền</th>
                                    <th>Thanh toán</th>
                                    <th>Trạng thái</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $od)
                                <tr>
                                    <td class="ps-3 fw-bold">#DH{{ $od['id'] }}</td>
                                    <td>
                                        <span class="fw-bold">{{ $od['ten_nguoi_nhan'] }}</span><br>
                                        <small class="text-muted">{{ $od['sdt'] }}</small>
                                    </td>
                                    <td>{{ date('d/m/Y H:i', strtotime($od['created_at'])) }}</td>
                                    <td class="text-danger fw-bold">{{ number_format($od['tong_tien']) }}đ</td>
                                    <td>
                                        @if($od['trang_thai_tt'] == 'da_thanh_toan') 
                                            <span class="badge bg-success rounded-0">Đã TT</span>
                                        @else 
                                            <span class="badge border border-dark text-dark rounded-0">Chưa TT</span> 
                                        @endif
                                    </td>
                                    <td>
                                        @if($od['trang_thai_don'] == 'cho_xac_nhan') <span class="badge bg-secondary rounded-0">Chờ xác nhận</span>
                                        @elseif($od['trang_thai_don'] == 'dang_giao') <span class="badge bg-primary rounded-0">Đang giao</span>
                                        @elseif($od['trang_thai_don'] == 'hoan_thanh') <span class="badge bg-success rounded-0">Hoàn thành</span>
                                        @else <span class="badge bg-danger rounded-0">Đã hủy</span> @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="/admin/chitietDonHang/{{ $od['id'] }}" class="btn btn-sm btn-dark rounded-0">Xem / Xử lý</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>