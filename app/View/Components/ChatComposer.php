<?php
namespace App\View\Components; 

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ChatComposer
{
    public function compose(View $view): void
    {
        if (Auth::check()) {
            
            $recipients = User::where('id', '!=', Auth::id())
                            ->get();

            $view->with('chatRecipients', $recipients);
        }
    }
}