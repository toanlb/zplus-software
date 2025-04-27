@extends('admin.layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Chi tiết đơn hàng</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Bảng điều khiển</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Đơn hàng</a></li>
        <li class="breadcrumb-item active">Chi tiết đơn hàng #{{ $order->order_number }}</li>
    </ol>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-7">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-shopping-cart me-1"></i>
                    Thông tin đơn hàng #{{ $order->order_number }}
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Mã đơn hàng:</strong> {{ $order->order_number }}
                        </div>
                        <div class="col-md-6">
                            <strong>Ngày tạo:</strong> {{ $order->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Khách hàng:</strong> 
                            @if($order->user)
                                <a href="#">{{ $order->user->name }}</a>
                            @else
                                {{ $order->name }}
                            @endif
                        </div>
                        <div class="col-md-6">
                            <strong>Email:</strong> {{ $order->email ?? $order->user->email ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Tổng tiền:</strong> {{ number_format($order->total_price, 0, ',', '.') }} VND
                        </div>
                        <div class="col-md-6">
                            <strong>Phương thức thanh toán:</strong> {{ $order->payment_method ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Trạng thái:</strong>
                            <span class="badge {{ $order->status == 'paid' ? 'bg-success' : ($order->status == 'pending' ? 'bg-warning' : ($order->status == 'cancelled' ? 'bg-danger' : 'bg-info')) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <strong>Thanh toán:</strong> 
                            {{ $order->paid_at ? 'Đã thanh toán lúc ' . $order->paid_at->format('d/m/Y H:i') : 'Chưa thanh toán' }}
                        </div>
                    </div>

                    @if($order->notes)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <strong>Ghi chú:</strong>
                            <p>{{ $order->notes }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-box me-1"></i>
                    Danh sách sản phẩm
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                    <th>Tải xuống</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        @if($item->product)
                                            <a href="{{ route('admin.products.edit', $item->product) }}">{{ $item->product->name }}</a>
                                        @else
                                            Sản phẩm đã bị xóa
                                        @endif
                                    </td>
                                    <td>{{ number_format($item->price, 0, ',', '.') }} VND</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VND</td>
                                    <td>
                                        @if($order->isPaid() && $item->product && $item->product->download_link)
                                            <div class="d-flex">
                                                <a href="{{ asset('storage/' . $item->product->download_link) }}" class="btn btn-sm btn-success me-2" target="_blank">
                                                    <i class="fas fa-download"></i> Tải
                                                </a>
                                                <form action="{{ route('admin.orders.resendLink', $item) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-envelope"></i> Gửi lại link
                                                    </button>
                                                </form>
                                            </div>
                                            @if($item->license_key)
                                            <div class="mt-2">
                                                <small class="text-muted">License key: {{ $item->license_key }}</small>
                                            </div>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">Chưa khả dụng</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Tổng cộng:</th>
                                    <th>{{ number_format($order->total_price, 0, ',', '.') }} VND</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-edit me-1"></i>
                    Cập nhật trạng thái
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select name="status" id="status" class="form-select">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Đang chờ xử lý</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn tất</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                <option value="refunded" {{ $order->status == 'refunded' ? 'selected' : '' }}>Đã hoàn tiền</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Cập nhật trạng thái</button>
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-history me-1"></i>
                    Lịch sử đơn hàng
                </div>
                <div class="card-body">
                    <ul class="timeline">
                        <li class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h3 class="timeline-title">Đơn hàng được tạo</h3>
                                <p>{{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </li>
                        @if($order->paid_at)
                        <li class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h3 class="timeline-title">Đã thanh toán</h3>
                                <p>{{ $order->paid_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </li>
                        @endif
                        @if($order->status == 'completed')
                        <li class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h3 class="timeline-title">Hoàn tất</h3>
                                <p>{{ $order->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </li>
                        @elseif($order->status == 'cancelled')
                        <li class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h3 class="timeline-title">Đã hủy</h3>
                                <p>{{ $order->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </li>
                        @elseif($order->status == 'refunded')
                        <li class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h3 class="timeline-title">Đã hoàn tiền</h3>
                                <p>{{ $order->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            @if($order->billing_address)
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-map-marker-alt me-1"></i>
                    Địa chỉ thanh toán
                </div>
                <div class="card-body">
                    <address>
                        {{ $order->billing_address }}
                    </address>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.timeline {
    list-style-type: none;
    margin: 0;
    padding: 0;
    position: relative;
}

.timeline:before {
    background-color: #ddd;
    bottom: 0;
    content: '';
    left: 16px;
    position: absolute;
    top: 0;
    width: 2px;
    z-index: 1;
}

.timeline-item {
    display: flex;
    margin-bottom: 20px;
    position: relative;
}

.timeline-marker {
    background-color: #0d6efd;
    border-radius: 50%;
    height: 12px;
    left: 11px;
    position: absolute;
    top: 6px;
    width: 12px;
    z-index: 2;
}

.timeline-content {
    margin-left: 40px;
}

.timeline-title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 5px;
}
</style>
@endsection