@extends('admin.layouts.app')

@section('title', 'License keys của khách hàng')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">License keys</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">Khách hàng</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.customers.show', $customer) }}">{{ $customer->name }}</a></li>
        <li class="breadcrumb-item active">License keys</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-key me-1"></i>
                License keys của {{ $customer->name }}
            </div>
            <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            @if($licenses->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-1"></i>
                    Khách hàng này chưa có license key nào.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>License key</th>
                                <th>Ngày cấp</th>
                                <th>Ngày hết hạn</th>
                                <th>Giới hạn kích hoạt</th>
                                <th>Đã kích hoạt</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($licenses as $license)
                                <tr>
                                    <td>{{ $license->product->name }}</td>
                                    <td>
                                        <span class="badge bg-dark">{{ $license->license_key }}</span>
                                        <button class="btn btn-sm btn-outline-secondary copy-btn" 
                                            data-clipboard-text="{{ $license->license_key }}" 
                                            title="Sao chép">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </td>
                                    <td>{{ $license->assigned_at ? $license->assigned_at->format('d/m/Y') : 'N/A' }}</td>
                                    <td>{{ $license->expires_at ? $license->expires_at->format('d/m/Y') : 'Không giới hạn' }}</td>
                                    <td>{{ $license->activation_limit ?? 'Không giới hạn' }}</td>
                                    <td>{{ $license->activation_count }}</td>
                                    <td>
                                        @if($license->isActive())
                                            <span class="badge bg-success">Đang hoạt động</span>
                                        @else
                                            <span class="badge bg-danger">Hết hạn/Đã vô hiệu hóa</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Phân trang -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $licenses->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var clipboard = new ClipboardJS('.copy-btn');
        
        clipboard.on('success', function(e) {
            e.trigger.innerHTML = '<i class="fas fa-check"></i>';
            setTimeout(function() {
                e.trigger.innerHTML = '<i class="fas fa-copy"></i>';
            }, 2000);
        });
    });
</script>
@endpush
@endsection