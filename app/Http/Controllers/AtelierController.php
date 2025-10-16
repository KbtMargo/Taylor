<?php

namespace App\Http\Controllers;

use App\Models\Atelier;
use Illuminate\Http\Request;

class AtelierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ateliers = Atelier::latest()->paginate(9);
        
        return view('atelier.index', compact('ateliers'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Atelier $atelier)
    {
        return view('atelier.show', compact('atelier'));
    }
}