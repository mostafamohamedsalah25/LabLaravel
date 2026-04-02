<x-app-layout title="Show Post">
    <div class="mb-4">
        <a href="{{ route('posts.index') }}"
            class="text-blue-500 hover:underline border px-4 py-2 rounded bg-white">Back</a>
    </div>
    <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
        <h1 class="text-4xl font-bold mb-4">{{ $post['title'] }}</h1>
        <div class="text-sm text-gray-500 mb-6">
            Created by: <strong>{{ $post->user->name ?? 'Unknown' }}</strong> on
            {{ $post->created_at->format('F j, Y, g:i a') }}
        </div>
        <p class="text-gray-700">{{ $post['body'] }}</p>
    </div>
</x-app-layout>
