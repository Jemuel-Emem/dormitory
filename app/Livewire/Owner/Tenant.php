<?php

namespace App\Livewire\Owner;

use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\Tenant as TenantModel;
use App\Models\Reserve_Slot;
use Livewire\Component;

class Tenant extends Component
{
    use WithPagination, WithFileUploads;
public $selectedAmenities = [];
public $amenities = [];


    public $showModal = false, $showDeleteModal = false;
    public $isEditMode = false;
    public $errorMessage = '';
    public $tenantId, $fullname, $age, $phone_number, $room_number, $monthly_fee, $due_date;
public $reservedAmenities = [];
    protected $rules = [
        'fullname'     => 'required|string|max:255',
        'age'          => 'required|numeric|min:1',
        'phone_number' => 'required|string|max:15',
        'room_number'  => 'required|string|max:50',
        'monthly_fee'  => 'required|numeric|min:0',
        'due_date'     => 'required|date',
    ];


public function mount()
{
    $this->amenities = \App\Models\Amenities::all();
}

// public function updatedSelectedAmenities()
// {
//     $reservation = Reserve_Slot::where('status', 'approved')
//         ->whereHas('user', function ($query) {
//             $query->where('name', $this->fullname);
//         })
//         ->whereHas('dorm', function ($query) {
//             $query->where('owner_id', Auth::id());
//         })
//         ->first();

//     $dormFee = $reservation ? $reservation->dorm->price : 0;

//   $amenityFees = \App\Models\Amenities::whereIn('id', $this->selectedAmenities)->sum('price');
//     $this->monthly_fee = $dormFee + $amenityFees;
// }

public function updatedSelectedAmenities()
{
    $reservation = Reserve_Slot::where('status', 'approved')
        ->whereHas('user', function ($query) {
            $query->where('name', $this->fullname);
        })
        ->whereHas('dorm', function ($query) {
            $query->where('owner_id', Auth::id());
        })
        ->first();

    $dormFee = $reservation ? $reservation->dorm->price : 0;

    // Fetch the amenities as models and calculate the sum of their price
    $amenityFees = \App\Models\Amenities::whereIn('id', $this->selectedAmenities)->sum('price');

    // Set the monthly fee
    $this->monthly_fee = $dormFee + $amenityFees;
}

    public function render()
    {

        return view('livewire.owner.tenant', [
            'tenants' => TenantModel::where('owner_id', Auth::id())->paginate(10),
        ]);
    }

    // public function updatedFullname($value)
    // {
    //     $reservation = Reserve_Slot::where('status', 'approved')
    //         ->whereHas('user', function ($query) use ($value) {
    //             $query->where('name', $value);
    //         })
    //         ->whereHas('dorm', function ($query) {
    //             $query->where('owner_id', Auth::id());
    //         })
    //         ->first();

    //     if ($reservation) {
    //         $this->age = $reservation->user->age;
    //         $this->phone_number = $reservation->user->contact_number;
    //         $this->monthly_fee = $reservation->dorm->price;
    //         $this->room_number = $reservation->dorm->name;
    //         $this->errorMessage = '';
    //     } else {
    //         $this->phone_number = '';
    //         $this->monthly_fee = '';
    //         $this->room_number = '';
    //         $this->errorMessage = 'No tenant found with the given name.';
    //     }
    // }

