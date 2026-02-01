@extends('admin.layout')

@section('title', 'User Management')

@section('content')
    <div class="px-6 py-6 font-dm-sans min-h-screen">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-700">
                    Users</h1>
                <p class="text-sm text-slate-500 mt-1">Manage system access and roles</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
                class="inline-flex items-center px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium rounded-lg transition-colors shadow-sm gap-2">
                <i class="fa-solid fa-plus"></i>
                <span>Add User</span>
            </a>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Users</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ \App\Models\User::count() }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Admins</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">
                        {{ \App\Models\User::where('role', 'admin')->count() }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center text-purple-600">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Active Today</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">
                        {{ \App\Models\User::whereDate('last_login_at', today())->count() }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                    <i class="fa-solid fa-clock"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <!-- Filters -->
            <div
                class="p-4 border-b border-slate-100 flex flex-col sm:flex-row gap-4 justify-between items-center bg-slate-50/50">
                <form action="{{ route('admin.users.index') }}" method="GET"
                    class="flex items-center gap-3 w-full sm:w-auto">
                    <div class="relative group w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i
                                class="fa-solid fa-search text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="pl-10 pr-4 py-2 w-full text-sm border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all bg-white"
                            placeholder="Search users...">
                    </div>
                    <select name="role"
                        class="text-sm border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white"
                        onchange="this.form.submit()">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold">User</th>
                            <th class="px-6 py-4 font-semibold">Role</th>
                            <th class="px-6 py-4 font-semibold">Credits</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 font-semibold">Joined</th>
                            <th class="px-6 py-4 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($users as $user)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs uppercase overflow-hidden ring-2 ring-white shadow-sm">
                                            @if ($user->avatar)
                                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                {{ substr($user->name, 0, 2) }}
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-medium text-slate-900">{{ $user->name }}</div>
                                            <div class="text-xs text-slate-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700 border border-purple-200' : 'bg-slate-100 text-slate-700 border border-slate-200' }}">
                                        @if ($user->role === 'admin')
                                            <i class="fa-solid fa-shield-halved mr-1.5 text-[10px]"></i>
                                        @else
                                            <i class="fa-regular fa-user mr-1.5 text-[10px]"></i>
                                        @endif
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1 font-medium text-slate-700">
                                        <i class="fa-solid fa-coins text-amber-500"></i>
                                        {{ number_format($user->credits) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('admin.users.toggle', $user) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 {{ $user->is_active ? 'bg-green-500' : 'bg-slate-200' }}"
                                            role="switch" aria-checked="{{ $user->is_active }}">
                                            <span class="sr-only">Toggle status</span>
                                            <span aria-hidden="true"
                                                class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $user->is_active ? 'translate-x-4' : 'translate-x-0' }}"></span>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-slate-500">
                                    {{ $user->created_at->format('M d, Y') }}
                                    <div class="text-xs text-slate-400">
                                        {{ $user->last_login_at ? 'Last seen ' . $user->last_login_at->diffForHumans() : 'Never logged in' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2 text-slate-500">
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                            class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all"
                                            title="Edit user">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        {{-- Add Delete Logic Later if needed, keeping it safe for now --}}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                    <div
                                        class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                                        <i class="fa-solid fa-users-slash text-2xl"></i>
                                    </div>
                                    <p class="font-medium text-slate-900">No users found</p>
                                    <p class="text-sm mt-1">Try adjusting your search or filters</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
