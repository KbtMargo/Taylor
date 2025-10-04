<?php
namespace App\Http\Controllers\Atelier;

use App\Http\Controllers\Controller;
use App\Models\Atelier;
use App\Models\Comment;
use Illuminate\Http\Request;

class AtelierCommentController extends Controller
{
    public function store(Request $r, Atelier $atelier)
    {
        $data = $r->validate([
            'body' => ['required','string','max:2000'],
            'rating' => ['nullable','integer','min:1','max:5'],
        ]);

        $atelier->comments()->create([
            'user_id' => $r->user()?->id,
            'body' => $data['body'],
            'rating' => $data['rating'] ?? null,
        ]);

        return back()->with('ok','Дякуємо за відгук!');
    }

    public function destroy(Atelier $atelier, Comment $comment)
    {
        $comment->delete();
        return back()->with('ok','Відгук видалено');
    }
}
