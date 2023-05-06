<div>
    <div class="row">
        <div class="col-md-8">
            <h3 class="card-title">All Movies</h3>
            <hr>
            @if(!is_null($movies) )
                <p class="mb-4">Found {{ $movies->total() }} records</p>
                @if($userId)
                    <div class="badge badge-pill badge-secondary">
                        <button type="button" class="close" aria-label="Short by name" wire:click.prevent="deleteSelectedUserId">
                            <span aria-hidden="true">Short by name &times;</span>
                        </button>
                    </div>
                @endif
                @foreach ($movies as $movie)
                    <div class="card p-3 mb-3">
                        <h4 class="card-title">{{ $movie->title }}</h4>
                        <p class="card-text">{{ $movie->description }}</p>
                        <p class="card-text">
                        <div class="row">
                            <div class="col">Likes: {{ $movie->likes_count }} | Hates: {{ $movie->hates_count }}</div>
                            <div class="col">
                                @if (auth()->check())
                                    <button wire:click="like({{ $movie->id }})" class="btn btn-success mr-9">Like</button>
                                    <button wire:click="hate({{ $movie->id }})" class="btn btn-danger">hates</button>
                                @endif
                            </div>
                            <div class="col">
                                <small class="text-muted">Posted by
                                    <a href="#" wire:click.prevent="fetchUserMovies({{ $movie->user_id }})">
                                        @if ($movie->user_id == auth()->id())
                                            You
                                        @else
                                            {{ $movie->user->name }}
                                        @endif
                                    </a>
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{ $movies->links() }}
            @else
                <p>No records found</p>
            @endif
        </div>
        <div class="col-md-4">
            @if (auth()->check())
                <a href="{{ route('frontend.create') }}" class="btn btn-primary">Create Movie</a>
                <hr>
            @endif
            <div class="sort-by-group">
                <h5>Sort By:</h5>
                <label>
                    <input type="radio" wire:model="sortBy" value="desc"> Date
                </label>
                <label>
                    <input type="radio" wire:model="sortBy" value="likes"> Likes
                </label>
                <label>
                    <input type="radio" wire:model="sortBy" value="hates"> Hates
                </label>
            </div>
        </div>
    </div>
</div>
<style>
    .sort-by-group {
        display: flex;
        flex-direction: column;
    }
</style>
