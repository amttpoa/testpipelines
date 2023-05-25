<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Subscribe;
use Livewire\WithPagination;

class SubscribeSearch extends Component
{
    use WithPagination;
    public $searchTerm;
    public $invoice;
    public $credit;


    public function mount()
    {
        if (session()->has('subscribesearchTerm')) {
            $this->searchTerm = session('subscribesearchTerm');
        }
        if (session()->has('subscribeinvoice')) {
            $this->invoice = session('subscribeinvoice');
        }
        if (session()->has('subscribecredit')) {
            $this->credit = session('subscribecredit');
        }
    }

    public function clear()
    {
        $this->searchTerm = null;
        $this->invoice = null;
        $this->credit = null;
    }

    public function render()
    {
        session(['subscribesearchTerm' => $this->searchTerm]);
        session(['subscribeinvoice' => $this->invoice]);
        session(['subscribecredit' => $this->credit]);

        $searchTerm = $this->searchTerm;
        $invoice = $this->invoice;
        $credit = $this->credit;

        // dd($searchTerm);
        $subscribes = Subscribe::query()
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->whereHas(
                    'user',
                    function ($query) use ($searchTerm) {
                        return $query
                            ->where('name', 'like', '%' . $searchTerm . '%')
                            ->orWhere('email', 'like', '%' . $searchTerm . '%');
                    }
                );
            })
            ->when(
                $invoice,
                function ($query) {
                    $query->whereNotNull('email');
                }
            )
            ->when(
                $credit,
                function ($query) {
                    $query->whereNotNull('payment_method');
                }
            )
            ->orderBy('created_at', 'DESC')
            ->paginate(50);
        // dd($searchTerm);

        return view('livewire.subscribe-search', compact('subscribes'));
    }
}
