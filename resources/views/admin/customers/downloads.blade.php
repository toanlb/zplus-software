@extends('admin.layouts.app')

@section('title', 'Lịch sử tải xuống của khách hàng')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Lịch sử tải xuống</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">Khách hàng</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.customers.show', $customer) }}">{{ $customer->name }}</a></li>
        <li class="breadcrumb-item active">Lịch sử tải xuống</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-download me-1"></i>
                Lịch sử tải xuống của {{ $customer->name }}
            </div>
            <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            @if($downloads->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-1"></i>
                    Khách hàng này chưa có lượt tải nào.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Sản phẩm</th>
                                <th>Lần tải đầu</th>
                                <th>Lần tải gần nhất</th>
                                <th>Số lượt tải</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($downloads as $download)
                                <tr>
                                    <td>{{ $download->order_number }}</td>
                                    <td>{{ $download->product_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($download->created_at)->format('d/m/Y H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($download->downloaded_at)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $download->download_count }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <form action="{{ route('admin.orders.resendLink', $download->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary" 
                                                    onclick="return confirm('Bạn có chắc muốn gửi lại link tải?')">
                                                    <i class="fas fa-paper-plane"></i> Gửi lại link
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Phân trang -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $downloads->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection