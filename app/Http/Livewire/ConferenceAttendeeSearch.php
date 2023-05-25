<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Conference;
use Livewire\WithPagination;
use App\Models\ConferenceAttendee;

class ConferenceAttendeeSearch extends Component
{

    use WithPagination;
    public $searchTerm;
    public $conference;
    public $organization;
    public $sort;
    public $membership;
    public $comp;
    public $multi_last;
    public $invoiced;
    public $notinvoiced;
    public $paid;
    public $notpaid;
    public $attendee_id = [];
    public $all_attendee_id = [];
    public $mark_type;
    public $check_all;
    public $item;
    public $not;
    public $package = [];
    public $badge_type = [];


    public function mount()
    {
        if (session()->has('casearchTerm')) {
            $this->searchTerm = session('casearchTerm');
        }
        if (session()->has('caorganization')) {
            $this->organization = session('caorganization');
        }
        if (session()->has('casort')) {
            $this->sort = session('casort');
        }
        if (session()->has('camembership')) {
            $this->membership = session('camembership');
        }
        if (session()->has('cacomp')) {
            $this->comp = session('cacomp');
        }
        if (session()->has('camulti_last')) {
            $this->multi_last = session('camulti_last');
        }
        if (session()->has('cainvoiced')) {
            $this->invoiced = session('cainvoiced');
        }
        if (session()->has('canotinvoiced')) {
            $this->notinvoiced = session('canotinvoiced');
        }
        if (session()->has('capaid')) {
            $this->paid = session('capaid');
        }
        if (session()->has('canotpaid')) {
            $this->notpaid = session('canotpaid');
        }
        if (session()->has('capackage')) {
            $this->package = session('capackage');
        }
        if (session()->has('cabadge_type')) {
            $this->badge_type = session('cabadge_type');
        }
    }


    public function changeMark($mark)
    {
        $this->mark_type = $mark;
    }


    public function checkAll()
    {
        if ($this->check_all) {
            $this->attendee_id = $this->all_attendee_id;
        } else {
            $this->attendee_id = [];
        }
    }
    public function formSubmit()
    {
        $searchTerm = $this->searchTerm;
        $conference = $this->conference;
        $organization = $this->organization;
        $sort = $this->sort;
        $membership = $this->membership;
        $invoiced = $this->invoiced;
        $paid = $this->paid;
        $attendee_id = $this->attendee_id;
        $mark_type = $this->mark_type;
        $item = $this->item;
        $not = $this->not;
        $package = $this->package;

        if ($item == 'full comp') {
            ConferenceAttendee::whereIn('id', $attendee_id)->update(['comp' => $not ? 0 : 1]);
        }
        if ($item == 'invoiced') {
            ConferenceAttendee::whereIn('id', $attendee_id)->update(['invoiced' => $not ? 0 : 1]);
        }
        if ($item == 'paid') {
            ConferenceAttendee::whereIn('id', $attendee_id)->update(['paid' => $not ? 0 : 1]);
        }
        if ($item == 'checked in') {
            ConferenceAttendee::whereIn('id', $attendee_id)->update(['checked_in' => $not ? 0 : 1]);
        }
        if ($item == 'completed') {
            ConferenceAttendee::whereIn('id', $attendee_id)->update(['completed' => $not ? 0 : 1]);
        }

        // dd($mark_type);
    }

    public function clear()
    {
        $this->searchTerm = null;
        $this->organization = null;
        $this->sort = null;
        $this->membership = null;
        $this->comp = null;
        $this->multi_last = null;
        $this->invoiced = null;
        $this->notinvoiced = null;
        $this->paid = null;
        $this->notpaid = null;
        $this->attendee_id = [];
        $this->check_all = null;
        $this->item = null;
        $this->not = null;
        $this->package = [];
        $this->badge_type = [];
    }

