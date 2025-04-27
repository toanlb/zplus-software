@extends('admin.layouts.app')

@section('title', 'Chi tiết khách hàng')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Chi tiết khách hàng</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">Khách hàng</a></li>
        <li class="breadcrumb-item active">{{ $customer->name }}</li>
    </ol>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="row">
        <div class="col-xl-4">
            <!-- Thông tin khách hàng -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user me-1"></i>
                    Thông tin khách hàng
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if($customer->avatar)
                            <img src="{{ asset('storage/' . $customer->avatar) }}" class="rounded-circle mb-3" width="100">
                        @else
                            <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mb-3 mx-auto" style="width: 100px; height: 100px; font-size: 40px;">
                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                            </div>
                        @endif
                        <h5>{{ $customer->name }}</h5>
                        <p class="text-muted">
                            {{ $customer->email }}
                            @if($customer->is_active)
                                <span class="badge bg-success">Đang hoạt động</span>
                            @else
                                <span class="badge bg-danger">Đã vô hiệu hóa</span>
                            @endif
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted small">THÔNG TIN LIÊN HỆ</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>Email</span>
                                <span class="text-muted">{{ $customer->email }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>Số điện thoại</span>
                                <span class="text-muted">{{ $customer->phone ?? 'Chưa cập nhật' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>Địa chỉ</span>
                                <span class="text-muted">{{ $customer->address ?? 'Chưa cập nhật' }}</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted small">THỐNG KÊ</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>Ngày đăng ký</span>
                                <span class="text-muted">{{ $customer->created_at->format('d/m/Y') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>Đăng nhập cuối</span>
                                <span class="text-muted">{{ $customer->last_login_at ? $customer->last_login_at->format('d/m/Y H:i') : 'Chưa đăng nhập' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>Đơn hàng</span>
                                <span class="text-muted">{{ $customer->orders->count() }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>Tổng chi tiêu</span>
                                <span class="text-muted">{{ number_format($totalSpent, 0, ',', '.') }}đ</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div>
                        <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-edit"></i> Chỉnh sửa
                        </a>
                        <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" 
                            onsubmit="return confirm('Bạn có chắc muốn vô hiệu hóa khách hàng này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-ban"></i> Vô hiệu hóa tài khoản
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-8">
            <!-- Đơn hàng gần đây -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-shopping-cart me-1"></i>
                        Đơn hàng gần đây
                    </div>
                    <div>
                        <span class="badge bg-info">Tổng: {{ $customer->orders->count() }} đơn hàng</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($customer->orders->isEmpty())
                        <p class="text-center text-muted">Khách hàng chưa có đơn hàng nào</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Ngày đặt</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customer->orders->take(5) as $order)
                                        <tr>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ number_format($order->total_price, 0, ',', '.') }}đ</td>
                                            <td>
                                                @switch($order->status)
                                                    @case('pending')
                                                        <span class="badge bg-warning">Chờ xử lý</span>
                                                        @break
                                                    @case('processing')
                                                        <span class="badge bg-info">Đang xử lý</span>
                                                        @break
                                                    @case('paid')
                                                        <span class="badge bg-success">Đã thanh toán</span>
                                                        @break
                                                    @case('completed')
                                                        <span class="badge bg-primary">Hoàn thành</span>
                                                        @break
                                                    @case('cancelled')
                                                        <span class="badge bg-danger">Đã hủy</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ $order->status }}</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> Chi tiết
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($customer->orders->count() > 5)
                            <div class="text-center mt-3">
                                <p class="text-muted">Hiển thị 5/{{ $customer->orders->count() }} đơn hàng</p>
                                <a href="{{ route('admin.orders.index', ['user_id' => $customer->id]) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-list"></i> Xem tất cả đơn hàng
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            
            <!-- Downloads gần đây -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-download me-1"></i>
                        Lịch sử tải xuống gần đây
                    </div>
                    <a href="{{ route('admin.customers.downloads', $customer) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-list"></i> Xem tất cả
                    </a>
                </div>
                <div class="card-body">
                    @if($recentDownloads->isEmpty())
                        <p class="text-center text-muted">Khách hàng chưa có lượt tải nào</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Số lần tải</th>
                                        <th>Lần tải gần nhất</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentDownloads as $download)
                                        <tr>
                                            <td>{{ $download->product_name }}</td>
                                            <td>{{ $download->download_count }}</td>
                                            <td>{{ \Carbon\Carbon::parse($download->downloaded_at)->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Licenses -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-key me-1"></i>
                        License keys
                    </div>
                    <a href="{{ route('admin.customers.licenses', $customer) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-list"></i> Xem tất cả
                    </a>
                </div>
                <div class="card-body">
                    @if($customer->licenses->isEmpty())
                        <p class="text-center text-muted">Khách hàng chưa có license key nào</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>License key</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày cấp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customer->licenses->take(5) as $license)
                                        <tr>
                                            <td>{{ $license->product->name }}</td>
                                            <td>
                                                <span class="badge bg-dark">{{ $license->license_key }}</span>
                                            </td>
                                            <td>
                                                @if($license->isActive())
                                                    <span class="badge bg-success">Đang hoạt động</span>
                                                @else
                                                    <span class="badge bg-danger">Hết hạn</span>
                                                @endif
                                            </td>
                                            <td>{{ $license->assigned_at ? $license->assigned_at->format('d/m/Y') : 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($customer->licenses->count() > 5)
                            <div class="text-center mt-3">
                                <p class="text-muted">Hiển thị 5/{{ $customer->licenses->count() }} license keys</p>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection