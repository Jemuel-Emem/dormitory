<?php


namespace App\Livewire\Owner;
use Illuminate\Support\Facades\Auth;
use App\Models\Amenities as A;
use Livewire\Component;

class Aminities extends Component
{
    public $name, $description, $price, $amenityId;
    public $isEditing = false;
    public $modal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
    ];

    public function openModal()
    {
        $this->resetFields();
        $this->modal = true;
    }

    public function closeModal()
    {
        $this->modal = false;
    }

    public function saveAmenity()
    {
        $this->validate();

        A::updateOrCreate(
            ['id' => $this->amenityId],
            [
                'user_id' => auth()->id(),
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
            ]
        );

        $this->resetFields();
        session()->flash('message', 'Amenity saved successfully.');
        $this->modal = false;
    }

    public function editAmenity($id)
    {
        $amenity = A::findOrFail($id);
        $this->amenityId = $amenity->id;
        $this->name = $amenity->name;
        $this->description = $amenity->description;
        $this->price = $amenity->price;
        $this->isEditing = true;
        $this->modal = true;
    }

    public function deleteAmenity($id)
    {
        A::destroy($id);
        session()->flash('message', 'Amenity deleted.');
    }

    public function resetFields()
    {
        $this->amenityId = null;
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->isEditing = false;
    }

   public function render()
{
    $userId = Auth::id();

    return view('livewire.owner.aminities', [
        'amenities' => A::where('user_id', $userId)->get(),
    ]);
}
}
