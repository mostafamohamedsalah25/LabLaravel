<x-app-layout title="Edit Post">
    <h1 class="text-3xl font-bold mb-6">Edit Post</h1>
    <form action="{{ route('posts.update', $post['id']) }}" method="POST" class="bg-white p-6 rounded shadow-sm border border-gray-100">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Title</label>
            <input type="text" name="title" value="{{ $post['title'] }}" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Body</label>
            <textarea name="body" rows="4" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:border-blue-500">{{ $post['body'] }}</textarea>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
            <a href="{{ route('posts.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
        </div>
    </form>
</x-app-layout>