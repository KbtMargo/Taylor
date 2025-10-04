<?php
namespace App\Http\Controllers\Atelier;

use App\Http\Controllers\Controller;
use App\Models\Atelier;
use App\Models\AtelierPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AtelierPhotoController extends Controller
{
    public function index(Atelier $atelier)
    {
        $photos = $atelier->photos()->orderBy('sort_order')->latest('id')->paginate(12);
        return view('atelier.photos.index', compact('atelier','photos'));
    }

    public function create(Atelier $atelier)
    {
        return view('atelier.photos.form', ['atelier'=>$atelier, 'photo'=>new AtelierPhoto()]);
    }

    public function store(Request $r, Atelier $atelier)
    {
        $data = $r->validate([
            'title' => ['nullable','string','max:255'],
            'description' => ['nullable','string'],
            'status' => ['nullable','in:draft,published'],
            'published_at' => ['nullable','date'],
            'image' => ['required','image','max:8192'], // 8MB
        ]);
        $slugSource = $data['title'] ?? pathinfo($r->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
        $slug = Str::slug($slugSource).'-'.Str::random(6);

        $path = $r->file('image')->store("public/ateliers/{$atelier->id}");
        $photo = $atelier->photos()->create([
            'title'        => $data['title'] ?? null,
            'slug'         => $slug,
            'image_path'   => Storage::url($path), // /storage/ateliers/{id}/...
            'description'  => $data['description'] ?? null,
            'status'       => $data['status'] ?? 'draft',
            'published_at' => $data['published_at'] ?? null,
            'sort_order'   => 0,
        ]);

        return redirect()->route('ateliers.photos.edit', [$atelier, $photo])->with('ok','Фото додано');
    }

    public function show(Atelier $atelier, AtelierPhoto $photo)
    {   // опціонально показ детально
        return view('atelier.photos.show', compact('atelier','photo'));
    }

    public function edit(Atelier $atelier, AtelierPhoto $photo)
    {
        return view('atelier.photos.form', compact('atelier','photo'));
    }

    public function update(Request $r, Atelier $atelier, AtelierPhoto $photo)
    {
        $data = $r->validate([
            'title' => ['nullable','string','max:255'],
            'description' => ['nullable','string'],
            'status' => ['nullable','in:draft,published'],
            'published_at' => ['nullable','date'],
            'sort_order' => ['nullable','integer','min:0','max:100000'],
            'image' => ['nullable','image','max:8192'],
        ]);

        if ($r->hasFile('image')) {
            // опційно: видалити старий файл
            // if ($photo->image_path && str_starts_with($photo->image_path, '/storage/')) { ... }
            $path = $r->file('image')->store("public/ateliers/{$atelier->id}");
            $data['image_path'] = Storage::url($path);
        }
        $photo->update($data);

        return back()->with('ok','Збережено');
    }

    public function destroy(Atelier $atelier, AtelierPhoto $photo)
    {
        $photo->delete();
        return redirect()->route('ateliers.photos.index', $atelier)->with('ok','Видалено');
    }
}
