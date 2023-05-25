<?php

namespace App\Http\Livewire;

use App\Models\Plan;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder;

class UserSearch extends Component
{

    use WithPagination;
    public $searchTerm;
    public $noOrg;
    public $noSub;
    public $sub;
    public $role = [];
    // public $role = ['Vendor', 'Vendor Management'];

    public function mount()
    {
        if (session()->has('usersearchTerm')) {
            $this->searchTerm = session('usersearchTerm');
        }
        if (session()->has('usernoOrg')) {
            $this->noOrg = session('usernoOrg');
        }
        if (session()->has('usernoSub')) {
            $this->noSub = session('usernoSub');
        }
        if (session()->has('usersub')) {
            $this->sub = session('usersub');
        }
        if (session()->has('userrole')) {
            $this->role = session('userrole');
        }
    }

    public function clear()
    {
        $this->searchTerm = null;
        $this->noOrg = null;
        $this->noSub = null;
        $this->sub = null;
        $this->role = [];
    }

    public function render()
    {

        session(['usersearchTerm' => $this->searchTerm]);
        session(['usernoOrg' => $this->noOrg]);
        session(['usernoSub' => $this->noSub]);
        session(['usersub' => $this->sub]);
        session(['userrole' => $this->role]);

        $searchTerm = '%' . $this->searchTerm . '%';
        $roles = Role::orderBy('name')->get();

        $role = $this->role;
        $noOrg = $this->noOrg;
        $noSub = $this->noSub;
        $sub = $this->sub;

        // if (auth()->user()->hasRole('Super Admin')) {
        // dd($role);
        $users = User::query()
            ->when($role, function ($query) use ($role) {
                $query->whereHas('roles', function ($query) use ($role) {
                    $query->whereIn('name', $role);
                });
            })
            ->where(
                function ($query) use ($searchTerm) {
                    return $query
                        ->where('name', 'like', $searchTerm)
                        ->orWhere('email', 'like', $searchTerm);
                }
            )
            ->when(!auth()->user()->hasRole('Super Admin'), function ($query) use ($role) {
                $query->whereDoesntHave('roles', function ($q) {
                    $q->where('name', 'Super Admin');
                });
            })
            // ->when($noSub, function ($query) {
            //     $query->with('subscriptions')->whereHas('subscriptions', function ($query) {
            //         return $query->whereNotNull('ends_at');
            //     });
            // })

            // possibly for people with subscriptions
            // ->when($sub, function ($query) {
            //     $query->whereHas('subscriptions', function (Builder $q) {
            //         return $q->active();
            //     });
            // })
            ->when($noSub, function ($query) {
                $query->where(function ($query2) {
                    $query2->whereHas('subscriptions', function (Builder $q) {
                        return $q->whereNotNull('ends_at');
                    })->orWhereDoesntHave('subscriptions');
                });
            })

            // $users =  User::whereHas('subscriptions', function (Builder $q) {
            //     return $q->active();
            // })->get()->toArray();

            // $users = User::with('subscriptions')->whereHas('subscriptions', function ($query) {
            //     return $query->whereNotNull('ends_at');
            // })->get();

            ->when($noOrg, function ($query) {
                return $query->where(
                    function ($query2) {
                        return $query2
                            ->where('organization_id', null)
                            ->orWhere('organization_id', 0);
                    }
                );
                // ->where('organization_id', null);
                // ->orWhere('organization_id', 0);
            })

            ->orderBy('name', 'ASC')
            ->paginate(50);
        // dd($users);

        // User::with("roles")->whereHas("roles", function ($q) {
        //     $q->whereIn("name", ["Individual", "Venue", 'Organisation']);
        // })->get();
        // } else {
        //     $users = User::with("roles")
        //         // ->whereHas("roles", function ($q) {
        //         //     $q->whereNotIn("name", ['Super Admin']);
        //         // })
        //         // ->where(
        //         //     function ($query) use ($searchTerm) {
        //         //         return $query
        //         //             ->where('name', 'like', $searchTerm)
        //         //             ->orWhere('email', 'like', $searchTerm);
        //         //     }
        //         // )
        //         // ->when($searchTerm, function ($query) use ($searchTerm) {
        //         //     $query
        //         //         ->where('name', 'like', $searchTerm)
        //         //         ->orWhere('email', 'like', $searchTerm);
        //         // })
        //         ->when($role, function ($query) use ($role) {
        //             $query->whereHas('roles', function ($query) use ($role) {
        //                 $query->whereIn('name', $role);
        //             });
        //         })
        //         ->where(
        //             function ($query) use ($searchTerm) {
        //                 return $query
        //                     ->where('name', 'like', $searchTerm)
        //                     ->orWhere('email', 'like', $searchTerm);
        //             }
        //         )
        //         ->when(
        //             $noOrg,
        //             function ($query) {
        //                 return $query->where(
        //                     function ($query2) {
        //                         return $query2
        //                             ->where('organization_id', null)
        //                             ->orWhere('organization_id', 0);
        //                     }
        //                 );
        //                 // ->where('organization_id', null);
        //                 // ->orWhere('organization_id', 0);
        //             }
        //         )
        //         ->whereDoesntHave('roles', function ($query) {
        //             $query->where('name', 'Super Admin');
        //         })
        //         ->orderBy('name', 'ASC')
        //         ->paginate(50);
        // }
        // dd($this->role);

        $plans = Plan::all();

        return view('livewire.user-search', compact('users', 'roles', 'plans'));
    }
}
