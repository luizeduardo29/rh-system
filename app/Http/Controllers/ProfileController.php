<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index (Request $request): View
    {
        $allUsers = $request->user()->all();
        // dd($allUsers);
        return view('index', compact('allUsers'));

    }




    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }


    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                $photo = User::find($request->user()->id)->photo;

                $request->user()->fill($request->validated());

                if ($request->user()->isDirty('email'))
                {
                    $request->user()->email_verified_at = null;
                }

                if($request->user()->isDirty('photo'))
                {
                    if ($photo != null) {
                        Storage::delete($photo);
                    }

                    $request->user()->photo = $request->file('photo')->store('users/profile');
                }

                foreach ($request->contacts as $contact) {
                    $request->user()->contacts()->find($contact['id'])->update($contact);
                }
            });
        } catch (\Throwable $th) {
            //throw $th;
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
