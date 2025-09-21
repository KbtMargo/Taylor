<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    public function index()   { 
        Log::error("HERE...");
        return view('page.index'); 
    }
    public function about()   { return view('page.about'); }
    public function atelier() { return view('page.atelier'); }
    public function faq()     { return view('page.faq'); }
}
