<?php

namespace App\Livewire\Buyer;

use App\Models\Listing;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    // Search property to allow buyers to filter produce later if wanted
    public $search = '';

    public function render()
    {
        // Fetch all listings from the database, newest first, eager-loading the farmer (user)
        $listings = Listing::with('user')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->get();

        return view('livewire.buyer.dashboard', [
            'listings' => $listings,
        ]);
    }
}