<x-app-layout>
    @section('title', 'Notifications')

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-900">Your Notifications</h2>
            @if($notifications->where('read_at', null)->count() > 0)
                <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                        Mark all as read
                    </button>
                </form>
            @endif
        </div>

        <div class="overflow-hidden rounded-lg bg-white shadow">
            @if($notifications->isEmpty())
                <div class="px-4 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">No notifications</h3>
                    <p class="mt-1 text-sm text-gray-500">You don't have any notifications yet.</p>
                </div>
            @else
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($notifications as $notification)
                        <li class="px-4 py-4 hover:bg-gray-50 {{ $notification->read_at ? '' : 'bg-indigo-50' }}">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $notification->data['title'] ?? 'Notification' }}
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ $notification->data['message'] ?? '' }}
                                    </p>
                                    <p class="mt-1 text-xs text-gray-400">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                @if(!$notification->read_at)
                                    <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="ml-4 text-xs text-indigo-600 hover:text-indigo-500">
                                            Mark as read
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="px-4 py-3 bg-gray-50">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
