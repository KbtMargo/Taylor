<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Atelier;

class AtelierController extends Controller
{
    public function data(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Ательє "Елегант"',
                'slug' => 'atele-elegant', 
                'image' => '/images/atelier1.jpeg',
                'city' => 'Київ',
                'address' => 'вул. Хрещатик, 10',
                'email' => 'elegant@atelier.ua',
                'phone' => '+380931112233',
                'tags' => [
                    'місто' => ['Київ'],
                    'вид роботи' => ['Виготовлення'],
                    'термін виготовлення' => ['Звичайний'],
                    'категорія виробу' => ['Одяг'],
                    'для кого' => ['Жінка'],
                    'асортимент' => ['Весільна сукня', 'Вечірня сукня'],
                ],
                'about' => 'Ми спеціалізуємося на індивідуальному пошитті суконь преміум-класу.',
                'gallery' => [
                    'https://via.placeholder.com/600x400?text=Elegant+1',
                    'https://via.placeholder.com/600x400?text=Elegant+2',
                ],
                'work_hours' => [
                    'Пн-Пт' => '10:00–19:00',
                    'Сб'    => '11:00–17:00',
                    'Нд'    => 'вихідний',
                ],
            ],
            [
                'id' => 2,
                'name' => 'Ательє "Шик & Стиль"',
                'slug' => 'atele-shik-styl',
                'image' => '/images/atelier2.jpg',
                'city' => 'Львів',
                'address' => 'просп. Свободи, 25',
                'email' => 'chicstyle@atelier.ua',
                'phone' => '+380971234567',
                'tags' => [
                    'місто' => ['Львів'],
                    'вид роботи' => ['Ремонт', 'Виготовлення'],
                    'термін виготовлення' => ['Терміновий'],
                    'категорія виробу' => ['Взуття'],
                    'для кого' => ['Чоловік'],
                ],
                'about' => 'Робимо терміновий ремонт і виготовлення чоловічого взуття.',
                'gallery' => [
                    'https://via.placeholder.com/600x400?text=Chic+1',
                    'https://via.placeholder.com/600x400?text=Chic+2',
                ],
                'work_hours' => [
                    'Пн-Пт' => '09:00–18:00',
                    'Сб'    => '10:00–15:00',
                    'Нд'    => 'вихідний',
                ],
            ],
            [
                'id' => 3,
                'name' => 'Ательє "Модні аксесуари"',
                'slug' => 'atele-modni-aksesuary',
                'image' => '/images/atelier3.jpeg',
                'city' => 'Одеса',
                'address' => 'вул. Дерибасівська, 15',
                'email' => 'accessories@atelier.ua',
                'phone' => '+380661234567',
                'tags' => [
                    'місто' => ['Одеса'],
                    'вид роботи' => ['Виготовлення'],
                    'термін виготовлення' => ['Звичайний', 'Терміновий'],
                    'категорія виробу' => ['Аксесуари'],
                    'що потрібно виготовити' => ['Сумки', 'Головні убори'],
                ],
                'about' => 'Аксесуари ручної роботи з якісних матеріалів.',
                'gallery' => [
                    'https://via.placeholder.com/600x400?text=Acc+1',
                    'https://via.placeholder.com/600x400?text=Acc+2',
                ],
                'work_hours' => [
                    'Пн-Пт' => '10:00–19:00',
                    'Сб'    => '11:00–17:00',
                    'Нд'    => 'вихідний',
                ],
            ],
            [
                'id' => 4,
                'name' => 'Ательє "СпортСтиль"',
                'slug' => 'atele-sportstyl',
                'image' => '/images/atelier4.jpg',
                'city' => 'Київ',
                'address' => 'вул. Січових Стрільців, 12',
                'email' => 'sportstyle@atelier.ua',
                'phone' => '+380501112233',
                'tags' => [
                    'місто' => ['Київ'],
                    'вид роботи' => ['Виготовлення', 'Ремонт'],
                    'термін виготовлення' => ['Терміновий'],
                    'категорія виробу' => ['Одяг'],
                    'для кого' => ['Чоловік', 'Жінка'],
                    'асортимент' => ['Спортивний костюм', 'Трикотажний виріб'],
                ],
                'about' => 'Спортивний одяг на замовлення, індивідуальні лекала.',
                'gallery' => ['https://via.placeholder.com/600x400?text=Sport+1'],
                'work_hours' => [
                    'Пн-Пт' => '09:00–19:00',
                    'Сб'    => '10:00–16:00',
                    'Нд'    => 'вихідний',
                ],
            ],
            [
                'id' => 5,
                'name' => 'Ательє "Класика"',
                'slug' => 'atele-klasyka',
                'image' => '/images/atelier5.jpg',
                'city' => 'Хмельницький',
                'address' => 'вул. Листопадового Чину, 7',
                'email' => 'classica@atelier.ua',
                'phone' => '+380987654321',
                'tags' => [
                    'місто' => ['Хмельницький'],
                    'вид роботи' => ['Виготовлення'],
                    'термін виготовлення' => ['Звичайний'],
                    'категорія виробу' => ['Одяг'],
                    'для кого' => ['Чоловік'],
                    'асортимент' => ['Класичний костюм', 'Верхній одяг'],
                ],
                'about' => 'Класичний чоловічий одяг. Індивідуальна посадка.',
                'gallery' => ['https://via.placeholder.com/600x400?text=Classic+1'],
                'work_hours' => [
                    'Пн-Пт' => '10:00–18:00',
                    'Сб'    => '10:00–14:00',
                    'Нд'    => 'вихідний',
                ],
            ],
            [
                'id' => 6,
                'name' => 'Ательє "Дитячий Світ"',
                'slug' => 'atele-dytyachiy-svit',
                'image' => '/images/atelier6.jpg',
                'city' => 'Миколаїв',
                'address' => 'вул. Катерининська, 22',
                'email' => 'kidsworld@atelier.ua',
                'phone' => '+380667778899',
                'tags' => [
                    'місто' => ['Миколаїв'],
                    'вид роботи' => ['Виготовлення'],
                    'термін виготовлення' => ['Терміновий', 'Звичайний'],
                    'категорія виробу' => ['Одяг'],
                    'для кого' => ['Дитина'],
                    'асортимент' => ['Повсякденна сукня', 'Повсякденний костюм'],
                ],
                'about' => 'Дитячий одяг на кожен день та свята.',
                'gallery' => ['https://via.placeholder.com/600x400?text=Kids+1'],
                'work_hours' => [
                    'Пн-Пт' => '09:30–18:30',
                    'Сб'    => '10:00–15:00',
                    'Нд'    => 'вихідний',
                ],
            ],
            [
                'id' => 7,
                'name' => 'Ательє "DressCode"',
                'slug' => 'atele-dresscode',
                'image' => '/images/atelier7.jpeg',
                'city' => 'Хмельницький',
                'address' => 'вул. Зарічанська, 22',
                'email' => 'dresscode@atelier.ua',
                'phone' => '+380667778899',
                'tags' => [
                    'місто' => ['Хмельницький'],
                    'вид роботи' => ['Виготовлення'],
                    'термін виготовлення' => ['Терміновий', 'Звичайний'],
                    'категорія виробу' => ['Одяг'],
                    'для кого' => ['Чоловік'],
                    'асортимент' => ['Класичний костюм', 'Верхній одяг'],
                ],
                'about' => 'Стиль та якість для сучасних чоловіків.',
                'gallery' => ['https://via.placeholder.com/600x400?text=DressCode+1'],
                'work_hours' => [
                    'Пн-Пт' => '10:00–19:00',
                    'Сб'    => '11:00–16:00',
                    'Нд'    => 'вихідний',
                ],
            ],
            [
                'id' => 8,
                'name' => 'Ательє "Шовк та Фенхель"',
                'slug' => 'atele-shovk-ta-fenhel',
                'image' => '/images/atelier8.jpg',
                'city' => 'Хмельницький',
                'address' => 'вул. Петлюри, 7',
                'email' => 'silkfenhel@atelier.ua',
                'phone' => '+380987654321',
                'tags' => [
                    'місто' => ['Хмельницький'],
                    'вид роботи' => ['Виготовлення'],
                    'термін виготовлення' => ['Звичайний'],
                    'категорія виробу' => ['Одяг'],
                    'для кого' => ['Чоловік'],
                    'асортимент' => ['Класичний костюм', 'Верхній одяг'],
                ],
                'about' => 'Натуральні тканини та бездоганний крій.',
                'gallery' => ['https://via.placeholder.com/600x400?text=Silk+1'],
                'work_hours' => [
                    'Пн-Пт' => '09:00–18:00',
                    'Сб'    => '10:00–14:00',
                    'Нд'    => 'вихідний',
                ],
            ],
        ];
    }

    public function index(Request $request)
    {
        $search = $request->query('search');
        $ateliers = $this->data();

        if ($search) {
            $q = mb_strtolower($search);
            $ateliers = array_values(array_filter($ateliers, function ($a) use ($q) {
                if (mb_stripos(mb_strtolower($a['name']), $q) !== false) return true;
                foreach ($a['tags'] as $tagValues) {
                    foreach ($tagValues as $value) {
                        if (mb_stripos(mb_strtolower($value), $q) !== false) return true;
                    }
                }
                return false;
            }));
        }

        return view('atelier.index', compact('ateliers', 'search'));
    }

    public function show($slug)
    {
        $ateliers = $this->data();
        $atelier = collect($ateliers)->firstWhere('slug', (string)$slug); 
        abort_unless($atelier, 404);

        $atelierMock = new class($atelier, $slug) implements \ArrayAccess {    
            public $data;
            public $currentSlug;

            public function __construct(array $data, string $slug) {
                $this->data = $data;
                $this->currentSlug = $slug; 
            }

            public function offsetSet(mixed $offset, mixed $value): void {}
            public function offsetExists(mixed $offset): bool { return isset($this->data[$offset]); }
            public function offsetUnset(mixed $offset): void {}
            public function offsetGet(mixed $offset): mixed {
                return $this->data[$offset] ?? null;
            }
            
            public function __get($name) {
                if ($name === 'slug') {
                    return $this->currentSlug;
                }
                return $this->data[$name] ?? null;
            }

            public function photos(): object {
                return (object) new class {
                    public function published(): object {
                        return (object) new class {
                            public function orderBy(): object { return $this; }
                            public function latest(): object { return $this; }
                            public function take(): object { return $this; }
                            public function get(): Collection {
                                return collect();
                            }
                        };
                    }
                };
            }
            
            public function comments(): object {
                return (object) new class {
                    public function latest(): object { return $this; }
                    public function get(): Collection {
                        return collect();
                    }
                };
            }
        };

        return view('atelier.show', ['atelier' => $atelierMock]);
    }

    public function show2(string $slug)
{
    $atelier = Atelier::where('slug', $slug)->firstOrFail();
    return view('page.atelier', compact('atelier'));
}
}