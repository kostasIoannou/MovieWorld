<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Movie;
use Livewire\WithPagination;

class MoviesList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $userId;
    public $sortBy = '';

    public function fetchUserMovies($userId)
    {
        $this->userId = $userId;
    }

    public function deleteSelectedUserId()
    {
        $this->reset('userId');
    }

    public function like($movieId)
    {
        // Check if the logged-in user
        if (!auth()->check()) {
            return;
        }

        $user = auth()->user();
        $movie = Movie::findOrFail($movieId);

        // Check if the logged-in user is the owner of the movie
        if ($user->id == $movie->user_id) {
            return;
        }

        // Update the pivot row with the disliked value
        $user->hatedBy()->syncWithoutDetaching([$movie->id => [
            'liked' => true,
            'created_at' => now()
        ]]);
    }

    public function hate($movieId)
    {
        // Check if the logged-in user
        if (!auth()->check()) {
            session()->flash('message', 'You must be logged in to dislike a movie.');
            return;
        }

        $user = auth()->user();
        $movie = Movie::findOrFail($movieId);

        // Check if the logged-in user is the owner of the movie
        if ($user->id == $movie->user_id) {
            return;
        }
        // Update the pivot row with the disliked value
        $user->hatedBy()->syncWithoutDetaching([$movie->id => [
            'liked' => false,
            'created_at' => now()
        ]]);
    }

    public function render()
    {
        $query = Movie::select('id', 'title', 'description', 'created_at', 'user_id')
            ->with(['user' => function($query) {
                $query->select('id', 'name');
            }])->withCount('likes', 'hates');

        if ($this->userId) {
            $query->where('user_id', $this->userId);
        }
        if ($this->sortBy == 'desc') {
            $query->orderByDesc('created_at');
        }
        if ($this->sortBy  == 'likes') {
            $query->withCount('likes')->orderByDesc('likes_count');
        }
        if ($this->sortBy == 'hates') {
            $query->withCount('hates')->orderByDesc('hates_count');
        }


        $movies = $query->paginate(10);

        return view('livewire.movies-list',compact('movies'));
    }

}
