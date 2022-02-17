<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\AlphaAndNumeric;
use App\Rules\ExtensionRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('profile.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $profile)
    {
        $validated = $request->validate([
            'full_name' => 'required',
            'old_password' => ['required', new AlphaAndNumeric, 'min:6'],
            'password' => ['nullable', 'confirmed', new AlphaAndNumeric, 'min:6'],
            'photo' => ['nullable', new ExtensionRule(['jpg', 'png']), 'max:100']
        ]);

        if (!Hash::check($validated['old_password'], $profile->getAuthPassword())){
            return redirect()->back()->withErrors('Incorrect password!');
        }

        $temp = time() . '_' . $profile->username . '.';

        if(isset($validated['photo'])){
            if (Storage::exists('public/profile/' . $profile->photo)){
                Storage::delete('public/profile/' . $profile->photo); 
            }
            $file_name = $temp . 
            $request->photo->getClientOriginalExtension();     
        
            $validated['photo']->storeAs('public/profile', $file_name);
            $validated['photo'] = $file_name;
        }

        if ($validated['password'] != null){
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        
        unset($validated['old_password']);
        $profile->update($validated);

        return redirect()->back()->with('success', 'Successfully update your profile!');
    }

}
