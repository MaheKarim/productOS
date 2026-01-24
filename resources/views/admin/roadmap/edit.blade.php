@extends('admin.layout')

@section('title', 'Edit Topic')
@section('page-title', 'Edit Topic')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8">
            <form action="{{ route('admin.roadmap.update', $topic) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Topic Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $topic->name) }}" required
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-bold text-slate-700 mb-2">Category</label>
                        <select name="category_id" id="category_id" required
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('category_id', $topic->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $topic->description) }}</textarea>
                    </div>

                    <div>
                        <label for="difficulty_level" class="block text-sm font-bold text-slate-700 mb-2">Difficulty
                            (1-5)</label>
                        <input type="number" name="difficulty_level" id="difficulty_level"
                            value="{{ old('difficulty_level', $topic->difficulty_level) }}" min="1" max="5"
                            required
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('admin.roadmap.index') }}"
                        class="px-6 py-3 bg-slate-100 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-200 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-3 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/20">
                        Update Topic
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
