<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    public function index()
    {
        Log::error("HERE...");
        return view('page.index');
    }

    public function about()
    {
        return view('page.about');
    }

    public function faq()
    {
        return view('page.faq');
    }

    public function profile()
    {
        return view('page.profile');
    }

    public function match()
    {
        return view('page.match');
    }

    public function catalog()
    {
        $materials = Product::with('images')->where('is_active', true)->get();

        return view('page.catalog', compact('materials'));
    }

    public function select()
    {
        return view('page.select');
    }

    public function result(Request $request)
    {
        $ateliers = $this->getAteliers();

        $criteria = array_filter($request->only([
            'місто', 'вид роботи', 'термін виготовлення', 'категорія виробу', 'для кого', 'асортимент'
        ]));

        $filtered = array_filter($ateliers, function ($atelier) use ($criteria) {
            foreach ($criteria as $key => $value) {
                if (!isset($atelier['tags'][$key])) {
                    return false;
                }
                if (!in_array($value, $atelier['tags'][$key])) {
                    return false;
                }
            }
            return true;
        });

        return view('page.result', ['ateliers' => $filtered]);
    }

    private function getAteliers()
    {
        return [
            [
                'id' => 1,
                'name' => 'Ательє "Елегант"',
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
            ],
            [
                'id' => 2,
                'name' => 'Ательє "Шик & Стиль"',
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
            ],
            [
                'id' => 3,
                'name' => 'Ательє "Модні аксесуари"',
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
            ],
            [
                'id' => 4,
                'name' => 'Ательє "СпортСтиль"',
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
            ],
            [
                'id' => 5,
                'name' => 'Ательє "Класика"',
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
            ],
            [
                'id' => 6,
                'name' => 'Ательє "Дитячий Світ"',
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
            ],
            [
                'id' => 7,
                'name' => 'Ательє "DressCode"',
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
            ],
            [
                'id' => 8,
                'name' => 'Ательє "Шовк та Фенхель"',
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
            ],
        ];
    }
}

