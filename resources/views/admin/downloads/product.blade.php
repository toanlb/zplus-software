@extends('admin.layouts.app')

@section('title', 'Thống kê tải xuống sản phẩm')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Thống kê tải xuống: {{ $product->name }}</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.downloads.index') }}">Tải xuống</a></li>
        <li class="breadcrumb-item active">{{ $product->name }}</li>
    </ol>
    
    <div class="row mb-4">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Thông tin sản phẩm
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            @if($product->thumbnail)
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" 
                                    alt="{{ $product->name }}" class="img-fluid rounded mb-3" style="max-height: 150px;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" style="height: 150px; width: 100%;">
                                    <i class="fas fa-box fa-4x text-secondary"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h4>{{ $product->name }}</h4>
                            <p class="text-muted">{{ $product->short_description }}</p>
                            
                            <div class="mb-2">
                                <span class="badge bg-primary">{{ $product->category->name }}</span>
                                @if($product->license_required)
                                    <span class="badge bg-info">Yêu cầu license</span>
                                @endif
                                @if($product->is_active)
                                    <span class="badge bg-success">Đang hoạt động</span>
                                @else
                                    <span class="badge bg-danger">Không hoạt động</span>
                                @endif
                            </div>
                            
                            <div class="d-flex justify-content-between mt-3">
                                <div>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Chi tiết
                                    </a>
                                </div>
                                <a href="{{ route('admin.products.download', $product) }}" class="btn btn-sm btn-success" target="_blank">
                                    <i class="fas fa-download"></i> Tải file
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-chart-line me-1"></i>
                    Thống kê tải xuống
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h3 class="display-5">{{ $stats['total_downloads'] }}</h3>
                            <p class="text-muted">Tổng lượt tải</p>
                        </div>
                        <div class="col-md-4">
                            <h3 class="display-5">{{ $stats['unique_users'] }}</h3>
                            <p class="text-muted">Người dùng</p>
                        </div>
                        <div class="col-md-4">
                            @php
                                $avgDownloads = $stats['unique_users'] > 0 ? 
                                    round($stats['total_downloads'] / $stats['unique_users'], 1) : 0;
                            @endphp
                            <h3 class="display-5">{{ $avgDownloads }}</h3>
                            <p class="text-muted">TB lượt tải/người</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-history me-1"></i>
            Lịch sử tải xuống
        </div>
        <div class="card-body">
            @if($downloads->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-1"></i>
                    Sản phẩm này chưa có lượt tải nào.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>Email</th>
                                <th>Ngày tải</th>
                                <th>Số lần tải</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($downloads as $download)
                                <tr>
                                    <td>{{ $download->order_number }}</td>
                                    <td>
                                        <a href="{{ route('admin.customers.show', $download->user_id) }}">
                                            {{ $download->user_name }}
                                        </a>
                                    </td>
                                    <td>{{ $download->user_email }}</td>
                                    <td>{{ \Carbon\Carbon::parse($download->downloaded_at)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $download->download_count }}</td>
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
    
    <div class="text-end mb-4">
        <a href="{{ route('admin.downloads.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
        </a>
    </div>
</div>
@endsection