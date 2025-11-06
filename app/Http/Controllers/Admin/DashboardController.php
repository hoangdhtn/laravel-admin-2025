<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $lockedUsers = User::where('status', 'locked')->count();
        $inactiveUsers = User::where('status', 'inactive')->count();

        $totalRoles = Role::count();
        $totalPermissions = Permission::count();

        $recentUsers = User::with('roles')
            ->latest('created_at')
            ->take(8)
            ->get();

        $recentLocked = User::where('status', 'locked')
            ->latest('updated_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'lockedUsers',
            'inactiveUsers',
            'totalRoles',
            'totalPermissions',
            'recentUsers',
            'recentLocked'
        ));
    }
}
