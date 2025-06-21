<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{

    public function dashboard(Request $request)
    {
        $activeTab = $request->get('tab', 'ads');

        $ads = Ad::with(['user', 'category'])
                ->latest()
                ->paginate(10, ['*'], 'ads_page');

        $users = User::withCount('ads')
                ->latest()
                ->paginate(10, ['*'], 'users_page');

        return view('admin.dashboard', compact('ads', 'users', 'activeTab'));
    }

    public function approveAd(Ad $ad)
    {
        $ad->update(['status' => Ad::STATUS_APPROVED]);
        return back()->with('success', 'Annonce approuvée!');
    }

    public function rejectAd(Ad $ad)
    {
        $ad->update(['status' => Ad::STATUS_REJECTED]);
        return back()->with('success', 'Annonce rejetée!');
    }

    public function banUser(User $user)
    {
        $user->update(['banned_at' => now()]);
        return back()->with('success', 'Utilisateur banni!');
    }

    public function unbanUser(User $user)
    {
        $user->update(['banned_at' => null]);
        return back()->with('success', 'Utilisateur débanni!');
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé!');
    }
}