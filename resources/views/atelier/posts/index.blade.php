<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl">Пости ательє</h2>
            <a href="{{ route('atelier.posts.create') }}" class="btn btn-primary">Додати</a>
        </div>
        <form method="get" class="mt-3">
            <input name="q" value="{{ request('q') }}" placeholder="Пошук..." class="input">
        </form>
    </x-slot>

    @forelse($posts as $post)
        <article class="py-4 border-b">
            <a href="{{ route('atelier.posts.edit',$post) }}" class="font-medium">{{ $post->title }}</a>
            <div class="text-sm text-gray-500">
                {{ $post->published_at?->format('d.m.Y H:i') ?? 'Чернетка' }} · {{ $post->slug }}
            </div>
        </article>
    @empty
        <div class="py-12 text-center text-gray-500">Поки що немає постів</div>
    @endforelse

    <div class="mt-6">{{ $posts->links() }}</div>
</x-app-layout>
