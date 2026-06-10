<?php

namespace App\Livewire\Farmer;

use Livewire\Component;
use Livewire\Attributes\Layout; // Import this

#[Layout('layouts.app')] // Add this
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.farmer.dashboard');
    }
}
