<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link tải xuống đã hết hạn - ZPlus</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .expired-container {
            max-width: 600px;
            margin: 100px auto;
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }
        .expired-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .expired-header img {
            max-height: 60px;
            margin-bottom: 20px;
        }
        .expired-header h1 {
            color: #dc3545;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .expired-content {
            margin-bottom: 30px;
        }
        .btn-request {
            background-color: #0066cc;
            border-color: #0066cc;
        }
        .btn-request:hover {
            background-color: #0052a3;
            border-color: #0052a3;
        }
    </style>
</head>
<body>
    <div class="expired-container">
        <div class="expired-header">
            <img src="{{ asset('logo.png') }}" alt="ZPlus Logo">
            <h1>Link tải xuống đã hết hạn</h1>
            <p class="text-muted">Vì lý do bảo mật, các link tải xuống của chúng tôi có thời hạn sử dụng giới hạn.</p>
        </div>
        
        <div class="expired-content">
            <div class="alert alert-warning">
                <strong>Link tải xuống này đã hết hạn hoặc không còn hợp lệ.</strong>
                <p class="mb-0 mt-2">Bạn có thể yêu cầu một link tải mới nếu bạn đã mua sản phẩm này.</p>
            </div>
            
            @if(isset($orderItem))
            <div class="card mt-4 mb-4">
                <div class="card-body">
                    <h5 class="card-title">Thông tin đơn hàng</h5>
                    <p>Đơn hàng: #{{ $orderItem->order->order_number ?? 'N/A' }}</p>
                    <p>Sản phẩm: {{ $orderItem->product->name ?? 'N/A' }}</p>
                </div>
            </div>
            @endif
            
            <h4 class="mt-4">Cần link tải xuống mới?</h4>
            <p>Nếu bạn đã mua sản phẩm này và cần một link tải xuống mới, vui lòng cung cấp mã đơn hàng của bạn:</p>
            
            <form action="{{ route('download.request-new') }}" method="POST" class="mt-4">
                @csrf
                
                @if(isset($orderItem) && $orderItem->order)
                <input type="hidden" name="order_id" value="{{ $orderItem->order->id }}">
                <button type="submit" class="btn btn-primary btn-request">Gửi Link Tải Mới</button>
                @else
                <div class="mb-3">
                    <label for="order_id" class="form-label">Mã đơn hàng:</label>
                    <input type="text" class="form-control" id="order_id" name="order_id" required 
                           placeholder="Nhập mã đơn hàng của bạn">
                </div>
                <button type="submit" class="btn btn-primary btn-request">Gửi Link Tải Mới</button>
                @endif
            </form>
        </div>
        
        <div class="text-center mt-4 text-muted">
            <p>Nếu bạn gặp vấn đề, vui lòng liên hệ <a href="mailto:support@zplus.vn">support@zplus.vn</a></p>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>