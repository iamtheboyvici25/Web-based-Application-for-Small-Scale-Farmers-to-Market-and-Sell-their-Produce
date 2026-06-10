<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Farmer Dashboard - Manage Produce') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
            
            <div class="w-full md:w-1/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Post New Produce</h3>
                
                @if (session()->has('message'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded border border-green-200">
                        {{ session('message') }}
                    </div>
                @endif

                <form wire:submit="save" class="space-y-4">
                    <div>
                        <x-input-label for="title" :value="__('Produce Title')" />
                        <x-text-input id="title" wire:model="title" class="block mt-1 w-full" placeholder="e.g. Fresh Tomatoes" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" wire:model="description" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" rows="3" required></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <x-input-label for="price" :value="__('Price (Ksh)')" />
                            <x-text-input id="price" wire:model="price" type="number" step="0.01" class="block mt-1 w-full" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>
                        <div class="w-1/2">
                            <x-input-label for="quantity" :value="__('Quantity')" />
                            <x-text-input id="quantity" wire:model="quantity" type="number" class="block mt-1 w-full" required />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="unit" :value="__('Unit Type')" />
                        <select id="unit" wire:model="unit" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                            <option value="kg">Kilograms (kg)</option>
                            <option value="bunch">Bunches</option>
                            <option value="sack">Sacks</option>
                            <option value="piece">Pieces</option>
                        </select>
                        <x-input-error :messages="$errors->get('unit')" class="mt-2" />
                    </div>

                    <x-primary-button class="w-full justify-center">
                        {{ __('Post Listing') }}
                    </x-primary-button>
                </form>
            </div>

            <div class="w-full md:w-2/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Your Active Listings</h3>
                
                @if($listings->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400">You haven't posted any produce yet.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($listings as $listing)
                            <div class="border dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-900 flex flex-col justify-between">
                                <div>
                                    <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $listing->title }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 mb-2">{{ $listing->description }}</p>
                                    <div class="flex justify-between items-center text-sm font-semibold text-indigo-600 dark:text-indigo-400">
                                        <span>Ksh {{ number_format($listing->price, 2) }}</span>
                                        <span>{{ $listing->quantity }} {{ Str::plural($listing->unit, $listing->quantity) }}</span>
                                    </div>
                                </div>
                                <div class="mt-4 pt-4 border-t dark:border-gray-700 flex justify-end">
                                    <button wire:click="delete({{ $listing->id }})" wire:confirm="Are you sure you want to delete this listing?" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>