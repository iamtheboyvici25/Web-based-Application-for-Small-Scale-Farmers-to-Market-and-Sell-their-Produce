<?php

namespace App\Livewire\Admin;

use App\Models\Listing;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    // Moderation: Delete Listing
    public function deleteListing(Listing $listing)
    {
        $listing->delete();
        session()->flash('message', 'Listing successfully moderated and removed.');
    }

    // Moderation: Delete User
    public function deleteUser(User $user)
    {
        // Safety check: Don't let the admin delete themselves
        if ($user->id === Auth::id()) {
            session()->flash('error', 'Action denied: You cannot delete your own admin account.');
            return;
        }

        $user->delete();
        session()->flash('message', 'User account and all their associated data have been permanently erased.');
    }

    public function render()
    {
        $stats = [
            'farmers' => User::where('role', 'farmer')->count(),
            'buyers'  => User::where('role', 'buyer')->count(),
            'listings' => Listing::count(),
            'messages' => Message::count(),
        ];

        // Fetch listings
        $allListings = Listing::with('user')->latest()->get();

        // Fetch all users EXCEPT the currently logged-in admin
        $allUsers = User::where('id', '!=', Auth::id())->latest()->get();

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'allListings' => $allListings,
            'allUsers' => $allUsers,
        ]);
    }
}
