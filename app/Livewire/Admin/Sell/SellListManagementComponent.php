<?php

namespace App\Livewire\Admin\Sell;
use Livewire\WithPagination;
use App\Models\SaleEnquiry;
use App\Models\SaleEnquiryImage;
use Livewire\Component;

class SellListManagementComponent extends Component
{
    use WithPagination;

    public $search = '';
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $saleEnquiries = SaleEnquiry::with('imageSet')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('number', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10); // Adjust per-page count as needed

        return view('livewire.admin.sell.sell-list-management-component', [
            'saleEnquiries' => $saleEnquiries,
        ]);
    }
}
