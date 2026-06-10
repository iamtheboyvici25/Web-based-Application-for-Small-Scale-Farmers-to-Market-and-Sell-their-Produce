<?php

namespace App\Livewire\Farmer;

use App\Models\Listing;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    // Form properties with built-in validation rules
    #[Validate('required|string|max:255')]
    public $title = '';

    #[Validate('required|string')]
    public $description = '';

    #[Validate('required|numeric|min:0')]
    public $price = '';

    #[Validate('required|integer|min:1')]
    public $quantity = '';

    #[Validate('required|string|max:50')]
    public $unit = 'kg';

    // The Create Action
    public function save()
    {
        $this->validate();

        // Create a new listing tied automatically to the logged-in farmer
        Auth::user()->listings()->create([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'unit' => $this->unit,
        ]);

        session()->flash('message', 'Produce listed successfully!');

        // Clear the form fields after saving
        $this->reset(['title', 'description', 'price', 'quantity', 'unit']);
    }

    // The Delete Action
    public function delete(Listing $listing)
    {
        // Security Check: Only allow deletion if the logged-in user owns this listing
        if ($listing->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $listing->delete();
        session()->flash('message', 'Listing removed.');
    }

    // The Read Action
    public function render()
    {
        // Fetch only the listings belonging to this specific farmer, newest first
        $listings = Auth::user()->listings()->latest()->get();

        return view('livewire.farmer.dashboard', [
            'listings' => $listings,
        ]);
    }
}