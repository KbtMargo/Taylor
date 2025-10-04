<x-app-layout>
    <h1 class="text-2xl font-semibold mb-2">{{ $post->title }}</h1>
    <div class="text-gray-500 mb-6">{{ $post->published_at?->format('d.m.Y H:i') ?? 'Чернетка' }}</div>
    <article class="prose max-w-none">{!! nl2br(e($post->body)) !!}</article>
</x-app-layout>
