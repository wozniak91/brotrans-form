<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'phone' => 'required|max:255',
            'company' => 'required|max:255',
            'vat_number' => 'required|max:255',
            'street' => 'required|max:255',
            'city' => 'required|max:255',
            'postcode' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        return tap($user)->update($request->only('firstname', 'lastname', 'phone', 
            'company', 'vat_number', 'street', 'city', 'postcode', 'email'));
    }
}
