<?php

namespace App\Livewire\Owner;
use App\Models\Dormitory;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\Amenities as Aminity;
use Livewire\Component;

class AddDorm extends Component
{
    use WithFileUploads, WithPagination;
public $selectedAmenities = [];
public $amenities;
public $amenities_ids = [];

    protected $paginationTheme = 'tailwind';
    public $showAddEditModal = false;
    public $showDeleteModal = false;
    public $isEditMode = false;
    public $selectedDormitoryId = null;
    public $name;
    public $location;
    public $price;
    public $details;
    public $contact_number;
    public $map_link;
    public $image;
    public $newImage = null;
    public $showModal = false;
    public $status = 'active';
    public $slot;

    public function mount()
{
    $this->amenities = Aminity::all();
    $this->resetForm();
}


    protected $rules = [
        'name' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'details' => 'nullable|string',
        'contact_number' => 'required|string|max:15',
        'map_link' => 'nullable|url',
        'newImage' => 'nullable|image|max:2048',
        'status' => 'required|in:active,not active',
        'slot' => 'required|integer|min:0',
    ];

   public function addDormitory()
{
    $this->validate();

    // Ensure that selectedAmenities is correctly set
    $this->amenities_ids = $this->selectedAmenities;


    $imagePath = $this->newImage ? $this->newImage->store('images', 'public') : null;

    // Save dormitory
    $dormitory = Dormitory::create([
        'user_id' => Auth::id(),
        'owner_id' => Auth::id(),
        'name' => $this->name,
        'location' => $this->location,
        'price' => $this->price,
        'details' => $this->details,
        'contact_number' => $this->contact_number,
        'map_link' => $this->map_link,
        'image' => $imagePath,
        'status' => $this->status,
        'slot' => $this->slot,
       'amenities_ids' => json_encode($this->selectedAmenities),
    ]);



    $this->resetForm();
    $this->showModal = false;
}


    // public function editDormitory($id)
    // {
    //     $dormitory = Dormitory::findOrFail($id);
    //     $this->selectedDormitoryId = $dormitory->id;
    //     $this->name = $dormitory->name;
    //     $this->location = $dormitory->location;
    //     $this->price = $dormitory->price;
    //     $this->details = $dormitory->details;
    //     $this->contact_number = $dormitory->contact_number;
    //     $this->map_link = $dormitory->map_link;
    //     $this->image = $dormitory->image; // Current image
    //     $this->isEditMode = true;
    //     $this->showModal = true; // Open modal for editing
    //     $this->status = $dormitory->status;
    //     $this->slot = $dormitory->slot;

    // }

    public function editDormitory($id)
{
    $dormitory = Dormitory::findOrFail($id);
    $this->selectedDormitoryId = $dormitory->id;
    $this->name = $dormitory->name;
    $this->location = $dormitory->location;
    $this->price = $dormitory->price;
    $this->details = $dormitory->details;
    $this->contact_number = $dormitory->contact_number;
    $this->map_link = $dormitory->map_link;
    $this->image = $dormitory->image;
    $this->status = $dormitory->status;
    $this->slot = $dormitory->slot;

    // Load selected amenities
    $this->selectedAmenities = $dormitory->amenities_ids ? json_decode($dormitory->amenities_ids, true) : [];

    $this->isEditMode = true;
    $this->showModal = true;
}


    // public function updateDormitory()
    // {
    //     $this->validate();

    //     $dormitory = Dormitory::findOrFail($this->selectedDormitoryId);

    //     if ($this->newImage) {
    //         // Delete old image if it exists
    //         if ($dormitory->image) {
    //             Storage::disk('public')->delete($dormitory->image);
    //         }
    //         $imagePath = $this->newImage->store('images', 'public');
    //     } else {
    //         $imagePath = $dormitory->image; // Keep old image if no new one is uploaded
    //     }

    //     $dormitory->update([
    //         'name' => $this->name,
    //         'location' => $this->location,
    //         'price' => $this->price,
    //         'details' => $this->details,
    //         'contact_number' => $this->contact_number,
    //         'map_link' => $this->map_link,
    //         'image' => $imagePath,
    //         'status' => $this->status,
    //         'slot' => $this->slot,
    //     ]);

    //     $this->resetForm();
    //     $this->showModal = false; // Close modal after updating
    // }
public function updateDormitory()
{
    $this->validate();

    $dormitory = Dormitory::findOrFail($this->selectedDormitoryId);

    if ($this->newImage) {
        if ($dormitory->image) {
            Storage::disk('public')->delete($dormitory->image);
        }
        $imagePath = $this->newImage->store('images', 'public');
    } else {
        $imagePath = $dormitory->image;
    }

    $dormitory->update([
        'name' => $this->name,
        'location' => $this->location,
        'price' => $this->price,
        'details' => $this->details,
        'contact_number' => $this->contact_number,
        'map_link' => $this->map_link,
        'image' => $imagePath,
        'status' => $this->status,
        'slot' => $this->slot,
        'amenities_ids' => json_encode($this->selectedAmenities), // Save as JSON
    ]);

    $this->resetForm();
    $this->showModal = false;
}

    public function deleteDormitory()
    {
        $dormitory = Dormitory::findOrFail($this->selectedDormitoryId);

        // Delete the associated image
        if ($dormitory->image) {
            Storage::disk('public')->delete($dormitory->image);
        }

        $dormitory->delete();
        $this->showDeleteModal = false;
        $this->resetForm();
    }

    public function confirmDelete($id)
    {
        $this->selectedDormitoryId = $id;
        $this->showDeleteModal = true;
    }

   public function resetForm()
{
    $this->reset(['name', 'location', 'price', 'details', 'contact_number', 'map_link', 'image', 'newImage', 'status', 'slot', 'selectedAmenities']);
}

    public function render()
    {
        return view('livewire.owner.add-dorm', [
            'dormitories' => Dormitory::where('user_id', Auth::id())->paginate(10),
        ]);
    }


}
