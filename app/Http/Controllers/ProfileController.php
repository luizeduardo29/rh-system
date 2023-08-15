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
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }
    public function index (): View
    {
        return view('index');
        // $allUsers = $request->user()->all();
        // dd($allUsers);
        // return view('index', compact('allUsers'));
        //return view('index')->with('allUsers', $request->user()->all());

    }

    public function edit(Request $request, int $id):View
    {
        if (!$user = $this->model->find($id))
            return redirect()->route('users.index');

        return view('edit', compact('user'));
    }




    // public function edit(Request $request): View
    // {
    //     return view('profile.edit', [
    //         'user' => $request->user(),
    //     ]);
    // }


    public function update(ProfileUpdateRequest $request, int $id): RedirectResponse
    {
        // dd($request->file('photo'));
        // try {
        //     DB::transaction(function () use ($request) {
        //         $photo = User::find($request->user()->id)->photo;

        //         $request->user()->fill($request->validated());

        //         if ($request->user()->isDirty('email'))
        //         {
        //             $request->user()->email_verified_at = null;
        //         }

        //         if($request->user()->isDirty('photo'))
        //         {
        //             if ($photo != null) {
        //                 Storage::delete($photo);
        //             }

        //             $request->user()->photo = $request->file('photo')->store('users/profile');
        //         }

        //         foreach ($request->contacts as $contact) {
        //             $request->user()->contacts()->find($contact['id'])->update($contact);
        //         }
        //     });
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
        if (!$user = $this->model->find($id))
            return redirect()->route('users.index');

        $photo = User::find($user->id)->photo;

        $data = $request->except('email');

        // if ($user->isDirty('email'))
        // {
        //     $user->email_verified_at = null;
        // }
        // dump($photo);
        // dump($request->file('photo'));
        if($request->file('photo') != $photo)
        {
            // dump("entrou aqui");
            if ($photo != null) {
                // dump("deletou a foto");
                Storage::delete($photo);
            }
            $user->photo = $request->file('photo')->store('users/profile');
            // dd("salvou a foto");
        }else
        {
            dd("tenta dnv");
        }

        // dd($photo);

        // if($request->image) {
        //    $data['image'] = $request->image->store('users');
        // }

        $user->update($data);

        if ($request->contact != null) {
            foreach ($request->contacts as $contact) {
                $user->contacts()->find($contact['id'])->update($contact);
            }
        }     

        return redirect()->back();
    }

    // public function destroy(Request $request): RedirectResponse
    // {
    //     $request->validateWithBag('userDeletion', [
    //         'password' => ['required', 'current_password'],
    //     ]);

    //     $user = $request->user();

    //     Auth::logout();

    //     $user->delete();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return Redirect::to('/');
    // }

    public function destroy (){
        return;
    }
}
