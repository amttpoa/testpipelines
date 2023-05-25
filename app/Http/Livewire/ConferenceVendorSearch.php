<?php

namespace App\Http\Livewire;

use App\Models\Radio;
use Livewire\Component;
use App\Models\Organization;
use Livewire\WithPagination;
use App\Models\VendorRegistrationSubmission;

class ConferenceVendorSearch extends Component
{
    use WithPagination;
    public $searchTerm;
    public $conference;
    public $public;
    public $invoiced;
    public $paid;
    public $ad;
    public $livefire;
    public $comp;

    public $power = [];
    public $tv = [];
    public $internet = [];
    public $sponsorship = [];

    public function render()
    {
        $searchTerm = $this->searchTerm;
        $conference = $this->conference;
        $public = $this->public;
        $invoiced = $this->invoiced;
        $paid = $this->paid;
        $ad = $this->ad;
        $livefire = $this->livefire;
        $comp = $this->comp;

        $power = $this->power;
        $tv = $this->tv;
        $internet = $this->internet;
        $sponsorship = $this->sponsorship;

        // dd($paid);

        $submissions = VendorRegistrationSubmission::query()
            ->where('conference_id', $conference->id)
            // ->when($searchTerm, function ($query) use ($searchTerm) {
            //     $query->where('company_name', 'like', '%' . $searchTerm . '%');
            // })
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->whereHas(
                    'organization',
                    function ($query) use ($searchTerm) {
                        return $query
                            ->where('name', 'like', '%' . $searchTerm . '%');
                    }
                );
            })
            // ->when(
            //     $public,
            //     function ($query) {
            //         return $query
            //             // ->whereIn('public', [null, 0]);
            //             ->where('public', null)
            //             ->orWhere('public', 0);
            //     }
            // )
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
                $public,
                function ($query) {
                    $query->where(
                        function ($q) {
                            $q->where('public', null)
                                ->orWhere('public', 0);
                        }
                    );
                }
            )
            ->when(
                $invoiced,
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
                            $q->where('paid', null)
                                ->orWhere('paid', 0);
                        }
                    );
                }
            )
            ->when(
                $ad,
                function ($query) {
                    $query->where(
                        function ($q) {
                            $q->whereNotNull('advertising_email')
                                ->where(function ($q2) {
                                    $q2->where('advertising', null)
                                        ->orWhere('advertising', 0);
                                });
                        }
                    );
                }
            )
            ->when(
                $livefire,
                function ($query) {
                    $query->where(
                        function ($q) {
                            $q->where('live_fire', 'Yes');
                        }
                    );
                }
            )
            // ->with(['organization' => function ($query) {
            //     $query->orderBy('name');
            // }])


            ->when($power, function ($query) use ($power) {
                $query->whereIn('power', $power);
            })
            ->when($tv, function ($query) use ($tv) {
                $query->whereIn('tv', $tv);
            })
            ->when($internet, function ($query) use ($internet) {
                $query->whereIn('internet', $internet);
            })
            ->when($sponsorship, function ($query) use ($sponsorship) {
                $query->whereIn('sponsorship', $sponsorship);
            })

            ->orderBy(
                Organization::select('name')
                    ->whereColumn('id', 'vendor_registration_submissions.organization_id')
                    // ->orderByDesc('name')
                    ->limit(1)
            )

            // ->with('organization:id,name')->orderBy('organization.name')
            // ->with(['organization' => function ($q) {
            //     $q->orderBy('name');
            // }])
            // ->join('organizations', 'vendor_registration_submissions.organization_id', '=', 'organizations.id')->orderBy('organizations.name')

            // ->with('organization')
            // ->orderBy('organization.name')
            ->paginate(50);
        // dd($submissions);


        $powers = Radio::where('field', 'power')->orderBy('order')->get();
        $radios = Radio::orderBy('order')->get();

        return view('livewire.conference-vendor-search', compact('submissions', 'powers', 'radios'));
    }
}
