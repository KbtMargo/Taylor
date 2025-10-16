<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    public function index()
    {
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

    public function catalog()
    {
        $products = Product::where('is_active', true)->latest()->get();

        return view('page.catalog', compact('products'));
    }

    public function match()
    {
        return view('page.match');
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
                if (!isset($atelier['tags'][$key]) || !in_array($value, $atelier['tags'][$key])) {
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
            ['id' => 1, 'name' => 'Ательє "Елегант"', 'image' => '/images/atelier1.jpeg', 'city' => 'Київ', 'address' => 'вул. Хрещатик, 10', 'tags' => ['місто' => ['Київ'], 'вид роботи' => ['Виготовлення'], 'термін виготовлення' => ['Звичайний'], 'категорія виробу' => ['Одяг'], 'для кого' => ['Жінка'], 'асортимент' => ['Весільна сукня', 'Вечірня сукня']],],
            ['id' => 2, 'name' => 'Ательє "Шик & Стиль"', 'image' => '/images/atelier2.jpg', 'city' => 'Львів', 'address' => 'просп. Свободи, 25', 'tags' => ['місто' => ['Львів'], 'вид роботи' => ['Ремонт', 'Виготовлення'], 'термін виготовлення' => ['Терміновий'], 'категорія виробу' => ['Взуття'], 'для кого' => ['Чоловік']],],
        ];
    }
}

