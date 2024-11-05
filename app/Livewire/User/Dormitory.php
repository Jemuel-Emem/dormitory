<?php

namespace App\Livewire\User;

use App\Models\Dormitory as Dorm;
use Livewire\Component;
use Livewire\WithPagination;

class Dormitory extends Component
{
    use WithPagination;

    public $searchLocation = '';
    public $searchPrice = '';

    public function render()
    {
        $dormitories = $this->getFilteredDormitories();

        return view('livewire.user.dormitory', [
            'dormitories' => $dormitories,
        ]);
    }

    public function search()
    {
        // This function can be empty, as the filtering is already applied in the render method
        // Alternatively, you could put any additional logic needed for searching here.
    }

    private function getFilteredDormitories()
    {
        return Dorm::query()
            ->when($this->searchLocation, function ($query) {
                $query->where('location', 'like', '%' . $this->searchLocation . '%');
            })
            ->when($this->searchPrice, function ($query) {
                $query->where('price', '<=', $this->searchPrice);
            })
            ->paginate(10);
    }
}
