<?php

namespace App\Livewire\User;

use App\Models\Amenities;
use App\Models\comment;
use App\Models\Dormitory as Dorm;
use App\Models\Reserve_Slot;
use Livewire\Component;
use Livewire\WithPagination;

class Dormitory extends Component
{
    use WithPagination;
    public $showModal = false;
    public $comments = [];
    public $newComment = '';
public $selectedDormitoryId;
    public $selectedDormitoryName;
    public $searchLocation = '';
    public $searchPrice = '';

    public $reserveSlotModal = false;
public $inputSlot = 1;
public $selectedDormSlot = 0;
public $availableAmenities = [];
public $selectedAmenities = [];
public $includedAmenities = [];


    public function render()
    {
        $dormitories = $this->getFilteredDormitories();

        return view('livewire.user.dormitory', [
            'dormitories' => $dormitories,
        ]);
    }

    public function showComments($dormitoryId)
    {
        $dormitory = dorm::with('comments.user')->findOrFail($dormitoryId);
        $this->comments = $dormitory->comments;
        $this->selectedDormitoryName = $dormitory->name;
        $this->selectedDormitoryId = $dormitory->id;
        $this->showModal = true;
    }


    public function addComment()
    {
        $this->validate([
            'newComment' => 'required|string|max:255',
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'dormitory_id' => $this->selectedDormitoryId,
            'content' => $this->newComment,
        ]);


        $this->showComments($this->selectedDormitoryId);


        $this->newComment = '';
    }


    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['newComment', 'selectedDormitoryId']);
    }

//     public function reserve($dormId)
// {
//     $dorm = Dorm::findOrFail($dormId);

//     // Prevent duplicate reservation
//     if (Reserve_Slot::where('user_id', auth()->id())->where('dorm_id', $dormId)->exists()) {
//         flash()->addError('You have already reserved a slot for this dormitory!');
//         return;
//     }

//     // Set state for modal
//     $this->selectedDormitoryId = $dormId;
//     $this->selectedDormSlot = $dorm->slot;
//     $this->inputSlot = 1;
//     $this->reserveSlotModal = true;
// }

public function reserve($dormId)
{
    $dorm = Dorm::findOrFail($dormId);

    if (Reserve_Slot::where('user_id', auth()->id())->where('dorm_id', $dormId)->exists()) {
        flash()->addError('You have already reserved a slot for this dormitory!');
        return;
    }

    $this->selectedDormitoryId = $dormId;
    $this->selectedDormSlot = $dorm->slot;
    $this->inputSlot = 1;

$amenityIds = json_decode($dorm->amenities_ids ?? '[]'); // safe decode
$this->selectedAmenities = Amenities::whereIn('id', $amenityIds)->get();
$this->includedAmenities = []; // reset selected checkboxes







    $this->reserveSlotModal = true;
}



public function confirmReservation()
{
    $this->validate([
        'inputSlot' => 'required|integer|min:1|max:' . $this->selectedDormSlot,
    ]);

    $dorm = Dorm::findOrFail($this->selectedDormitoryId);

    if ($this->inputSlot > $dorm->slot) {
        flash()->addError('Not enough slots available.');
        return;
    }



Reserve_Slot::create([
    'user_id' => auth()->id(),
    'dorm_id' => $this->selectedDormitoryId,
    'slot' => $this->inputSlot,
    'amenities_ids' => json_encode($this->includedAmenities), // Store only checked ones
]);



    $dorm->decrement('slot', $this->inputSlot);
    $this->reserveSlotModal = false;
    flash()->addSuccess('Slot reserved successfully!');
}


    // public function reserve($dormId)
    // {

    //     if (Reserve_Slot::where('user_id', auth()->id())->where('dorm_id', $dormId)->exists()) {
    //         flash()->addError('You have already reserved a slot for this dormitory!');
    //         return;
    //     }


    //     Reserve_Slot::create([
    //         'user_id' => auth()->id(),
    //         'dorm_id' => $dormId,
    //     ]);

    //     flash()->addSuccess('Slot reserved successfully!');
    // }


    public function search()
    {

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
