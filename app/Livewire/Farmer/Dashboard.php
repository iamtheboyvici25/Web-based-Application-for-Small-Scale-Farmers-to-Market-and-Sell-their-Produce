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
    #[Validate('required|string|max:255')]
    public $title = '';

    #[Validate('required|string|max:1000')]
    public $description = '';

    #[Validate('required|numeric|gt:0')]
    public $price = '';

    #[Validate('required|integer|min:1')]
    public $quantity = '';

    #[Validate('required|string')]
    public $unit = 'KG';

    // EDIT MODE PROPERTIES (Add these lines)
    public $isEditing = false;
    public $editingListingId = null;

    // Triggers when the farmer clicks "Edit" next to an item
    public function editListing(Listing $listing)
    {
        // Security check: Make sure this farmer actually owns this listing
        if ($listing->user_id !== Auth::id()) return;

        $this->isEditing = true;
        $this->editingListingId = $listing->id;

        // Populate the input fields with current database data
        $this->title = $listing->title;
        $this->description = $listing->description;
        $this->price = $listing->price;
        $this->quantity = $listing->quantity;
        $this->unit = $listing->unit;
    }

    // Cancels edit mode and clears the form
    public function cancelEdit()
    {
        $this->reset(['title', 'description', 'price', 'quantity', 'unit', 'isEditing', 'editingListingId']);
    }

    // Handles BOTH creating and updating to save space
   // Handles BOTH creating and updating to save space
    public function save()
    {
        $this->validate();
        // ...

        if ($this->isEditing) {
            $listing = Listing::find($this->editingListingId);
            if ($listing && $listing->user_id === Auth::id()) {
                $listing->update([
                    'title' => $this->title,
                    'description' => $this->description,
                    'price' => $this->price,
                    'quantity' => $this->quantity,
                    'unit' => $this->unit,
                ]);
                session()->flash('message', 'Listing updated successfully!');
            }
        } else {
            // Your original Create logic remains exactly the same:
            Auth::user()->listings()->create([
                'title' => $this->title,
                'description' => $this->description,
                'price' => $this->price,
                'quantity' => $this->quantity,
                'unit' => $this->unit,
            ]);
            session()->flash('message', 'Produce listed successfully!');
        }

        $this->cancelEdit();
    }

    public function deleteListing(Listing $listing)
    {
        if ($listing->user_id === Auth::id()) {
            $listing->delete();
            session()->flash('message', 'Listing deleted successfully.');
        }
    }

   public function render()
    {
        return view('livewire.farmer.dashboard', [
            // Change 'myListings' to 'listings' right here 👇
            'listings' => Auth::user()->listings()->latest()->get()
        ]);
    }
}