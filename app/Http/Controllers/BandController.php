<?php

namespace App\Http\Controllers;

use App\Models\Band;
use Illuminate\Http\Request;
use App\Models\User;

class BandController extends Controller
{
    public function index()
    {
        $bands = Band::with('albums')->get();
        return view('bands.index', compact('bands'));
    }

    public function create()
    {
        return view('bands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('bands', 'public');
        }

        Band::create([
            'name' => $request->name,
            'photo' => $path,
        ]);

        return redirect()->route('bands.index')->with('success', 'Banda criada com sucesso!');
    }

    public function show(Band $band)
    {
        return view('bands.show', compact('band'));
    }

    public function edit(Band $band)
    {
        return view('bands.edit', compact('band'));
    }

    public function update(Request $request, Band $band)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $band->photo = $request->file('photo')->store('bands', 'public');
        }

        $band->name = $request->name;
        $band->save();

        return redirect()->route('bands.index')->with('success', 'Banda atualizada com sucesso!');
    }

    public function destroy(Band $band)
    {
        $band->delete();
        return redirect()->route('bands.index')->with('success', 'Banda removida com sucesso!');
    }
}
