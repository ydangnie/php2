<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh Toán - MyShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/public/css/nav.css">
</head>
<body class="bg-light">
    @include('layout.nav')

    <main class="container py-5">
        <h2 class="fw-bold text-uppercase mb-4">Thanh Toán Đơn Hàng</h2>
        
        <form action="/checkout/process" method="POST">
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="card border-dark rounded-0 shadow-sm">
                        <div class="card-header bg-dark text-white rounded-0 text-uppercase fw-bold py-3">
                            Thông tin giao hàng
                        </div>
                        <div class="card-body p-4">
                            
                            <div class="mb-4 bg-light border border-dark p-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="fw-bold small text-uppercase mb-0">Chọn sổ địa chỉ <span class="text-danger">*</span></label>
                                    
                                    <button type="button" class="btn btn-sm btn-dark rounded-0 fw-bold" data-bs-toggle="modal" data-bs-target="#modalAddAddress">
                                        <i class="fas fa-plus"></i> Thêm địa chỉ mới
                                    </button>
                                </div>
                                
                                <select name="address_id" class="form-select rounded-0 border-dark shadow-none" required>
                                    <option value="">-- Bấm để chọn địa chỉ giao hàng --</option>
                                    @if(isset($addresses) && count($addresses) > 0)
                                        @foreach($addresses as $addr)
                                            <option value="{{ $addr['id'] }}" {{ $addr['is_default'] ? 'selected' : '' }}>
                                                {{ $addr['ten_nguoi_nhan'] }} - {{ $addr['sdt'] }} | {{ $addr['dia_chi'] }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                
                                @if(empty($addresses))
                                    <small class="text-danger mt-2 d-block fw-bold"><i class="fas fa-exclamation-triangle"></i> Bạn chưa có địa chỉ nào. Vui lòng bấm "Thêm địa chỉ mới" để tiếp tục!</small>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold small text-uppercase">Ghi chú cho đơn vị vận chuyển</label>
                                <textarea name="note" class="form-control rounded-0 border-dark shadow-none" rows="3" placeholder="Ví dụ: Giao hàng vào giờ hành chính, gọi trước khi giao..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card border-dark rounded-0 shadow-sm">
                        <div class="card-header bg-white border-bottom border-dark rounded-0 text-uppercase fw-bold py-3">
                            Đơn hàng của bạn
                        </div>
                        <div class="card-body p-4 bg-white">
                            <ul class="list-group list-group-flush mb-3">
                                @foreach($cart as $item)
                                <li class="list-group-item d-flex justify-content-between lh-sm px-0">
                                    <div>
                                        <h6 class="my-0 fw-bold">{{ $item['name'] }}</h6>
                                        <small class="text-muted">Size: {{ $item['size'] }} | Màu: {{ $item['color'] }} x {{ $item['quantity'] }}</small>
                                    </div>
                                    <span class="text-dark fw-bold">{{ number_format($item['price'] * $item['quantity']) }}đ</span>
                                </li>
                                @endforeach
                            </ul>

                            <div class="d-flex justify-content-between mb-2 small text-muted text-uppercase">
                                <span>Tạm tính</span>
                                <span>{{ number_format($total) }}đ</span>
                            </div>
                            @if($discount > 0)
                            <div class="d-flex justify-content-between mb-2 small text-success text-uppercase">
                                <span>Giảm giá</span>
                                <span>-{{ number_format($discount) }}đ</span>
                            </div>
                            @endif
                            <div class="d-flex justify-content-between mt-3 pt-3 border-top border-dark">
                                <span class="h5 fw-bold text-uppercase">Tổng tiền</span>
                                <span class="h4 fw-bold text-danger">{{ number_format($final_total) }}đ</span>
                            </div>

                            <div class="mt-4 pt-3 border-top border-dark">
                                <h6 class="fw-bold text-uppercase mb-3">Phương thức thanh toán</h6>
                                
                                <div class="form-check mb-2">
                                    <input class="form-check-input border-dark shadow-none" type="radio" name="payment_method" id="cod" value="cod" checked>
                                    <label class="form-check-label fw-bold" for="cod">
                                        <i class="fas fa-money-bill-wave text-success me-2"></i>Thanh toán khi nhận hàng (COD)
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input border-dark shadow-none" type="radio" name="payment_method" id="vnpay" value="vnpay">
                                    <label class="form-check-label fw-bold" for="vnpay">
                                        <img src="https://vnpay.vn/s1/vnpay/assets/images/logo-icon/logo-primary.svg" height="20" class="me-2"> Thanh toán qua VNPAY
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-dark w-100 rounded-0 py-3 text-uppercase fw-bold fs-5 mt-2" {{ empty($addresses) ? 'disabled' : '' }}>
                                    Hoàn tất đặt hàng
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <div class="modal fade" id="modalAddAddress" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content rounded-0 border-dark">
                <div class="modal-header bg-dark text-white rounded-0">
                    <h5 class="modal-title fw-bold text-uppercase">Thêm Địa Chỉ Mới</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="/profile/addAddress" method="POST">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="fw-bold small text-uppercase">Họ tên người nhận</label>
                            <input type="text" name="ten_nguoi_nhan" class="form-control rounded-0 border-dark" required>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold small text-uppercase">Số điện thoại</label>
                            <input type="text" name="sdt" class="form-control rounded-0 border-dark" required>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold small text-uppercase">Địa chỉ chi tiết (Số nhà, Phường, Quận)</label>
                            <textarea name="dia_chi" class="form-control rounded-0 border-dark" rows="3" required></textarea>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input border-dark" type="checkbox" name="is_default" id="is_default" value="1" checked>
                            <label class="form-check-label fw-bold" for="is_default">Đặt làm địa chỉ mặc định</label>
                        </div>
                    </div>
                    <div class="modal-footer border-top border-dark">
                        <button type="button" class="btn btn-outline-dark rounded-0" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-dark rounded-0 fw-bold px-4">Lưu Địa Chỉ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('layout.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>