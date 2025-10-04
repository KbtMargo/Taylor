<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">{{ $post->exists ? 'Редагувати пост' : 'Новий пост' }}</h2>
    </x-slot>

    <form method="post" action="{{ $post->exists ? route('atelier.posts.update',$post) : route('atelier.posts.store') }}">
        @csrf
        @if($post->exists) @method('PUT') @endif

        <div class="mb-4">
            <label class="block mb-1">Заголовок</label>
            <input name="title" value="{{ old('title',$post->title) }}" class="input" required>
            @error('title')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1">Slug</label>
            <input name="slug" value="{{ old('slug',$post->slug) }}" class="input">
            @error('slug')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1">Статус</label>
            <select name="status" class="input">
                <option value="">—</option>
                <option value="draft" {{ old('status',$post->status)=='draft'?'selected':'' }}>Чернетка</option>
                <option value="published" {{ old('status',$post->status)=='published'?'selected':'' }}>Опубліковано</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Опубліковано</label>
            <input type="datetime-local" name="published_at"
                   value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\TH:i')) }}"
                   class="input">
        </div>

        <div class="mb-6">
            <label class="block mb-1">Текст</label>
            <textarea name="body" rows="8" class="input" required>{{ old('body',$post->body) }}</textarea>
            @error('body')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>

        <div class="flex gap-3">
            <button class="btn btn-primary">Зберегти</button>
            @if($post->exists)
                <form method="post" action="{{ route('atelier.posts.destroy',$post) }}" onsubmit="return confirm('Видалити?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger">Видалити</button>
                </form>
            @endif
        </div>
    </form>
</x-app-layout>
