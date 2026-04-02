<x-app-layout title="All Posts">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">All Posts</h1>
        <a href="{{ route('posts.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">Create New</a>
    </div>

    <div class="bg-white rounded shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-200 border-b">
                    <th class="p-4 font-semibold">ID</th>
                    <th class="p-4 font-semibold">Title</th>
                    <th class="p-4 font-semibold text-center">Author</th>
                    <th class="p-4 font-semibold text-center">Created At</th>
                    <th class="p-4 font-semibold text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4">{{ $post->id }}</td>
                        <td class="p-4 font-bold">{{ $post->title }}</td>
                        <td class="p-4">{{ $post->user->name ?? 'Unknown' }}</td>
                        <td class="p-4">{{ $post->created_at->format('F j, Y, g:i a') }}</td>
                        <td class="p-4 flex gap-4 justify-center items-center">
                            @if ($post->trashed())
                                <form action="{{ route('posts.restore', $post->id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="text-green-600 hover:text-green-800 font-bold underline bg-transparent border-0 cursor-pointer">
                                        Restore
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('posts.show', $post->id) }}"
                                    class="text-blue-500 hover:text-blue-700 underline">Show</a>
                                <a href="{{ route('posts.edit', $post->id) }}"
                                    class="text-yellow-500 hover:text-yellow-700 underline">Edit</a>
                                {{-- <a href="{{ route('posts.show', $post['id']) }}"
                                    class="text-blue-500 hover:text-blue-700 underline">Show</a>
                                <a href="{{ route('posts.edit', $post['id']) }}"
                                    class="text-yellow-500 hover:text-yellow-700 underline">Edit</a> --}}

                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this post?');" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-700 underline bg-transparent border-0 cursor-pointer">Delete</button>
                                </form>
                            @endif

                            {{-- <button type="button" onclick="document.getElementById('delete-modal-{{ $post['id'] }}').classList.remove('hidden')" class="text-red-500 hover:text-red-700 underline bg-transparent border-0 cursor-pointer">
                                Delete
                            </button>

                            <div id="delete-modal-{{ $post['id'] }}" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50">
                                <div class="bg-white p-8 rounded-lg shadow-xl max-w-sm w-full text-center">
                                    
                                    <div class="mb-4 text-red-500 flex justify-center">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                    </div>

                                    <h2 class="text-2xl font-bold mb-4 text-gray-800">Are you sure?</h2>
                                    <p class="text-gray-600 mb-8">Do you really want to delete the post <strong>"{{ $post['title'] }}"</strong>? This process cannot be undone.</p>
                                    
                                    <div class="flex justify-center gap-4">
                                        <button type="button" onclick="document.getElementById('delete-modal-{{ $post['id'] }}').classList.add('hidden')" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-6 rounded transition duration-200">
                                            Cancel
                                        </button>
                                        
                                        <form action="{{ route('posts.destroy', $post['id']) }}" method="POST" class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-6 rounded transition duration-200">
                                                Yes, Delete
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            </div> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $posts->links() }}
    </div>
</x-app-layout>
