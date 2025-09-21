<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function index()   { return view('page.index'); }
    public function about()   { return view('page.about'); }
    public function atelier() { return view('page.atelier'); }
    public function faq()     { return view('page.faq'); }
}
