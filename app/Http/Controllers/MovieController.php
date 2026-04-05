<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index() {
        $movies = Movie::all()->map(function($movie){
            return [
                "id" => $movie->id,
                "title" => $movie->title,
                "description" => $movie->description,
                "poster" => '/storage/' . $movie->poster
            ];
        });
        return response()->json(['movies' => $movies]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'poster' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $path = $request->file('poster')->store('posters', 'public');

        $movie = Movie::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'poster' => $path,
        ]);

        return response()->json([
            'message' => 'Movie created successfully',
            'movie' => $movie
        ], 201);
    }
}

