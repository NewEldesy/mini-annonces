<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;

class AdminAdController extends Controller
{
    public function index()
    {
        $ads = Ad::with('user')->latest()->paginate(10);
        return view('admin.ads.index', compact('ads'));
    }

    public function destroy(Ad $ad)
    {
        $ad->delete();
        return redirect()->route('admin.ads.index')->with('success', 'Annonce supprimée avec succès');
    }

    public function reject(Ad $ad)
    {
        // Logique pour rejeter une annonce (par exemple la marquer comme non approuvée)
        $ad->update(['approved' => false]);
        
        return back()->with('success', 'Annonce rejetée');
    }

    public function approve(Ad $ad)
    {
        // Logique pour approuver une annonce
        $ad->update(['approved' => true]);
        
        return back()->with('success', 'Annonce approuvée');
    }
}