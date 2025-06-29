<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ route('posts.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            ← Back to Posts
                        </a>
                    </div>

                    <div class="border-b border-gray-200 pb-4 mb-6">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $post->title }}</h1>
                        <div class="flex items-center text-sm text-gray-500">
                            <span>By {{ $post->user->name }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $post->created_at->format('M d, Y \a\t g:i A') }}</span>
                            <span class="mx-2">•</span>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="prose max-w-none">
                        <div class="whitespace-pre-wrap text-gray-700 leading-relaxed">
                            {{ $post->content }}
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex space-x-4">
                            <a href="{{ route('posts.edit', $post) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Edit Post
                            </a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to delete this post?')">
                                    Delete Post
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
