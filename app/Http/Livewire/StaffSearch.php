<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class StaffSearch extends Component
{
    use WithPagination;
    public $searchTerm;
    public $role = [];

    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $roles = Role::all();

        $role = $this->role;

        // dump($role);\
        $users = User::role(['Staff'])
            ->with("roles")
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'Super Admin');
            })
            ->where(
                function ($query) use ($searchTerm) {
                    return $query
                        ->where('name', 'like', $searchTerm)
                        ->orWhere('email', 'like', $searchTerm);
                }
            )

            ->orderBy('name', 'ASC')
            ->paginate(50);

        // User::with("roles")->whereHas("roles", function ($q) {
        //     $q->whereIn("name", ["Individual", "Venue", 'Organisation']);
        // })->get();

        return view('livewire.staff-search', compact('users', 'roles'));
    }
}
