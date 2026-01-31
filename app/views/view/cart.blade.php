<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng Của Bạn</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
        }
        .cart-header {
            background-color: #fff;
            padding: 20px 0;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }
        .table img {
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .btn-update {
            background-color: #000;
            color: #fff;
            border-radius: 0;
            font-weight: 600;
            text-transform: uppercase;
        }
        .btn-update:hover {
            background-color: #333;
            color: #fff;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    @include('layout.nav')

    <main class="flex-grow-1 py-4">
        <div class="container">
            
            <div class="d-flex align-items-center mb-4">
                <h2 class="fw-bold text-uppercase mb-0"><i class="fas fa-shopping-cart me-2"></i> Giỏ Hàng</h2>
                <span class="badge bg-dark ms-2 rounded-pill">{{ !empty($cart) ? count($cart) : 0 }} sản phẩm</span>
            </div>

            {{-- Thông báo lỗi hoặc thành công --}}
            @if(isset($_SESSION['success']))
                <div class="alert alert-success alert-dismissible fade show shadow-sm">
                    <i class="fas fa-check-circle me-1"></i> {{ $_SESSION['success'] }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <?php unset($_SESSION['success']); ?>
                </div>
            @endif

            @if(isset($_SESSION['error']))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ $_SESSION['error'] }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <?php unset($_SESSION['error']); ?>
                </div>
            @endif

            {{-- Kiểm tra giỏ hàng trống --}}
            @if(empty($cart))
                <div class="text-center py-5 bg-white shadow-sm rounded-3">
                    <img src="https://cdn-icons-png.flaticon.com/512/11329/11329060.png" width="120" class="mb-3 opacity-50">
                    <h4 class="text-muted fw-bold">Giỏ hàng của bạn đang trống!</h4>
                    <p class="text-muted mb-4">Hãy thêm vài món đồ sành điệu vào nhé.</p>
                    <a href="/" class="btn btn-dark rounded-pill px-4 py-2 fw-bold">
                        <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
                    </a>
                </div>
            @else
                
                <div class="row g-4">
                    <div class="col-lg-8">
                        <form action="/cart/update" method="POST">
                            <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="ps-4 py-3">Sản phẩm</th>
                                                <th>Giá</th>
                                                <th style="width: 140px;">Số lượng</th>
                                                <th>Thành tiền</th>
                                                <th class="text-center">Xóa</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cart as $key => $item)
                                            <tr>
                                                <td class="ps-4 py-3">
                                                    <div class="d-flex align-items-center">
                                                        <a href="/products/detail/{{ $item['id'] }}">
                                                            <img src="/uploads/{{ $item['img'] }}" width="70" height="70" style="object-fit: cover;" class="me-3">
                                                        </a>
                                                        <div>
                                                            <a href="/products/detail/{{ $item['id'] }}" class="text-decoration-none text-dark fw-bold d-block">
                                                                {{ $item['name'] }}
                                                            </a>
                                                            <small class="text-muted">Size: {{ $item['size'] }} | Màu: {{ $item['color'] }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="fw-semibold">{{ number_format($item['price']) }}đ</td>
                                                <td>
                                                    <div class="input-group input-group-sm" style="width: 110px;">
                                                        <input type="number" name="qty[{{ $key }}]" value="{{ $item['quantity'] }}" 
                                                               class="form-control text-center fw-bold" min="1">
                                                    </div>
                                                </td>
                                                <td class="fw-bold text-danger">
                                                    {{ number_format($item['price'] * $item['quantity']) }}đ
                                                </td>
                                                <td class="text-center">
                                                    <a href="/cart/remove/{{ $key }}" class="text-secondary hover-danger" onclick="return confirm('Bạn muốn xóa sản phẩm này?')" title="Xóa">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer bg-white p-3 d-flex justify-content-between">
                                    <a href="/" class="btn btn-outline-secondary rounded-pill">
                                        <i class="fas fa-arrow-left me-2"></i>Mua thêm
                                    </a>
                                    <div>
                                        <a href="/cart/clear" class="btn btn-link text-danger text-decoration-none me-2" onclick="return confirm('Xóa sạch giỏ hàng?')">Xóa hết</a>
                                        <button type="submit" class="btn btn-dark rounded-pill fw-bold px-4">
                                            <i class="fas fa-sync-alt me-2"></i>Cập nhật
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-4">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0 fw-bold">Cộng Giỏ Hàng</h5>
                            </div>
                            <div class="card-body p-4">
                                
                                {{-- 1. Form Mã giảm giá --}}
                                <form action="/cart/applyCoupon" method="POST" class="mb-4">
                                    <label class="form-label fw-bold small text-uppercase text-muted">Mã giảm giá</label>
                                    <div class="input-group">
                                        <input type="text" name="code" class="form-control" placeholder="Nhập mã..." required>
                                        <button class="btn btn-dark" type="submit">Áp dụng</button>
                                    </div>
                                </form>

                                <hr class="my-3 text-muted opacity-25">

                                {{-- 2. Chi tiết tiền --}}
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Tạm tính:</span>
                                    <span class="fw-bold">{{ number_format($total) }}đ</span>
                                </div>

                                {{-- Hiển thị nếu có giảm giá --}}
                                @if(isset($_SESSION['coupon']))
                                    <div class="d-flex justify-content-between mb-2 text-success">
                                        <span>
                                            <i class="fas fa-ticket-alt me-1"></i>Mã {{ $_SESSION['coupon']['ma_code'] }}:
                                            <br>
                                            <a href="/cart/removeCoupon" class="text-danger small text-decoration-underline" style="font-size: 0.8rem;">[Gỡ mã]</a>
                                        </span>
                                        <span class="fw-bold">-{{ number_format($discount) }}đ</span>
                                    </div>
                                @endif

                                <div class="d-flex justify-content-between mt-3 pt-3 border-top">
                                    <span class="h5 fw-bold text-dark">Tổng cộng:</span>
                                    <span class="h4 fw-bold text-danger">{{ number_format($final_total) }}đ</span>
                                </div>
                                
                                <p class="text-muted small mt-1 fst-italic text-end">(Đã bao gồm VAT)</p>

                                {{-- 3. Nút Thanh Toán --}}
                                <a href="/checkout" class="btn btn-primary w-100 py-3 rounded-pill fw-bold text-uppercase mt-2 shadow-sm">
                                    Tiến Hành Thanh Toán <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>

    @include('layout.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>