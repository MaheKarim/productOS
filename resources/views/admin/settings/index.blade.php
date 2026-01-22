@extends('admin.layout')

@section('title', 'Account Settings')

@section('content')
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Account Settings</h1>
                <p class="mt-2 text-lg text-gray-500">Manage your profile information and security.</p>
            </div>
            <a href="{{ url()->previous() }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-lg text-slate-600 hover:text-indigo-600 hover:border-indigo-200 transition-all shadow-sm font-medium">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                Back
            </a>
        </div>

        @if (session('success'))
            <div class="mb-8 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 flex items-center gap-3">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-8 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700">
                <div class="flex items-center gap-3 mb-2 font-medium">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    There were some problems with your input.
                </div>
                <ul class="list-disc list-inside ml-8 space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-10">
            <!-- Profile Information -->
            <div class="bg-white rounded-2xl shadow-premium border border-slate-100 overflow-hidden">
                <div class="p-8 border-b border-slate-100">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <i class="fa-regular fa-user"></i>
                        </div>
                        Profile Information
                    </h2>
                    <p class="mt-1 text-gray-500 ml-14">Update your account's profile information and email address.</p>
                </div>

                <div class="p-8 bg-gray-50/30">
                    <form action="{{ route('admin.settings.update-profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <!-- Profile Photo -->
                            <div class="md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-4">Profile Photo</label>
                                <div class="flex flex-col items-center gap-4">
                                    <div class="relative group">
                                        <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-md bg-slate-100">
                                            @if ($user->avatar)
                                                <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate-300 text-4xl bg-slate-100">
                                                    <i class="fa-solid fa-user"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <input type="file" name="avatar" id="avatar"
                                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-soft cursor-pointer">
                                        <p class="mt-2 text-xs text-gray-500 text-center">JPG, PNG or GIF (Max 1MB)</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Fields -->
                            <div class="md:col-span-2 space-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                    <input type="text" name="name" id="name"
                                        value="{{ old('name', $user->name) }}"
                                        class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-soft"
                                        required>
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email', $user->email) }}"
                                        class="w-full px-4 py-3 bg-slate-100 text-slate-500 border border-slate-200 rounded-xl cursor-not-allowed focus:ring-0 focus:border-slate-200 transition-soft"
                                        readonly>
                                    <p class="mt-1 text-xs text-slate-400">Email address cannot be changed.</p>
                                </div>

                                <div class="pt-4 flex justify-end">
                                    <button type="submit"
                                        class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-500/20 transition-all transform hover:-translate-y-0.5">
                                        Save Profile
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Update Password -->
            <div class="bg-white rounded-2xl shadow-premium border border-slate-100 overflow-hidden">
                <div class="p-8 border-b border-slate-100">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        Update Password
                    </h2>
                    <p class="mt-1 text-gray-500 ml-14">Ensure your account is using a long, random password to stay secure.</p>
                </div>

                <div class="p-8 bg-gray-50/30">
                    <form action="{{ route('admin.settings.update-password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="max-w-2xl space-y-6 ml-14">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                <input type="password" name="current_password" id="current_password"
                                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-soft"
                                    required>
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                <input type="password" name="password" id="password"
                                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-soft"
                                    required>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-soft"
                                    required>
                            </div>

                            <div class="pt-4 flex justify-end">
                                <button type="submit"
                                    class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-500/20 transition-all transform hover:-translate-y-0.5">
                                    Update Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
