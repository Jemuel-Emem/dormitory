<?php

namespace App\Livewire\Owner;
use App\Models\monthly_payment as MonthlyPayment;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Tenant;

class Payment extends Component
{
    public $tenants;
    public function markAsPaid($tenantId)
    {
        $ownerId = auth()->id();


        $payment = MonthlyPayment::firstOrCreate(
            [
                'owner_id' => $ownerId,
                'tenant_id' => $tenantId,
            ]

        );


        $payment->update(['status' => 'paid']);
        flash()->success('Payment marked as Paid.');

    }

    public function markAsOverdue($tenantId)
    {
        $ownerId = auth()->id();


        $payment = MonthlyPayment::firstOrCreate(
            [
                'owner_id' => $ownerId,
                'tenant_id' => $tenantId,
            ]

        );


        $payment->update(['status' => 'overdue']);
        flash()->success('Payment marked as Overdue.');
    }
    public function mount()
    {

        $this->tenants = Tenant::where('owner_id', Auth::id())->get();
    }

    public function render()
    {
        return view('livewire.owner.payment', [
            'tenants' => $this->tenants,
        ]);
    }
}
