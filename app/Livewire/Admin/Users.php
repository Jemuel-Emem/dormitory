<?php
namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class Users extends Component
{
    public function render()
    {
        $users = User::where('is_admin', 0)->get();

        return view('livewire.admin.users', [
            'users' => $users
        ]);
    }
}
