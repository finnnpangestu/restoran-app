<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request): RedirectResponse
    {
        if ($request->session()->exists("user")) {
            $user = \App\Models\User::find($request->session()->get("user"));
            
            if ($user && $user->canAccessPanel(app(\Filament\Panel::class))) {
                return redirect("/admin");
            }
        }

        return redirect("/admin/login");
    }
}
