<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Category;
use App\Http\Requests\AdRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class AdController extends Controller
{

    public function index(Request $request)
    {
        $ads = Ad::with(['category', 'user'])
                ->filter($request->only(['search', 'category', 'min_price', 'max_price']))
                ->where('status', Ad::STATUS_APPROVED)
                ->latest()
                ->paginate(12);

        return view('ads.index', [
            'ads' => $ads,
            'categories' => Category::all(),
            'filters' => $request->all()
        ]);
    }

    public function show(Ad $ad)
    {
        return view('ads.show', ['ad' => $ad->load('user', 'category')]);
    }
    
    // App\Http\Controllers\AdController.php
    public function create()
    {
        $categories = Category::all(); // Assurez-vous que le modèle Category est importé
        return view('ads.create', compact('categories'));
    }

    public function store(AdRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        if ($user->isBanned()) {
            return back()->with('error', 'Your account has been banned.');
        }

        $validated = $request->validated();

        $adData = [
            ...$validated,
            'status' => $user->isAdmin() ? Ad::STATUS_APPROVED : Ad::STATUS_PENDING
        ];

        if ($request->hasFile('image')) {
            $adData['image'] = $request->file('image')->store('ads', '/storage/ads/');
        }

        $ad = $user->ads()->create($adData);

        return redirect()->route('ads.show', $ad)
            ->with('success', 'Annonce créée avec succès!');
    }

    public function edit(Ad $ad)
    {
        Gate::authorize('update', $ad);

        return view('ads.edit', [
            'ad' => $ad,
            'categories' => Category::all()
        ]);
    }

    public function update(AdRequest $request, Ad $ad)
    {
        Gate::authorize('update', $ad);

        if (auth()->user()->isBanned()) {
            return back()->with('error', 'Your account has been banned.');
        }

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($ad->image) {
                Storage::disk('public')->delete($ad->image);
            }
            $validated['image'] = $request->file('image')->store('ads', 'public');
        }

        $ad->update($validated);

        return redirect()->route('ads.show', $ad)
            ->with('success', 'Annonce mise à jour!');
    }

    public function destroy(Ad $ad)
    {
        Gate::authorize('delete', $ad);

        if ($ad->image) {
            Storage::disk('public')->delete($ad->image);
        }

        $ad->delete();

        return redirect()->route('ads.index')
            ->with('success', 'Annonce supprimée!');
    }
}