<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-600 dark:text-red-400 leading-tight">
            {{ __('Admin Control Panel - System Overview') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- STATS COUNTER BLOCKS -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-emerald-500">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Total Farmers</div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['farmers'] }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-indigo-500">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Total Buyers</div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['buyers'] }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-amber-500">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Total Listings</div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['listings'] }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-purple-500">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Total Messages</div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['messages'] }}</div>
                </div>
            </div>

            <!-- SESSION MESSAGES -->
            @if (session()->has('message'))
                <div class="p-3 bg-green-100 text-green-700 rounded-lg border border-green-200 text-sm font-medium">
                    ✅ {{ session('message') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="p-3 bg-red-100 text-red-700 rounded-lg border border-red-200 text-sm font-bold">
                    🛑 {{ session('error') }}
                </div>
            @endif

            <!-- GLOBAL LISTINGS MODERATION TABLE -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Content Moderation</h3>

                @if($allListings->isEmpty())
                    <p class="text-gray-500 text-sm">There are currently no listings on the platform to moderate.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b dark:border-gray-700 text-xs font-semibold uppercase text-gray-500 bg-gray-50 dark:bg-gray-900/50">
                                    <th class="p-3">Produce</th>
                                    <th class="p-3">Farmer / Seller</th>
                                    <th class="p-3">Price</th>
                                    <th class="p-3">Stock Available</th>
                                    <th class="p-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y dark:divide-gray-700 text-sm text-gray-700 dark:text-gray-300">
                                @foreach($allListings as $listing)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-900/20">
                                        <td class="p-3 font-medium text-gray-900 dark:text-white">
                                            {{ $listing->title }}
                                            <span class="block text-xs font-normal text-gray-400 line-clamp-1">{{ $listing->description }}</span>
                                        </td>
                                        <td class="p-3">{{ $listing->user->name ?? 'Unknown' }}</td>
                                        <td class="p-3 font-semibold text-emerald-600">Ksh {{ number_format($listing->price) }}</td>
                                        <td class="p-3">{{ $listing->quantity }} {{ $listing->unit }}</td>
                                        <td class="p-3 text-right">
                                            <button wire:click="deleteListing({{ $listing->id }})" wire:confirm="Are you sure you want to delete this listing?" class="px-3 py-1 bg-orange-100 hover:bg-orange-200 text-orange-700 text-xs font-bold rounded transition">
                                                Delete Listing
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- USER MANAGEMENT TABLE -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">User Management</h3>

                @if($allUsers->isEmpty())
                    <p class="text-gray-500 text-sm">There are no other users on the platform.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b dark:border-gray-700 text-xs font-semibold uppercase text-gray-500 bg-gray-50 dark:bg-gray-900/50">
                                    <th class="p-3">Name</th>
                                    <th class="p-3">Email</th>
                                    <th class="p-3">Role</th>
                                    <th class="p-3">Joined Date</th>
                                    <th class="p-3 text-right">Danger Zone</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y dark:divide-gray-700 text-sm text-gray-700 dark:text-gray-300">
                                @foreach($allUsers as $user)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-900/20">
                                        <td class="p-3 font-medium text-gray-900 dark:text-white">{{ $user->name }}</td>
                                        <td class="p-3">{{ $user->email }}</td>
                                        <td class="p-3">
                                            <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full 
                                                {{ $user->role === 'farmer' ? 'bg-emerald-100 text-emerald-700' : ($user->role === 'admin' ? 'bg-red-100 text-red-700' : 'bg-indigo-100 text-indigo-700') }}">
                                                {{ $user->role }}
                                            </span>
                                        </td>
                                        <td class="p-3 text-xs">{{ $user->created_at->format('M d, Y') }}</td>
                                        <td class="p-3 text-right">
                                            <button wire:click="deleteUser({{ $user->id }})" wire:confirm="DANGER: Are you absolutely sure? Deleting this user will permanently erase them, plus all their listings and chat messages!" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded shadow-sm transition">
                                                Delete User
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>