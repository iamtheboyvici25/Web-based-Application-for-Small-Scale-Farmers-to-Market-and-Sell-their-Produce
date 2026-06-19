<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Inbox - Chat Messages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex h-[600px]">
                
                <div class="w-1/3 border-r dark:border-gray-700 overflow-y-auto bg-gray-50 dark:bg-gray-900/50">
                    <div class="p-4 border-b dark:border-gray-700 font-bold text-gray-700 dark:text-gray-300">
                        Recent Chats
                    </div>
                    <div class="divide-y dark:divide-gray-700">
                        @if(empty($conversations))
                            <p class="p-4 text-sm text-gray-500">No active conversations found.</p>
                        @else
                            @foreach($conversations as $key => $chat)
                                <button 
                                    wire:click="selectConversation({{ $chat['listing']->id }}, {{ $chat['partner']->id }})"
                                    class="w-full text-left p-4 flex flex-col hover:bg-gray-100 dark:hover:bg-gray-800 transition {{ ($activeListing && $activeListing->id == $chat['listing']->id && $activePartner && $activePartner->id == $chat['partner']->id) ? 'bg-indigo-50 dark:bg-indigo-950/40' : '' }}"
                                >
                                    <div class="flex justify-between items-baseline">
                                        <span class="font-bold text-gray-900 dark:text-gray-100 text-sm">
                                            {{ $chat['partner']->name }} 
                                            <span class="text-xs font-normal text-gray-500">({{ $chat['partner']->role }})</span>
                                        </span>
                                        <span class="text-xs text-gray-400">{{ $chat['last_message']->created_at->diffForHumans(short: true) }}</span>
                                    </div>
                                    <div class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 mt-0.5">
                                        Item: {{ $chat['listing']->title }}
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400 truncate mt-1">
                                        {{ $chat['last_message']->message }}
                                    </div>
                                </button>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="w-2/3 flex flex-col justify-between bg-white dark:bg-gray-800">
                    @if($activeListing && $activePartner)
                        <div class="p-4 border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-900/20 flex justify-between items-center">
                            <div>
                                <h3 class="font-bold text-gray-900 dark:text-gray-100">{{ $activePartner->name }}</h3>
                                <p class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">Discussing: {{ $activeListing->title }} (Ksh {{ number_format($activeListing->price) }})</p>
                            </div>
                        </div>

                        <div class="flex-1 p-4 overflow-y-auto space-y-4 bg-gray-50/50 dark:bg-gray-900/10 flex flex-col" wire:poll.5s>
                            @foreach($chatHistory as $msg)
                                <div class="max-w-[75%] p-3 rounded-lg shadow-sm {{ $msg->sender_id === Auth::id() ? 'bg-indigo-600 text-white self-end rounded-br-none' : 'bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 self-start rounded-bl-none border dark:border-gray-600' }}">
                                    <p class="text-sm leading-relaxed">{{ $msg->message }}</p>
                                    <span class="text-[10px] block text-right mt-1 {{ $msg->sender_id === Auth::id() ? 'text-indigo-200' : 'text-gray-400' }}">
                                        {{ $msg->created_at->format('h:i A') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <div class="p-4 border-t dark:border-gray-700">
                            <form wire:submit.prevent="sendMessage" class="flex gap-2">
                                <x-text-input 
                                    wire:model="messageText" 
                                    type="text" 
                                    class="flex-1" 
                                    placeholder="Type your marketplace message here..." 
                                    required 
                                />
                                <x-primary-button>
                                    Send 🚀
                                </x-primary-button>
                            </form>
                        </div>
                    @else
                        <div class="flex-1 flex flex-col items-center justify-center text-gray-400 dark:text-gray-500">
                            <span class="text-6xl">💬</span>
                            <h3 class="mt-4 font-bold text-lg text-gray-700 dark:text-gray-300">Your Conversations</h3>
                            <p class="text-sm mt-1 text-center max-w-xs">Select a chat from the sidebar or click "Chat with Seller" on a produce item to start communicating.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>