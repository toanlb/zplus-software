@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa Sản phẩm')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Chỉnh sửa Sản phẩm: {{ $product->name }}</h1>
        <div>
            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-info shadow-sm mr-2">
                <i class="fas fa-eye fa-sm text-white-50"></i> Xem chi tiết
            </a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thông tin sản phẩm</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category_id">Danh mục <span class="text-danger">*</span></label>
                            <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="short_description">Mô tả ngắn <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description" name="short_description" rows="3" required>{{ old('short_description', $product->short_description) }}</textarea>
                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">Giá <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" min="0" step="0.01" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">VNĐ</span>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sale_price">Giá khuyến mãi</label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('sale_price') is-invalid @enderror" id="sale_price" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" min="0" step="0.01">
                                <div class="input-group-append">
                                    <span class="input-group-text">VNĐ</span>
                                </div>
                                @error('sale_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">Để trống nếu không có giá khuyến mãi</small>
                        </div>

                        <div class="form-group">
                            <label for="version">Phiên bản <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('version') is-invalid @enderror" id="version" name="version" value="{{ old('version', $product->version) }}" required>
                            @error('version')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Mô tả chi tiết <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="6" required>{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="thumbnail">Hình ảnh đại diện</label>
                            @if($product->thumbnail)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($product->thumbnail) }}" alt="{{ $product->name }}" class="img-thumbnail" style="max-height: 150px;">
                                    <br>
                                    <small class="text-muted">Ảnh hiện tại</small>
                                </div>
                            @endif
                            <input type="file" class="form-control-file @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail">
                            <small class="form-text text-muted">Định dạng: JPG, PNG, GIF. Kích thước tối đa: 2MB.</small>
                            <small class="form-text text-muted">Để trống nếu không muốn thay đổi ảnh.</small>
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="download_file">File phần mềm</label>
                            @if($product->download_link)
                                <div class="mb-2">
                                    <span class="text-success">
                                        <i class="fas fa-check-circle"></i> Đã có file tải lên
                                    </span>
                                    <br>
                                    <a href="{{ route('admin.products.download', $product) }}" class="btn btn-sm btn-success mt-1">
                                        <i class="fas fa-download"></i> Tải xuống
                                    </a>
                                </div>
                            @else
                                <div class="mb-2">
                                    <span class="text-danger">
                                        <i class="fas fa-times-circle"></i> Chưa có file tải lên
                                    </span>
                                </div>
                            @endif
                            <input type="file" class="form-control-file @error('download_file') is-invalid @enderror" id="download_file" name="download_file">
                            <small class="form-text text-muted">Kích thước tối đa: 100MB.</small>
                            <small class="form-text text-muted">Để trống nếu không muốn thay đổi file.</small>
                            @error('download_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="license_required" name="license_required" value="1" {{ old('license_required', $product->license_required) ? 'checked' : '' }}>
                            <label class="form-check-label" for="license_required">Yêu cầu license key</label>
                            <small class="form-text text-muted d-block">Chọn nếu sản phẩm yêu cầu kích hoạt bằng license key</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Sản phẩm đang được bán</label>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="fas fa-save mr-2"></i> Cập nhật sản phẩm
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Kích hoạt trình soạn thảo rich text cho mô tả chi tiết
    $(document).ready(function() {
        if (typeof(CKEDITOR) !== 'undefined') {
            CKEDITOR.replace('description');
        }
    });
</script>
@endsection