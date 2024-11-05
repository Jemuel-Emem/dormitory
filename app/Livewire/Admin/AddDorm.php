<?php

namespace App\Livewire\Admin;

use App\Models\Dormitory;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class AddDorm extends Component
{
    use WithFileUploads, WithPagination;

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

    public function mount()
    {
        // Initialize any necessary properties if required
        $this->resetForm();
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'details' => 'nullable|string',
        'contact_number' => 'required|string|max:15',
        'map_link' => 'nullable|url',
        'newImage' => 'nullable|image|max:2048', // 2MB Max
    ];

    public function addDormitory()
    {
        $this->validate();

        $imagePath = $this->newImage ? $this->newImage->store('images', 'public') : null;

        Dormitory::create([
            'user_id' => Auth::id(),
            'name' => $this->name,
            'location' => $this->location,
            'price' => $this->price,
            'details' => $this->details,
            'contact_number' => $this->contact_number,
            'map_link' => $this->map_link,
            'image' => $imagePath,
        ]);

        $this->resetForm();
        $this->showModal = false; // Close modal after adding
    }

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
        $this->image = $dormitory->image; // Current image
        $this->isEditMode = true;
        $this->showModal = true; // Open modal for editing
    }

    public function updateDormitory()
    {
        $this->validate();

        $dormitory = Dormitory::findOrFail($this->selectedDormitoryId);

        if ($this->newImage) {
            // Delete old image if it exists
            if ($dormitory->image) {
                Storage::disk('public')->delete($dormitory->image);
            }
            $imagePath = $this->newImage->store('images', 'public');
        } else {
            $imagePath = $dormitory->image; // Keep old image if no new one is uploaded
        }

        $dormitory->update([
            'name' => $this->name,
            'location' => $this->location,
            'price' => $this->price,
            'details' => $this->details,
            'contact_number' => $this->contact_number,
            'map_link' => $this->map_link,
            'image' => $imagePath,
        ]);

        $this->resetForm();
        $this->showModal = false; // Close modal after updating
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

    private function resetForm()
    {
        $this->reset(['name', 'location', 'price', 'details', 'contact_number', 'map_link', 'newImage', 'showModal', 'isEditMode', 'selectedDormitoryId']);
    }

    public function render()
    {
        return view('livewire.admin.add-dorm', [
            'dormitories' => Dormitory::paginate(10),
        ]);
    }
}
