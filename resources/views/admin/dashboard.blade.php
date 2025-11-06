@extends('layouts.admin')

@section('title', 'Bảng điều khiển')
@section('page-title', 'Bảng điều khiển')

@section('content')
<div>
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Tổng người dùng</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $totalUsers }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 grid grid-cols-3 gap-2 text-xs">
                <div class="px-2 py-1 rounded bg-green-50 text-green-700 text-center">Hoạt động: {{ $activeUsers }}</div>
                <div class="px-2 py-1 rounded bg-gray-50 text-gray-700 text-center">Chưa kích hoạt: {{ $inactiveUsers }}</div>
                <div class="px-2 py-1 rounded bg-red-50 text-red-700 text-center">Khóa: {{ $lockedUsers }}</div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Tổng vai trò</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $totalRoles }}</p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2a3 3 0 00-5.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2a3 3 0 015.356-1.857M12 4a4 4 0 110 8 4 4 0 010-8z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Tổng quyền</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $totalPermissions }}</p>
                </div>
                <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h8m-8 4h6M5 6a2 2 0 012-2h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Tài khoản bị khóa (gần đây)</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $recentLocked->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Users and Locked Accounts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Người dùng mới</h3>
                <a href="{{ route('admin.users.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Quản lý người dùng</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recentUsers as $u)
                <div class="py-3 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold mr-3">
                            {{ strtoupper(substr($u->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900">{{ $u->name }}</div>
                            <div class="text-xs text-gray-500">{{ $u->email }}</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        @foreach($u->roles as $r)
                        <span class="px-2 py-0.5 text-xs rounded bg-gray-100 text-gray-700">{{ $r->name }}</span>
                        @endforeach
                        @if($u->status === 'locked')
                        <span class="px-2 py-0.5 text-xs rounded bg-red-100 text-red-700">Đã khóa</span>
                        @elseif($u->status === 'inactive')
                        <span class="px-2 py-0.5 text-xs rounded bg-gray-100 text-gray-700">Chưa kích hoạt</span>
                        @else
                        <span class="px-2 py-0.5 text-xs rounded bg-green-100 text-green-700">Hoạt động</span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="py-6 text-center text-sm text-gray-500">Chưa có người dùng nào</div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Tài khoản bị khóa gần đây</h3>
                <a href="{{ route('admin.users.index', ['status' => 'locked']) }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Xem danh sách</a>
            </div>
            <div class="space-y-3">
                @forelse($recentLocked as $lu)
                <div class="p-3 bg-red-50 border border-red-100 rounded-lg flex items-center justify-between">
                    <div>
                        <div class="text-sm font-medium text-red-800">{{ $lu->name }}</div>
                        <div class="text-xs text-red-700">{{ $lu->email }}</div>
                    </div>
                    <a href="{{ route('admin.users.edit', $lu) }}" class="text-xs text-red-700 hover:text-red-800 font-medium">Mở khóa</a>
                </div>
                @empty
                <div class="py-6 text-center text-sm text-gray-500">Không có tài khoản bị khóa</div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Quick Links -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('admin.users.create') }}" class="bg-white rounded-lg border border-gray-200 p-6 hover:shadow transition-shadow">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <div>
                    <div class="font-medium text-gray-900">Thêm người dùng</div>
                    <div class="text-sm text-gray-500">Tạo tài khoản mới</div>
                </div>
            </div>
        </a>
        <a href="{{ route('admin.roles.index') }}" class="bg-white rounded-lg border border-gray-200 p-6 hover:shadow transition-shadow">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2a3 3 0 00-5.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2a3 3 0 015.356-1.857M12 4a4 4 0 110 8 4 4 0 010-8z"></path>
                    </svg>
                </div>
                <div>
                    <div class="font-medium text-gray-900">Quản lý vai trò</div>
                    <div class="text-sm text-gray-500">Thiết lập quyền cho vai trò</div>
                </div>
            </div>
        </a>
        <a href="{{ route('admin.permissions.index') }}" class="bg-white rounded-lg border border-gray-200 p-6 hover:shadow transition-shadow">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h8m-8 4h6M5 6a2 2 0 012-2h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6z"></path>
                    </svg>
                </div>
                <div>
                    <div class="font-medium text-gray-900">Quản lý quyền</div>
                    <div class="text-sm text-gray-500">Tạo và cập nhật quyền</div>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection

