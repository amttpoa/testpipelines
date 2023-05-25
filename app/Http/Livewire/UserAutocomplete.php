<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class UserAutocomplete extends Component
{
    public $query = '';
    public array $accounts = [];
    public int $selectedAccount = 0;
    public int $highlightIndex = 0;
    public bool $showDropdown;

    public $user_id;
    public $user_name;
    public $organization_type;
    public $ext;
    public $label;
    public $placeholder;
    public $required = false;


    public function mount()
    {
        $this->reset();
        if ($this->user_id) {
            $this->selectedAccount = $this->user_id;
            $this->query = $this->user_name;
        }
    }

    public function reset(...$properties)
    {
        $this->accounts = [];
        $this->highlightIndex = 0;
        $this->query = '';
        $this->selectedAccount = 0;
        $this->showDropdown = true;
    }

    public function hideDropdown()
    {
        $this->showDropdown = false;
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->accounts) - 1) {
            $this->highlightIndex = 0;
            return;
        }

        $this->highlightIndex++;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->accounts) - 1;
            return;
        }

        $this->highlightIndex--;
    }

    public function selectAccount($id = null)
    {
        $id = $id ?: $this->highlightIndex;

        $account = $this->accounts[$id] ?? null;

        if ($account) {
            $this->showDropdown = true;
            $this->query = $account['name'];
            $this->selectedAccount = $account['id'];
        }
    }

    public function updatedQuery()
    {
        $this->accounts = User::where('name', 'like', $this->query . '%')
            ->orderBy('name')
            ->take(5)
            ->get()
            ->toArray();
    }

    public function render()
    {
        $ext = $this->ext;
        $label = $this->label;
        $placeholder = $this->placeholder;
        $required = $this->required;

        $users = User::where('name', 'like', $this->query . '%')
            ->orderBy('name')
            ->take(5)
            ->get();

        return view('livewire.user-autocomplete', compact('users', 'ext', 'label', 'placeholder', 'required'));
    }
}
