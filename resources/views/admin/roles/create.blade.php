@extends('layouts.admin')

@section('title', 'Thêm Vai trò')
@section('page-title', 'Thêm Vai trò')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Thông tin vai trò</h2>
            <p class="text-sm text-gray-500 mt-1">Điền thông tin và chọn quyền cho vai trò mới</p>
        </div>

        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Basic Info -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Tên vai trò <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               required
                               class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Mô tả
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Is Active -->
                    <div>
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="is_active" class="ml-2 text-sm text-gray-700">
                                Kích hoạt vai trò này
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Permissions -->
                <div class="lg:col-span-2">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-sm font-semibold text-gray-900 mb-4">Chọn quyền</h3>
                        
                        @if($permissions->isEmpty())
                            <div class="text-center py-8">
                                <p class="text-sm text-gray-500">Chưa có quyền nào trong hệ thống.</p>
                                <a href="{{ route('admin.permissions.create') }}" class="mt-2 text-sm text-blue-600 hover:text-blue-700">
                                    Tạo quyền mới
                                </a>
                            </div>
                        @else
                            <div class="space-y-6 max-h-96 overflow-y-auto">
                                @foreach($permissions as $group => $groupPermissions)
                                <div>
                                    <h4 class="text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">
                                        {{ $group ?: 'Khác' }}
                                    </h4>
                                    <div class="space-y-2">
                                        @foreach($groupPermissions as $permission)
                                        <label class="flex items-start p-3 bg-white rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 cursor-pointer transition-colors">
                                            <input type="checkbox" 
                                                   name="permissions[]" 
                                                   value="{{ $permission->id }}"
                                                   {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}
                                                   class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <div class="ml-3 flex-1">
                                                <div class="text-sm font-medium text-gray-900">{{ $permission->name }}</div>
                                                @if($permission->description)
                                                <div class="text-xs text-gray-500 mt-1">{{ $permission->description }}</div>
                                                @endif
                                                <code class="text-xs text-gray-400 mt-1 block">{{ $permission->slug }}</code>
                                            </div>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-3 pt-6 mt-6 border-t border-gray-200">
                <a href="{{ route('admin.roles.index') }}" 
                   class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                    Hủy
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Tạo vai trò
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

