<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ route('users.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            ← Back to Users
                        </a>
                    </div>

                    <div class="border-b border-gray-200 pb-4 mb-6">
                        <div class="flex items-center">
                            <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-2xl mr-4">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                                <p class="text-gray-500">{{ $user->email }}</p>
                                @if($user->isAdmin())
                                    <span class="inline-block mt-2 px-3 py-1 bg-red-100 text-red-800 text-sm rounded-full">Admin</span>
                                @else
                                    <span class="inline-block mt-2 px-3 py-1 bg-gray-100 text-gray-800 text-sm rounded-full">User</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">User Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Name:</span>
                                    <p class="text-gray-900">{{ $user->name }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Email:</span>
                                    <p class="text-gray-900">{{ $user->email }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Role:</span>
                                    <p class="text-gray-900">{{ $user->isAdmin() ? 'Administrator' : 'Regular User' }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Joined:</span>
                                    <p class="text-gray-900">{{ $user->created_at->format('F d, Y \a\t g:i A') }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Last Updated:</span>
                                    <p class="text-gray-900">{{ $user->updated_at->format('F d, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistics</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Total Posts:</span>
                                    <p class="text-2xl font-bold text-blue-600">{{ $user->posts()->count() }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Published Posts:</span>
                                    <p class="text-lg font-semibold text-green-600">{{ $user->posts()->where('status', 'published')->count() }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Draft Posts:</span>
                                    <p class="text-lg font-semibold text-yellow-600">{{ $user->posts()->where('status', 'draft')->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex space-x-4">
                            <a href="{{ route('users.edit', $user) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Edit User
                            </a>
                            @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to delete this user?')">
                                        Delete User
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
