<?php

namespace App\Livewire\Admin;

use App\Models\user as DormOwner;
use Livewire\Component;

class AddDormOwner extends Component
{
    public $name, $address, $contact_number, $email, $password, $selectedOwnerId;

    public $isEdit = false;
    public $modalVisible = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'contact_number' => 'required|string|max:15',
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];


    public function render()
    {
        return view('livewire.admin.add-dorm-owner', [
            'owners' => DormOwner::all(),
        ]);
    }

    public function openModal($isEdit = false)
    {
        $this->isEdit = $isEdit;
        $this->modalVisible = true;
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->modalVisible = false;
    }

    public function saveOwner()
{
    $this->validate();

    DormOwner::create([
        'name' => $this->name,
        'contact_number' => $this->contact_number,
        'email' => $this->email,
        'password' => bcrypt($this->password),
        'is_admin' => 2,
    ]);

    $this->closeModal();
}


    public function updateOwner()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:15',
        ]);

        $owner = DormOwner::findOrFail($this->selectedOwnerId);

        $owner->update([
            'name' => $this->name,
            'address' => $this->address,
            'contact_number' => $this->contact_number,
            'email' => $this->email,
        ]);

        $this->closeModal();
    }


    public function editOwner($id)
    {
        $owner = DormOwner::findOrFail($id);

        $this->selectedOwnerId = $owner->id;
        $this->name = $owner->name;
        $this->address = $owner->address;
        $this->contact_number = $owner->contact_number;
        $this->email = $owner->email;

        $this->openModal(true);
    }



    public function deleteOwner($id)
    {
        DormOwner::findOrFail($id)->delete();
    }

    private function resetForm()
    {
        $this->name = '';
        $this->address = '';
        $this->contact_number = '';
        $this->email = '';
        $this->password = '';
        $this->selectedOwnerId = null;
        $this->isEdit = false;
    }
}
