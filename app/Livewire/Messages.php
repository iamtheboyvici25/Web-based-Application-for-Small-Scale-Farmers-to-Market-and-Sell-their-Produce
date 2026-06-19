<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Messages extends Component
{
    public $activeListing = null;
    public $activePartner = null;
    public $messageText = '';

    // If a buyer clicks "Chat with Seller" from a listing, it loads it automatically
    public function mount(Listing $listing = null)
    {
        if ($listing && $listing->exists) {
            $this->activeListing = $listing;
            $this->activePartner = $listing->user;
        }
    }

    // Sends the message to the database
    public function sendMessage()
    {
        $this->validate([
            'messageText' => 'required|string|max:1000',
        ]);

        if (!$this->activeListing || !$this->activePartner) {
            return;
        }

        Message::create([
            'listing_id' => $this->activeListing->id,
            'sender_id' => Auth::id(),
            'receiver_id' => $this->activePartner->id,
            'message' => $this->messageText,
        ]);

        $this->messageText = '';
    }

    // Swaps between different inbox chats when clicked
    public function selectConversation($listingId, $partnerId)
    {
        $this->activeListing = Listing::find($listingId);
        $this->activePartner = User::find($partnerId);
    }

    public function render()
    {
        $userId = Auth::id();

        // Get all sent and received messages to compile the inbox list
        $allMessages = Message::with(['listing', 'sender', 'receiver'])
            ->where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->latest()
            ->get();

        // Group messages into distinct conversations by listing and partner
        $conversations = [];
        foreach ($allMessages as $msg) {
            if (!$msg->listing) continue; // Skip if listing was deleted
            
            $partner = $msg->sender_id === $userId ? $msg->receiver : $msg->sender;
            if (!$partner) continue;

            $key = $msg->listing_id . '-' . $partner->id;

            if (!isset($conversations[$key])) {
                $conversations[$key] = [
                    'listing' => $msg->listing,
                    'partner' => $partner,
                    'last_message' => $msg,
                ];
            }
        }

        // Fetch thread history for the active conversation panel
        $chatHistory = [];
        if ($this->activeListing && $this->activePartner) {
            $chatHistory = Message::where('listing_id', $this->activeListing->id)
                ->where(function ($q) use ($userId) {
                    $q->where(function($sub) use ($userId) {
                        $sub->where('sender_id', $userId)->where('receiver_id', $this->activePartner->id);
                    })->orWhere(function($sub) use ($userId) {
                        $sub->where('sender_id', $this->activePartner->id)->where('receiver_id', $userId);
                    });
                })
                ->oldest()
                ->get();
        }

        return view('livewire.messages', [
            'conversations' => $conversations,
            'chatHistory' => $chatHistory,
        ]);
    }
}