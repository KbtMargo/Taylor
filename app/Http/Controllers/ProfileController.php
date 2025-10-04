<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit(Request $request)
{
    return view('profile.edit', [
        'user' => $request->user(),
    ]);
}


    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:60'],
        ]);
        $request->user()->update($data);
        return back()->with('status','profile-updated');
    }

    public function destroy(Request $request)
    {
        $request->user()->delete();
        auth()->logout();
        return redirect('/')->with('status','profile-deleted');
    }
}
