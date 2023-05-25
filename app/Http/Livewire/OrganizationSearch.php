<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Organization;
use Livewire\WithPagination;

class OrganizationSearch extends Component
{
    use WithPagination;
    public $searchTerm;
    public $organization_type = [];

    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $organization_type = $this->organization_type;

        $organizations = Organization::where('name', 'like', $searchTerm)
            // ->orWhere('email', 'like', $searchTerm)

            ->when(
                $organization_type,
                function ($query) use ($organization_type) {
                    return $query->whereIn('organization_type', $organization_type);
                }
                // ->where('organization_id', null);
                // ->orWhere('organization_id', 0);
            )
            ->orderBy('name', 'ASC')
            ->paginate(50);

        return view('livewire.organization-search', [
            'organizations' => $organizations
        ]);
    }
}
