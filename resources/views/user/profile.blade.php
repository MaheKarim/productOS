@extends('user.layout')

@section('header', 'My Profile')

@section('content')
    <div class="max-w-4xl mx-auto">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Profile Card -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-6 md:p-8 flex flex-col md:flex-row gap-8">
                    <!-- Avatar Section -->
                    <div class="flex-shrink-0 flex flex-col items-center gap-4">
                        <div
                            class="w-32 h-32 rounded-full bg-slate-100 border-4 border-white shadow-lg overflow-hidden relative group">
                            @if (Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center text-slate-300 text-4xl font-bold bg-slate-50">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                            <div
                                class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                                <i class="fa-solid fa-camera text-white text-xl"></i>
                            </div>
                            <input type="file" name="avatar" class="absolute inset-0 opacity-0 cursor-pointer"
                                accept="image/*">
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-center">{{ Auth::user()->name }}</h3>
                            <p class="text-slate-500 text-sm text-center">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <!-- Fields -->
                    <div class="flex-1 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Full
                                    Name</label>
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', Auth::user()->name) }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all bg-slate-50 focus:bg-white text-slate-900">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email
                                    Address</label>
                                <input type="email" name="email" id="email"
                                    value="{{ old('email', Auth::user()->email) }}" required readonly
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-100 text-slate-500 cursor-not-allowed focus:ring-0 focus:border-slate-200 transition-all">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="bio" class="block text-sm font-semibold text-slate-700 mb-2">Bio / About
                                    Me</label>
                                <textarea name="bio" id="bio" rows="3"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all bg-slate-50 focus:bg-white text-slate-900"
                                    placeholder="Share a little something about yourself...">{{ old('bio', Auth::user()->bio) }}</textarea>
                                @error('bio')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-6 md:px-8 py-4 bg-slate-50 border-t border-slate-100 flex justify-end">
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/30 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-save"></i>
                        Save Changes
                    </button>
                </div>
            </div>
        </form>

        <!-- Security Section -->
        <form action="{{ route('profile.update') }}" method="POST"
            class="mt-8 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            @csrf
            @method('PUT')
            <div class="p-6 md:p-8">
                <h3 class="font-bold text-slate-900 text-lg mb-1">Security Settings</h3>
                <p class="text-slate-500 text-sm mb-6">Update your password to keep your account secure.</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="current_password" class="block text-sm font-semibold text-slate-700 mb-2">Current
                            Password</label>
                        <input type="password" name="current_password" id="current_password"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all bg-slate-50 focus:bg-white">
                        @error('current_password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">New Password</label>
                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all bg-slate-50 focus:bg-white">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Confirm
                            Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all bg-slate-50 focus:bg-white">
                    </div>
                </div>
            </div>
            <div class="px-6 md:px-8 py-4 bg-slate-50 border-t border-slate-100 flex justify-end">
                <button type="submit"
                    class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 hover:text-slate-900 hover:bg-slate-50 font-semibold rounded-xl shadow-sm transition-all flex items-center gap-2">
                    <i class="fa-solid fa-lock"></i>
                    Update Password
                </button>
            </div>
        </form>
    </div>
@endsection
