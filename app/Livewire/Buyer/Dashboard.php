<?php

namespace App\Livewire\Buyer;

use Livewire\Component;
use Livewire\Attributes\Layout; // 1. Import the Layout attribute

#[Layout('layouts.app')] // 2. Tell Livewire to use Breeze's layout file
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.buyer.dashboard');
    }
}