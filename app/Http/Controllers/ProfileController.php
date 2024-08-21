<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show'); // Make sure you have a 'profile/show.blade.php' view
    }
}
