<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovieRequest;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    public function create()
    {
        return view('frontend.movies.create');
    }

    public function store(Request $request)
    {
        // Check if the authenticated user has the same ID as the user ID provided in the request.
        // If not, return a 403 Forbidden response indicating that the user doesn't have the permission to perform the action.
        if(auth()->user()->id !== (int) $request->input('user_id')) {
            return response()->json(['message' => 'You do not have permission to perform this action.'], 403);
        }
        // Validate the form data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'user_id' => 'required|integer'
        ]);

        // Create a new movie instance
        $movie = new Movie([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'user_id' => $request->input('user_id')
        ]);

        // Save the new movie to the database
        $movie->save();

        // Redirect back to the movies index page with a success message
        $user = User::find($request->input('user_id'));
        $user->movies()->attach($movie->id);

        return redirect()->route('home')
            ->with('message', 'Movie added successfully.');
    }
}
