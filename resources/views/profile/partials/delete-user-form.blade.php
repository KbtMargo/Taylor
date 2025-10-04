<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Видалити Обліковий Запис') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Після видалення вашого облікового запису, всі його ресурси та дані будуть назавжди видалені. Перед видаленням, будь ласка, завантажте будь-які дані чи інформацію, які ви бажаєте зберегти.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Видалити Обліковий Запис') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Ви впевнені, що хочете видалити свій обліковий запис?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Після видалення вашого облікового запису, всі його ресурси та дані будуть назавжди видалені. Будь ласка, введіть свій пароль, щоб підтвердити остаточне видалення облікового запису.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Пароль') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Пароль') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Скасувати') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Видалити Обліковий Запис') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>