    public function render()
    {

        session(['casearchTerm' => $this->searchTerm]);
        session(['caorganization' => $this->organization]);
        session(['casort' => $this->sort]);
        session(['camembership' => $this->membership]);
        session(['cacomp' => $this->comp]);
        session(['camulti_last' => $this->multi_last]);
        session(['cainvoiced' => $this->invoiced]);
        session(['canotinvoiced' => $this->notinvoiced]);
        session(['capaid' => $this->paid]);
        session(['canotpaid' => $this->notpaid]);
        session(['capackage' => $this->package]);
        session(['cabadge_type' => $this->badge_type]);

        $searchTerm = $this->searchTerm;
        $conference = $this->conference;
        $organization = $this->organization;
        $sort = $this->sort;
        $membership = $this->membership;
        $comp = $this->comp;
        $multi_last = $this->multi_last;
        $invoiced = $this->invoiced;
        $notinvoiced = $this->notinvoiced;
        $paid = $this->paid;
        $notpaid = $this->notpaid;
        $attendee_id = $this->attendee_id;
        $mark_type = $this->mark_type;
        $package = $this->package;
        $badge_type = $this->badge_type;

        // dd($selectedAccount);

        $attendees = ConferenceAttendee::query()
            ->where('conference_id', $conference->id)
            // ->when($selectedAccount, function ($query) use ($selectedAccount) {
            //     $query->whereHas(
            //         'user',
            //         function ($query) use ($searchTerm) {
            //             return $query
            //                 ->where('name', 'like', '%' . $searchTerm . '%')
            //                 ->orWhere('email', 'like', '%' . $searchTerm . '%');
            //         }
            //     );
            // })
            ->when($organization, function ($query) use ($organization) {
                $query->whereHas(
                    'user',
                    function ($query) use ($organization) {
                        $query->whereHas(
                            'organization',
                            function ($query) use ($organization) {
                                return $query
                                    ->where('name', 'like', '%' . $organization . '%');
                                // ->orWhere('email', 'like', '%' . $organization . '%');
                            }
                        )->orWhereHas(
                            'organizations',
                            function ($query) use ($organization) {
                                return $query
                                    ->where('name', 'like', '%' . $organization . '%');
                                // ->orWhere('email', 'like', '%' . $organization . '%');
                            }
                        );
                    }
                );
            })
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
            ->when($membership, function ($query) {
                $query->whereDoesntHave(
                    'user',
                    function ($query) {
                        $query->whereHas('subscriptions', function ($s) {
                            $s->whereNested(function ($t) {
                                $t->where('name', 'default') // name of subscription
                                    ->whereNull('ends_at')
                                    ->orWhere('ends_at', '>', Carbon::now())
                                    ->orWhereNotNull('trial_ends_at')
                                    ->where('trial_ends_at', '>', Carbon::today());
                            });
                        });
                    }
                );
            })
            ->when(
                $comp,
                function ($query) {
                    $query->where(
                        function ($q) {
                            $q->where('comp', 1);
                        }
                    );
                }
            )
            ->when(
                $multi_last,
                function ($query) {
                    $query->where(
                        function ($q) {
                            $q->where('card_last_name', 'LIKE', '% %');
                        }
                    );
                }
            )
            ->when(
                $invoiced,
                function ($query) {
                    $query->where(
                        function ($q) {
                            $q->where('invoiced', 1);
                        }
                    );
                }
            )
            ->when(
                $notinvoiced,
                function ($query) {
                    $query->where(
                        function ($q) {
                            $q->where('invoiced', null)
                                ->orWhere('invoiced', 0);
                        }
                    );
                }
            )
            ->when(
                $paid,
                function ($query) {
                    $query->where(
                        function ($q) {
                            $q->where('paid', 1);
                        }
                    );
                }
            )
            ->when(
                $notpaid,
                function ($query) {
                    $query->where(
                        function ($q) {
                            $q->where('paid', null)
                                ->orWhere('paid', 0);
                        }
                    );
                }
            )
            ->when($package, function ($query) use ($package) {
                $query->whereIn('package', $package);
            })
            ->when($badge_type, function ($query) use ($badge_type) {
                $query->whereIn('card_type', $badge_type);
            })
            ->when($sort == 'First Name', function ($query) use ($sort) {
                $query->orderBy('card_first_name');
            })
            ->when($sort == 'Last Name', function ($query) use ($sort) {
                $query->orderBy('card_last_name');
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(100);

        $this->all_attendee_id = $attendees->pluck('id');

        $packages = ConferenceAttendee::where('conference_id', $conference->id)->distinct()->get(['package']);
        $badge_types = ConferenceAttendee::where('conference_id', $conference->id)->distinct()->get(['card_type']);

        // dd($packages);

        return view('livewire.conference-attendee-search', compact('attendees', 'packages', 'badge_types'));
    }
}
