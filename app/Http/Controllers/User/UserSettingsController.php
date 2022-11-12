<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserSettingsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        return Inertia::render('User/UserSettings', ['user' => $user]);
    }
}
