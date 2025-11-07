@extends('layouts.admin')

@section('title', 'Hồ Sơ')
@section('page-title', 'Hồ Sơ Cá Nhân')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Profile Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-6">
            <!-- Avatar -->
            <div class="relative">
                @if(auth()->user()->avatar)
                    <img src="{{ Storage::disk('public')->url(auth()->user()->avatar) }}" 
                         alt="{{ auth()->user()->name }}" 
                         class="w-32 h-32 rounded-full object-cover border-4 border-gray-200">
                @else
                    <div class="w-32 h-32 bg-blue-600 rounded-full flex items-center justify-center border-4 border-gray-200">
                        <span class="text-white font-bold text-4xl">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                    </div>
                @endif
                <form action="{{ route('admin.profile.avatar.remove') }}" method="POST" class="absolute -bottom-2 -right-2" onsubmit="return confirm('Bạn có chắc muốn xóa ảnh đại diện?');">
                    @csrf
                    @method('DELETE')
                    @if(auth()->user()->avatar)
                    <button type="submit" class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-white hover:bg-red-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    @endif
                </form>
            </div>

            <!-- User Info -->
            <div class="flex-1 text-center md:text-left">
                <h2 class="text-2xl font-bold text-gray-900">{{ auth()->user()->name }}</h2>
                <p class="text-gray-600 mt-1">{{ auth()->user()->email }}</p>
                
                <!-- Status Badge -->
                <div class="mt-3 flex flex-wrap items-center justify-center md:justify-start gap-2">
                    @if(auth()->user()->status === 'active')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Hoạt động
                        </span>
                    @elseif(auth()->user()->status === 'locked')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                            Đã khóa
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Chưa kích hoạt
                        </span>
                    @endif

                    @if(auth()->user()->two_factor_enabled)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            2FA Bật
                        </span>
                    @endif
                </div>

                <!-- Roles -->
                @if(auth()->user()->roles->count() > 0)
                <div class="mt-3 flex flex-wrap items-center justify-center md:justify-start gap-2">
                    @foreach(auth()->user()->roles as $role)
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                            {{ $role->name }}
                        </span>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div x-data="{ activeTab: 'info' }" class="space-y-6">
        <!-- Tab Buttons -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex space-x-4 border-b border-gray-200">
                <button @click="activeTab = 'info'" 
                        :class="activeTab === 'info' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-gray-900'"
                        class="px-4 py-2 font-medium text-sm transition-colors">
                    Thông tin cá nhân
                </button>
                <button @click="activeTab = 'password'" 
                        :class="activeTab === 'password' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-gray-900'"
                        class="px-4 py-2 font-medium text-sm transition-colors">
                    Đổi mật khẩu
                </button>
                <button @click="activeTab = 'avatar'" 
                        :class="activeTab === 'avatar' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-gray-900'"
                        class="px-4 py-2 font-medium text-sm transition-colors">
                    Ảnh đại diện
                </button>
            </div>
        </div>

        <!-- Tab Content: Thông tin cá nhân -->
        <div x-show="activeTab === 'info'" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin cá nhân</h3>
            <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Họ và tên <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', auth()->user()->name) }}" 
                               required
                               class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', auth()->user()->email) }}" 
                               required
                               class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Cập nhật thông tin
                    </button>
                </div>
            </form>
        </div>

        <!-- Tab Content: Đổi mật khẩu -->
        <div x-show="activeTab === 'password'" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Đổi mật khẩu</h3>
            <form method="POST" action="{{ route('admin.profile.password') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                        Mật khẩu hiện tại <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           id="current_password" 
                           name="current_password" 
                           required
                           class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('current_password') border-red-500 @enderror">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Mật khẩu mới <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required
                               class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Xác nhận mật khẩu <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required
                               class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" 
                           id="logout_others" 
                           name="logout_others" 
                           value="1"
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="logout_others" class="ml-2 text-sm text-gray-700">
                        Đăng xuất khỏi tất cả thiết bị khác
                    </label>
                </div>

                <div class="pt-4">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Đổi mật khẩu
                    </button>
                </div>
            </form>
        </div>

        <!-- Tab Content: Ảnh đại diện -->
        <div x-show="activeTab === 'avatar'" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ảnh đại diện</h3>
            <form method="POST" action="{{ route('admin.profile.avatar') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label for="avatar" class="block text-sm font-medium text-gray-700 mb-2">
                        Chọn ảnh đại diện
                    </label>
                    <input type="file" 
                           id="avatar" 
                           name="avatar" 
                           accept="image/*"
                           required
                           class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="mt-1 text-xs text-gray-500">Định dạng: JPG, PNG, GIF. Kích thước tối đa: 2MB. Tỷ lệ khuyến nghị: 1:1</p>
                    @error('avatar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Cập nhật ảnh đại diện
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

