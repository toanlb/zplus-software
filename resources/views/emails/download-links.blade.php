<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link Tải Xuống Sản Phẩm</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
        }
        .header img {
            max-height: 60px;
            margin-bottom: 10px;
        }
        .header h1 {
            color: #333;
            font-size: 24px;
            margin: 0;
        }
        .content {
            padding: 20px 0;
        }
        .order-info {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .order-info p {
            margin: 5px 0;
        }
        .download-section {
            margin-top: 25px;
        }
        .download-item {
            background-color: #f0f7ff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #0066cc;
        }
        .download-btn {
            display: inline-block;
            background-color: #0066cc;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 10px;
        }
        .download-btn:hover {
            background-color: #0052a3;
        }
        .expiry {
            color: #e74c3c;
            font-size: 0.9em;
            margin-top: 8px;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #777;
            font-size: 0.9em;
        }
        .note {
            background-color: #fff8e1;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #ffc107;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('logo.png') }}" alt="ZPlus Logo">
            <h1>{{ $isResend ? 'Link Tải Xuống Mới' : 'Link Tải Xuống Sản Phẩm' }}</h1>
        </div>
        
        <div class="content">
            <p>Xin chào {{ $order->user->name ?? 'Quý khách' }},</p>
            
            @if($isResend)
                <p>Theo yêu cầu của bạn, chúng tôi đã tạo lại link tải xuống sản phẩm cho đơn hàng <strong>#{{ $order->order_number }}</strong>.</p>
            @else
                <p>Cảm ơn bạn đã mua sản phẩm từ chúng tôi. Đơn hàng <strong>#{{ $order->order_number }}</strong> của bạn đã được xử lý thành công.</p>
            @endif
            
            <div class="order-info">
                <p><strong>Đơn hàng:</strong> #{{ $order->order_number }}</p>
                <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Tổng thanh toán:</strong> {{ number_format($order->total_price, 0, ',', '.') }}đ</p>
            </div>
            
            <div class="download-section">
                <h2>Link Tải Xuống:</h2>
                
                @foreach($downloadLinks as $link)
                    <div class="download-item">
                        <h3>{{ $link['product'] }}</h3>
                        <a href="{{ $link['url'] }}" class="download-btn">Tải Xuống Ngay</a>
                        <p class="expiry">Link hết hạn vào: {{ $link['expires_at']->format('d/m/Y H:i') }}</p>
                    </div>
                @endforeach
                
                <div class="note">
                    <strong>Lưu ý:</strong>
                    <ul>
                        <li>Link tải xuống có thời hạn sử dụng giới hạn vì lý do bảo mật.</li>
                        <li>Nếu link hết hạn, bạn có thể yêu cầu gửi lại trên trang tải xuống.</li>
                        <li>Chỉ sử dụng link tải xuống trên thiết bị của bạn và không chia sẻ cho người khác.</li>
                    </ul>
                </div>
            </div>
            
            <p>Nếu bạn gặp bất kỳ vấn đề nào khi tải xuống hoặc cài đặt sản phẩm, vui lòng liên hệ với đội ngũ hỗ trợ của chúng tôi qua email <a href="mailto:support@zplus.vn">support@zplus.vn</a> hoặc gọi số 1900-xxxx.</p>
            
            <p>Trân trọng,<br>Đội ngũ ZPlus</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} ZPlus. Tất cả các quyền được bảo lưu.</p>
            <p>Địa chỉ: 123 Đường ABC, Quận XYZ, Thành phố HCM</p>
        </div>
    </div>
</body>
</html>