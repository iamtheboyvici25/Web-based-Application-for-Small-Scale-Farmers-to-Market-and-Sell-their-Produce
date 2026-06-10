<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout; // Import this

#[Layout('layouts.app')] // Add this
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
