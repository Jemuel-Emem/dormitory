<?php

namespace App\Livewire\Admin;

use App\Models\Dormitory;
use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public $dormitoryCount;
    public $userCount;

    public function mount()
    {
        $this->dormitoryCount = Dormitory::count();
        $this->userCount = User::count();
    }

    public function render()
    {
        return view('livewire.admin.index');
    }
}