    public function updatedFullname($value)
{
    $reservation = Reserve_Slot::where('status', 'approved')
        ->whereHas('user', function ($query) use ($value) {
            $query->where('name', $value);
        })
        ->whereHas('dorm', function ($query) {
            $query->where('owner_id', Auth::id());
        })
        ->first();

    if ($reservation) {
        $this->age = $reservation->user->age;
        $this->phone_number = $reservation->user->contact_number;
        $this->room_number = $reservation->dorm->name;


        $this->selectedAmenities = is_array($reservation->amenities_ids)
            ? $reservation->amenities_ids
            : json_decode($reservation->amenities_ids, true);


        $dormFee = $reservation->dorm->price;
        $amenityFees = \App\Models\Amenities::whereIn('id', $this->selectedAmenities)->sum('price');

        $this->monthly_fee = $dormFee + $amenityFees;
        $this->errorMessage = '';
    } else {
        $this->age = '';
        $this->phone_number = '';
        $this->room_number = '';
        $this->monthly_fee = '';
        $this->errorMessage = 'No tenant found with the given name.';
    }
}


// public function load(){
// $this->render();
// }

public function load()
{
    $reservation = Reserve_Slot::where('status', 'approved')
        ->whereHas('user', function ($query) {
            $query->where('name', $this->fullname);
        })
        ->whereHas('dorm', function ($query) {
            $query->where('owner_id', Auth::id());
        })
        ->first();

    if ($reservation) {
        $this->age = $reservation->user->age;
        $this->phone_number = $reservation->user->contact_number;
        $this->room_number = $reservation->dorm->name;

        // Convert stored amenities_ids (assuming it's JSON or array)
        $this->selectedAmenities = is_array($reservation->amenities_ids)
            ? $reservation->amenities_ids
            : json_decode($reservation->amenities_ids, true);

        // Fetch the amenities models based on selected amenities
        $this->reservedAmenities = \App\Models\Amenities::whereIn('id', $this->selectedAmenities)->get();

        // Calculate monthly fee
        $dormFee = $reservation->dorm->price;
        $amenityFees = $this->reservedAmenities->sum('price'); // sum of the price attribute from the models

        $this->monthly_fee = $dormFee + $amenityFees;
        $this->errorMessage = '';
    } else {
        $this->errorMessage = 'No tenant found with the given name.';
        $this->reservedAmenities = [];
    }
}

    public function addTenant()
    {
        $this->validate();

        TenantModel::create(array_merge($this->allInputs(), [
            'owner_id' => Auth::id(),
        ]));

        $this->resetModal();
        session()->flash('success', 'Tenant added successfully!');
    }

    public function editTenant($id)
    {
        $this->resetErrorBag();
        $this->isEditMode = true;

        $tenant = TenantModel::where('id', $id)
                    ->where('owner_id', Auth::id()) // Ensure the tenant belongs to the authenticated user
                    ->firstOrFail();

        $this->tenantId     = $tenant->id;
        $this->fullname     = $tenant->fullname;
        $this->age          = $tenant->age;
        $this->phone_number = $tenant->phone_number;
        $this->room_number  = $tenant->room_number;
        $this->monthly_fee  = $tenant->monthly_fee;
        $this->due_date     = $tenant->due_date;

        $this->showModal = true;
    }

    public function updateTenant()
    {
        $this->validate();

        $tenant = TenantModel::where('id', $this->tenantId)
                    ->where('owner_id', Auth::id())
                    ->firstOrFail();

        $tenant->update($this->allInputs());

        $this->resetModal();
        session()->flash('success', 'Tenant updated successfully!');
    }

    public function confirmDelete($id)
    {
        $this->tenantId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteTenant()
    {
        TenantModel::where('id', $this->tenantId)
            ->where('owner_id', Auth::id())
            ->delete();

        $this->showDeleteModal = false;
        session()->flash('success', 'Tenant deleted successfully!');
    }

    private function resetModal()
    {
        $this->reset([
            'showModal', 'isEditMode', 'tenantId', 'fullname',
            'age', 'phone_number', 'room_number', 'monthly_fee', 'due_date'
        ]);
    }

    private function allInputs()
    {
        return [
            'fullname'     => $this->fullname,
            'age'          => $this->age,
            'phone_number' => $this->phone_number,
            'room_number'  => $this->room_number,
            'monthly_fee'  => $this->monthly_fee,
            'due_date'     => $this->due_date,
        ];
    }
}
