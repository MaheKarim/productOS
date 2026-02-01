@extends('admin.layout')

@section('title', isset($user) ? 'Edit User' : 'Create User')

@section('content')
    <div class="px-6 py-6 font-dm-sans min-h-screen">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.users.index') }}"
                    class="w-8 h-8 rounded-lg flex items-center justify-center bg-white border border-slate-200 text-slate-500 hover:text-slate-900 shadow-sm transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">{{ isset($user) ? 'Edit User' : 'Create New User' }}</h1>
                    <p class="text-sm text-slate-500 mt-1">
                        {{ isset($user) ? 'Update user details and permissions' : ' onboard a new user to the system' }}
                    </p>
                </div>
            </div>
        </div>

        <form action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST"
            enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            @csrf
            @if (isset($user))
                @method('PUT')
            @endif

            <!-- Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-6 flex items-center gap-2">
                        <i class="fa-regular fa-id-card text-blue-500"></i>
                        Personal Information
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-slate-700">Full Name <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                    <i class="fa-regular fa-user"></i>
                                </span>
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', $user->name ?? '') }}" required
                                    class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white focus:bg-white transition-all shadow-sm placeholder:text-slate-400">
                            </div>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-slate-700">Email Address
                                <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                    <i class="fa-regular fa-envelope"></i>
                                </span>
                                <input type="email" name="email" id="email"
                                    value="{{ old('email', $user->email ?? '') }}" required
                                    class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white focus:bg-white transition-all shadow-sm placeholder:text-slate-400">
                            </div>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Credits -->
                        <div class="space-y-2">
                            <label for="credits" class="block text-sm font-medium text-slate-700">Credits</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                    <i class="fa-solid fa-coins"></i>
                                </span>
                                <input type="number" name="credits" id="credits"
                                    value="{{ old('credits', $user->credits ?? '') }}"
                                    class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white focus:bg-white transition-all shadow-sm placeholder:text-slate-400">
                            </div>
                            <div class="flex justify-between items-center">
                                <p class="text-xs text-slate-500">Available balance.</p>
                                @if (isset($user))
                                    <a href="{{ route('admin.activity-logs.index', ['user_id' => $user->id]) }}"
                                        class="text-xs text-indigo-600 hover:text-indigo-700 font-medium hover:underline">
                                        View History
                                    </a>
                                @endif
                            </div>
                            @error('credits')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div class="space-y-2">
                            <label for="username" class="block text-sm font-medium text-slate-700">Username</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                    <i class="fa-solid fa-at"></i>
                                </span>
                                <input type="text" name="username" id="username"
                                    value="{{ old('username', $user->username ?? '') }}"
                                    class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white focus:bg-white transition-all shadow-sm placeholder:text-slate-400">
                            </div>
                            @error('username')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-slate-700">
                                Password {{ isset($user) ? '(Leave blank to keep current)' : '*' }}
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <input type="password" name="password" id="password" {{ isset($user) ? '' : 'required' }}
                                    class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white focus:bg-white transition-all shadow-sm placeholder:text-slate-400">
                            </div>
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bio -->
                        <div class="col-span-1 md:col-span-2 space-y-2">
                            <label for="bio" class="block text-sm font-medium text-slate-700">Bio</label>
                            <textarea name="bio" id="bio" rows="4"
                                class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white focus:bg-white transition-all shadow-sm placeholder:text-slate-400 resize-y"
                                placeholder="Tell us a bit about this user...">{{ old('bio', $user->bio ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar: Settings & Meta -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-sliders text-purple-500"></i>
                        Access & Role
                    </h3>

                    <div class="space-y-6">
                        <!-- Role -->
                        <div class="space-y-3">
                            <label class="block text-sm font-medium text-slate-700">Role</label>
                            <div class="flex flex-col gap-2">
                                <label
                                    class="relative flex items-center p-3 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-50 transition-all {{ old('role', $user->role ?? 'user') == 'admin' ? 'ring-2 ring-blue-500 border-transparent bg-blue-50/50' : '' }}">
                                    <input type="radio" name="role" value="admin" class="sr-only peer"
                                        {{ old('role', $user->role ?? 'user') == 'admin' ? 'checked' : '' }}>
                                    <div class="flex items-center gap-3 w-full">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600 shrink-0">
                                            <i class="fa-solid fa-shield-halved"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-slate-900 text-sm">Administrator</div>
                                            <div class="text-xs text-slate-500">Full system access</div>
                                        </div>
                                        <div
                                            class="ml-auto opacity-0 peer-checked:opacity-100 text-blue-600 transition-opacity">
                                            <i class="fa-solid fa-check-circle text-lg"></i>
                                        </div>
                                    </div>
                                </label>

                                <label
                                    class="relative flex items-center p-3 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-50 transition-all {{ old('role', $user->role ?? 'user') == 'user' ? 'ring-2 ring-blue-500 border-transparent bg-blue-50/50' : '' }}">
                                    <input type="radio" name="role" value="user" class="sr-only peer"
                                        {{ old('role', $user->role ?? 'user') == 'user' ? 'checked' : '' }}>
                                    <div class="flex items-center gap-3 w-full">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-600 shrink-0">
                                            <i class="fa-regular fa-user"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-slate-900 text-sm">Regular User</div>
                                            <div class="text-xs text-slate-500">Standard access</div>
                                        </div>
                                        <div
                                            class="ml-auto opacity-0 peer-checked:opacity-100 text-blue-600 transition-opacity">
                                            <i class="fa-solid fa-check-circle text-lg"></i>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="space-y-3 pt-4 border-t border-slate-100">
                            <label class="block text-sm font-medium text-slate-700">Account
                                Status</label>
                            <div
                                class="flex items-center justify-between p-3 rounded-lg bg-slate-50 border border-slate-200">
                                <span class="text-sm font-medium text-slate-700">Active Account</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                                        {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500">
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <button type="submit"
                        class="w-full py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-medium rounded-lg shadow-sm transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-save"></i>
                        {{ isset($user) ? 'Update User' : 'Create User' }}
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                        class="w-full py-2.5 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-medium rounded-lg shadow-sm transition-all flex items-center justify-center">
                        Cancel
                    </a>
                </div>
            </div>
        </form>

        @if (isset($user) && $user->activityLogs->count() > 0)
            <div class="mt-8 bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-slate-400"></i>
                        Recent Activity
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-3 font-semibold">Action</th>
                                <th class="px-6 py-3 font-semibold">Description</th>
                                <th class="px-6 py-3 font-semibold">IP Address</th>
                                <th class="px-6 py-3 font-semibold">Time</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($user->activityLogs()->latest()->take(10)->get() as $log)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-3 font-medium text-slate-900">{{ $log->action }}</td>
                                    <td class="px-6 py-3 text-slate-500">{{ Str::limit($log->description, 50) }}</td>
                                    <td class="px-6 py-3 text-slate-500 font-mono text-xs">{{ $log->ip_address }}</td>
                                    <td class="px-6 py-3 text-slate-400">{{ $log->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
