@extends('layouts.app')

@section('title','Підбір ательє')

@section('content')
<h1>Підбір ательє</h1>

<form action="{{ route('page.result') }}" method="POST">
    @csrf

    <label>Місто:</label>
    <select name="місто">
        <option value="">-- Оберіть місто --</option>
        <option value="Київ">Київ</option>
        <option value="Львів">Львів</option>
        <option value="Одеса">Одеса</option>
        <option value="Хмельницький">Хмельницький</option>
        <option value="Миколаїв">Миколаїв</option>
    </select>

    <label>Вид роботи:</label>
    <select name="вид роботи">
        <option value="">-- Оберіть --</option>
        <option value="Виготовлення">Виготовлення</option>
        <option value="Ремонт">Ремонт</option>
    </select>

    <label>Термін виготовлення:</label>
    <select name="термін виготовлення">
        <option value="">-- Оберіть --</option>
        <option value="Терміновий">Терміновий</option>
        <option value="Звичайний">Звичайний</option>
    </select>

    <label>Категорія виробу:</label>
    <select name="категорія виробу">
        <option value="">-- Оберіть --</option>
        <option value="Одяг">Одяг</option>
        <option value="Взуття">Взуття</option>
        <option value="Аксесуари">Аксесуари</option>
    </select>

    <label>Для кого:</label>
    <select name="для кого">
        <option value="">-- Оберіть --</option>
        <option value="Жінка">Жінка</option>
        <option value="Чоловік">Чоловік</option>
        <option value="Дитина">Дитина</option>
    </select>

    <label>Асортимент:</label>
    <select name="асортимент">
        <option value="">-- Оберіть --</option>
        <option value="Весільна сукня">Весільна сукня</option>
        <option value="Вечірня сукня">Вечірня сукня</option>
        <option value="Спортивний костюм">Спортивний костюм</option>
        <option value="Трикотажний виріб">Трикотажний виріб</option>
        <option value="Класичний костюм">Класичний костюм</option>
        <option value="Верхній одяг">Верхній одяг</option>
        <option value="Повсякденна сукня">Повсякденна сукня</option>
        <option value="Повсякденний костюм">Повсякденний костюм</option>
        <option value="Сумки">Сумки</option>
        <option value="Головні убори">Головні убори</option>
    </select>
    <p></p>

    <button type="submit">Підібрати</button>
</form>
@endsection
