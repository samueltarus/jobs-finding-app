<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    public function index(){
        return view(
            'listing.index',
            [
                'listings' => Listing::latest()
                ->filter(request(['tag', 'search']))
                ->paginate(8)
    
            ]
        );
    }

    public function show(Listing $listing){
        return view(
            'listing.show',
            [
                'listings' => $listing
            ]
        );
        
    }
    public function create(Request $request){

        return view('listing.create');
    }
    public function store(Request $request){
        $data = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }


        $data['user_id'] = auth()->id();

        Listing::create($data);

        return redirect('/')->with('message', 'Job created successfully!');
        
    }
    public function edit(Listing $listing) {
        return view('listing.edit', ['listing' => $listing]);
    }

    // Update Listing Data
    public function update(Request $request, Listing $listing) {
        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }
        
        $data = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($data);

        return back()->with('message', 'Listing updated successfully!');
    }

    // Delete Listing
    public function destroy(Listing $listing) {
        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }
        
        $listing->delete();
        return redirect('/')->with('message', 'Job Deleted successfully');
    }

    // Manage Listings
    public function manage() {
        return view('listing.manage', ['listings' => auth()->user()->listings()->get()]);
    }

}
