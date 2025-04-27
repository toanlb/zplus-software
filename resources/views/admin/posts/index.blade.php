@extends('admin.layouts.app')

@section('title', 'Quản lý bài viết')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Quản lý bài viết</h1>
            <a href="{{ route('admin.posts.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Thêm bài viết mới
            </a>
        </div>

        <!-- Flash Message -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Filter & Search -->
        <div class="bg-white shadow-sm rounded-lg mb-6 p-4 border border-gray-200">
            <form action="{{ route('admin.posts.index') }}" method="GET" class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                        class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                        placeholder="Tìm theo tiêu đề, nội dung..."
                    >
                </div>
                <div class="sm:w-40">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                    <select name="status" id="status" 
                        class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        <option value="">Tất cả</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Đã xuất bản</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Bản nháp</option>
                    </select>
                </div>
                <div class="sm:w-40">
                    <label for="featured" class="block text-sm font-medium text-gray-700 mb-1">Loại</label>
                    <select name="featured" id="featured" 
                        class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        <option value="">Tất cả</option>
                        <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>Nổi bật</option>
                        <option value="0" {{ request('featured') === '0' ? 'selected' : '' }}>Thường</option>
                    </select>
                </div>
                <div class="sm:w-40 self-end">
                    <button type="submit" class="w-full px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                        Lọc
                    </button>
                </div>
            </form>
        </div>

        <!-- Posts List -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tiêu đề
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Trạng thái
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ngày tạo
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Thao tác
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($posts as $post)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if ($post->featured_image)
                                            <img class="h-10 w-10 object-cover rounded-sm" src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}">
                                        @else
                                            <div class="h-10 w-10 rounded-sm bg-gray-200 flex items-center justify-center text-gray-400">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $post->title }}
                                            @if ($post->is_featured)
                                                <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Nổi bật
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            bởi {{ $post->user->name }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($post->status == 'draft')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Bản nháp
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Đã xuất bản
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $post->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.posts.show', $post) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                    Xem
                                </a>
                                <a href="{{ route('admin.posts.edit', $post) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                    Sửa
                                </a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                Không có bài viết nào. <a href="{{ route('admin.posts.create') }}" class="text-blue-600 hover:text-blue-900">Thêm bài viết mới</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $posts->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection