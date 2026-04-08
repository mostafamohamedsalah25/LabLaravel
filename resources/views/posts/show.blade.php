<x-app-layout title="Show Post">
    <div class="mb-4">
        <a href="{{ route('posts.index') }}"
            class="text-blue-500 hover:underline border px-4 py-2 rounded bg-white">Back</a>
    </div>

    <div class="bg-white p-8 rounded shadow-sm border border-gray-100 mb-8">
        <h1 class="text-4xl font-bold mb-4">{{ $post->title }}</h1>
        <div class="text-sm text-gray-500 mb-6">
            Created by: <strong>{{ $post->user->name ?? 'Unknown' }}</strong> on
            {{ $post->created_at->format('F j, Y, g:i a') }}
        </div>
        <p class="text-gray-700 whitespace-pre-wrap">{{ $post->body }}</p>
    </div>

    <div class="bg-gray-50 p-6 rounded shadow-sm border border-gray-200">
        <h2 class="text-2xl font-bold mb-6">Comments ({{ $post->comments->count() }})</h2>

        <div class="space-y-4 mb-8">
            @forelse($post->comments as $comment)
                <div class="bg-white p-4 rounded border border-gray-100 shadow-sm">
                    <div class="text-sm font-bold text-gray-800 mb-1">
                        {{ $comment->user->name }} <span class="text-xs text-gray-400 font-normal ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-gray-700">{{ $comment->body }}</p>
                </div>
            @empty
                <p class="text-gray-500 italic">No comments yet. Be the first to share your thoughts!</p>
            @endforelse
        </div>

        <form action="{{ route('comments.store', $post->id) }}" method="POST" class="bg-white p-4 rounded border border-gray-200">
            @csrf
            <h3 class="font-bold mb-3">Add a Comment</h3>

            <div class="mb-3">
                <label class="block mb-1 text-sm font-semibold">Post As:</label>
                <select name="user_id" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:border-blue-500 text-sm">
                    <option value="">Select a User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('user_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label class="block mb-1 text-sm font-semibold">Your Comment:</label>
                <textarea name="body" rows="3" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:border-blue-500 text-sm"></textarea>
                @error('body') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">Post Comment</button>
        </form>
    </div>
</x-app-layout>
