<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Marketplace - Browse Fresh Produce') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 bg-white dark:bg-gray-800 p-4 shadow-sm sm:rounded-lg">
                <div class="relative">
                    <x-text-input 
                        wire:model.live="search" 
                        type="text" 
                        class="w-full pl-10" 
                        placeholder="Search for tomatoes, maize, potatoes, or organic produce..." 
                    />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        🔍
                    </div>
                </div>
            </div>

            @if($listings->isEmpty())
                <div class="text-center bg-white dark:bg-gray-800 p-12 rounded-lg shadow">
                    <span class="text-5xl">🌾</span>
                    <h3 class="mt-4 text-lg font-bold text-gray-900 dark:text-white">No produce available right now</h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">Check back later or try adjusting your search terms.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($listings as $listing)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 flex flex-col justify-between overflow-hidden hover:shadow-md transition">
                            
                            <div>
                                <div class="h-40 bg-emerald-50 dark:bg-emerald-950/20 flex flex-col items-center justify-center border-b border-gray-100 dark:border-gray-700 relative">
                                    <span class="text-5xl mb-1">
                                        @if(Str::contains(Str::lower($listing->title), ['tomato', 'pepper'])) 🍅
                                        @elseif(Str::contains(Str::lower($listing->title), ['potato', 'cassava'])) 🥔
                                        @elseif(Str::contains(Str::lower($listing->title), ['onion', 'garlic'])) 🧅
                                        @elseif(Str::contains(Str::lower($listing->title), ['corn', 'maize'])) 🌽
                                        @else 🥬
                                        @endif
                                    </span>
                                    <span class="absolute top-2 right-2 bg-emerald-600 text-white text-xs font-bold px-2 py-0.5 rounded-full shadow">
                                        Verified Farmer
                                    </span>
                                </div>

                                <div class="p-4">
                                    <div class="text-xl font-extrabold text-emerald-600 dark:text-emerald-400">
                                        Ksh {{ number_format($listing->price) }}
                                    </div>
                                    
                                    <h3 class="font-bold text-gray-900 dark:text-gray-100 mt-1 line-clamp-1">
                                        {{ $listing->title }}
                                    </h3>
                                    
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 line-clamp-2 min-h-[40px]">
                                        {{ $listing->description }}
                                    </p>

                                    <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                        <div>👨‍🌾 <span class="font-semibold">{{ $listing->user->name }}</span></div>
                                        <div>📦 {{ $listing->quantity }} {{ $listing->unit }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 pt-0">
                                <a href="{{ route('messages', $listing->id) }}" wire:navigate class="w-full mt-2 inline-flex justify-center items-center px-4 py-2 bg-indigo-600 dark:bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
    💬 Chat with Seller
</a>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>
