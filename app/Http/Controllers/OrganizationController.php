<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Partner;
use App\Models\VendorPage;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\OrganizationNote;
use App\Exports\OrganizationsExport;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('organizations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('organizations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' => '',
            'city' => '',
            'state' => '',
            'zip' => ''
        ]);

        // $input = $request->all();

        $organization = new Organization();
        $organization->name = $request->name;
        $organization->leader = $request->leader;
        $organization->address = $request->address;
        $organization->address2 = $request->address2;
        $organization->city = $request->city;
        $organization->state = $request->state;
        $organization->zip = $request->zip;
        $organization->county = $request->county;
        $organization->region = $request->region;
        $organization->phone = $request->phone;
        $organization->fax = $request->fax;
        $organization->email = $request->email;
        $organization->organization_type = $request->organization_type;

        $organization->domain = $request->domain;
        $organization->website = $request->website;
        $organization->short_description = $request->short_description;
        $organization->description = $request->description;
        $organization->notes = $request->notes;

        if ($request->image) {
            $fileName = $request->image->getClientOriginalName();
            $fileExt = $request->image->getClientOriginalExtension();
            $file_name = pathinfo($fileName, PATHINFO_FILENAME);
            $newfileName = $file_name . "-" . now()->timestamp . "." . $fileExt;

            $resize = Image::make($request->image)->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->stream()->detach();
            Storage::disk('s3')->put('organizations/' . $newfileName, $resize);

            $organization->image = $newfileName;
        }


        $organization->save();

        return redirect()->route('admin.organizations.show', $organization)->with('success', 'Organization created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization)
    {
        $activities = Activity::where('causer_type', 'App\Models\User')
            ->where('subject_type', 'App\Models\Organization')
            ->where('subject_id', $organization->id)
            ->orderBy('created_at', 'desc')->get();


        $notes = OrganizationNote::where('organization_id', $organization->id)
            ->orderBy('created_at')
            ->with('user:id,name')
            ->with('user.profile:id,user_id,image')
            ->get();

        $notes = $notes
            ->map(function ($item) {
                $item->created_at_formatted = $item->created_at->format('F jS Y h:i A') . ' (' . $item->created_at->diffForHumans() . ')';
                $item->user_image = Storage::disk('s3')->url('profiles/' . ($item->user->profile->image ? $item->user->profile->image : 'no-image.png'));
                return $item;
            });

        return view('organizations.show', compact('organization', 'activities', 'notes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function edit(Organization $organization)
    {
        return view('organizations.edit', compact('organization'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organization $organization)
    {
        $data = $this->validate($request, [
            'name' => 'required',
            'address' => '',
            'city' => '',
            'state' => '',
            'zip' => '',
            'domain' => '',
            'organization_type' => ''
        ]);


        $organization->name = $request->name;
        $organization->leader = $request->leader;
        $organization->address = $request->address;
        $organization->address2 = $request->address2;
        $organization->city = $request->city;
        $organization->state = $request->state;
        $organization->zip = $request->zip;
        $organization->county = $request->county;
        $organization->region = $request->region;
        $organization->phone = $request->phone;
        $organization->fax = $request->fax;
        $organization->email = $request->email;
        $organization->organization_type = $request->organization_type;

        $organization->domain = $request->domain;
        $organization->website = $request->website;
        $organization->short_description = $request->short_description;
        $organization->description = $request->description;
        $organization->notes = $request->notes;

        if ($request->image) {
            $fileName = $request->image->getClientOriginalName();
            $fileExt = $request->image->getClientOriginalExtension();
            $file_name = pathinfo($fileName, PATHINFO_FILENAME);
            $newfileName = $file_name . "-" . now()->timestamp . "." . $fileExt;

            $resize = Image::make($request->image)->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->stream()->detach();
            Storage::disk('s3')->put('organizations/' . $newfileName, $resize);

            $organization->image = $newfileName;
        }


        $organization->update();

        VendorPage::where('organization_id', $organization->id)->delete();
        if ($request->vendor_page == 'true') {
            $vendorPage = new VendorPage();
            $vendorPage->organization_id = $organization->id;
            $vendorPage->save();
        }
        Partner::where('organization_id', $organization->id)->delete();
        if ($request->partner == 'true') {
            $partner = new Partner();
            $partner->organization_id = $organization->id;
            $partner->save();
        }


        return redirect()->route('admin.organizations.show', $organization)->with('success', 'Organization updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $organization)
    {
        $organization->delete();
        return redirect()->route('admin.organizations.index')->with('success', 'Organization deleted');
    }

    public function export()
    {

        $file = 'Organizations-' . now()->format('m-d-Y') . '.xlsx';
        return Excel::download(new OrganizationsExport(), $file);
    }

    public function link(Organization $organization, User $user)
    {
        $user->organization_id = $organization->id;
        $user->update();
        return redirect()->route('admin.dashboard')->with('success', $user->name . ' attached to ' . $organization->name);
    }

    public function createAndLink(User $user)
    {
        $organization = new Organization();
        $organization->name = $user->profile->organization_name;
        if ($user->can('vendor')) {
            $organization->organization_type = 'Vendor';
        } else {
            $organization->organization_type = 'Customer';
        }
        $organization->save();

        $user->organization_id = $organization->id;
        $user->update();

        return redirect()->route('admin.dashboard')->with('success', $organization->name . ' created and ' . $user->name . ' attached');
    }


    public function storenote(Request $request)
    {
        $organizationNote = new OrganizationNote();
        $organizationNote->organization_id = $request->input('organization_id');
        $organizationNote->user_id = auth()->user()->id;
        $organizationNote->note = $request->input('new_note');
        $organizationNote->save();

        $organizationNote->created_at_formatted = $organizationNote->created_at->format('F jS Y h:i A') . ' (' . $organizationNote->created_at->diffForHumans() . ')';
        $organizationNote->user_image = Storage::disk('s3')->url('profiles/' . ($organizationNote->user->profile->image ? $organizationNote->user->profile->image : 'no-image.png'));

        return response()->json($organizationNote);
    }
}
