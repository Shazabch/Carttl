<?php

namespace App\Livewire\Admin;

use App\Models\VehicleBid;
use App\Notifications\BidConfirmation;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class ManageBids extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = 'all'; // 'all', 'pending', 'accepted', 'rejected'
    protected string $paginationTheme = 'bootstrap';

    protected $queryString = ['search', 'filterStatus'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function toggleBidStatus($bidId)
    {
        $bid = VehicleBid::find($bidId);

        if ($bid) {
            // Toggle between 'pending' and 'accepted' for simplicity here.
            // You might want a more elaborate status flow (e.g., 'pending' -> 'accepted' or 'rejected').
            if ($bid->status === 'accepted') {
                $bid->status = 'pending';
            } else {
                $bid->status = 'accepted';
                if ($bid->user) {
                    Notification::send($bid->user, new BidConfirmation($bid));
                }
            }
            $bid->save();

             $this->dispatch('success-notification', message: 'Bid status updated successfully.');
        } else {
            session()->flash('error', 'Bid not found.');

        }
    }

    // You could add a separate method for explicit rejection if needed
    public function rejectBid($bidId)
    {
        $bid = VehicleBid::find($bidId);
        if ($bid) {
            $bid->status = 'rejected';
            $bid->save();
            session()->flash('message', 'Bid rejected.');
        } else {
            session()->flash('error', 'Bid not found.');
        }
    }


    public function render()
    {
        $query = VehicleBid::with(['user', 'vehicle'])
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('user', function ($sq) {
                    $sq->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                    // ->orWhereHas('vehicle', function ($sq) {
                    //     $sq->where('make', 'like', '%' . $this->search . '%')
                    //         ->orWhere('model', 'like', '%' . $this->search . '%');
                    // })
                    ->orWhere('bid_amount', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        $bids = $query->paginate(10);

        return view('livewire.admin.manage-bids', [
            'bids' => $bids,
        ]);
    }
}
