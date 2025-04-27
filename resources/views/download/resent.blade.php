<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đã gửi lại link tải xuống - ZPlus</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .resent-container {
            max-width: 600px;
            margin: 100px auto;
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }
        .resent-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .resent-header img {
            max-height: 60px;
            margin-bottom: 20px;
        }
        .resent-header h1 {
            color: #28a745;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .resent-content {
            margin-bottom: 30px;
        }
        .order-info {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="resent-container">
        <div class="resent-header">
            <img src="{{ asset('logo.png') }}" alt="ZPlus Logo">
            <h1>Đã gửi lại link tải xuống</h1>
            <p class="text-muted">Link tải xuống mới đã được gửi thành công</p>
        </div>
        
        <div class="resent-content">
            <div class="alert alert-success">
                <strong>Thành công!</strong> Chúng tôi đã gửi link tải xuống mới cho bạn.
            </div>
            
            @isset($order)
            <div class="order-info mt-4">
                <h5>Thông tin đơn hàng:</h5>
                <p><strong>Mã đơn hàng:</strong> #{{ $order->order_number }}</p>
                <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
            @endisset
            
            @isset($email)
            <div class="mt-4">
                <h5>Link tải xuống đã được gửi đến:</h5>
                <p><strong>Email:</strong> {{ $email }}</p>
                <p>Vui lòng kiểm tra cả thư mục spam nếu bạn không nhận được email trong hộp thư đến.</p>
            </div>
            @endisset
            
            <div class="mt-4">
                <h5>Lưu ý quan trọng:</h5>
                <ul>
                    <li>Link tải xuống mới sẽ có hiệu lực trong 24 giờ</li>
                    <li>Link tải xuống chỉ được sử dụng một số lần giới hạn</li>
                    <li>Vui lòng tải xuống và lưu trữ file trong thời gian hiệu lực</li>
                </ul>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="/" class="btn btn-primary">Quay về trang chủ</a>
        </div>
        
        <div class="text-center mt-4 text-muted">
            <p>Nếu bạn gặp vấn đề, vui lòng liên hệ <a href="mailto:support@zplus.vn">support@zplus.vn</a></p>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>