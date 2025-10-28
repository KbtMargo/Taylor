<?php
namespace App\View\Components;

use App\Models\User;
use App\Models\Chat; 
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ChatComposer
{
    public function compose(View $view): void
    {
        if (Auth::check()) {
            $currentUser = Auth::user();
            
            $users = User::where('id', '!=', $currentUser->id)->get();

            $groups = $currentUser->chats()
                                  ->where('type', 'group')
                                  ->withCount('participants') 
                                  ->get();

            $view->with('chatUsers', $users);
            $view->with('chatGroups', $groups);
        }
    }
}