<?php

namespace App\Http\Livewire;

use App\Models\Organization;
use Livewire\Component;

class OrganizationAutocomplete extends Component
{
    public $query = '';
    public array $accounts = [];
    public int $selectedAccount = 0;
    public int $highlightIndex = 0;
    public bool $showDropdown;

    public $organization_id;
    public $organization_name;
    public $organization_type;
    public $ext;
    public $label;
    public $placeholder;
    public $required = false;


    public function mount()
    {
        $this->reset();
        if ($this->organization_id) {
            $this->selectedAccount = $this->organization_id;
            $this->query = $this->organization_name;
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
        $this->accounts = Organization::where('name', 'like', $this->query . '%')
            ->when($this->organization_type, function ($query) {
                $query->where('organization_type', $this->organization_type);
            })
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

        $organizations = Organization::where('name', 'like', $this->query . '%')
            ->when($this->organization_type, function ($query) {
                $query->where('organization_type', $this->organization_type);
            })
            ->orderBy('name')
            ->take(5)
            ->get();

        return view('livewire.organization-autocomplete', compact('organizations', 'ext', 'label', 'placeholder', 'required'));
    }
}
