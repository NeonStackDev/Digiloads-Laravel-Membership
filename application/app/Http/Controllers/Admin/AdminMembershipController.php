<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserMembership;
use App\Models\MembershipPlan;

class AdminMembershipController extends Controller
{
    //
    public function index()
    {
        $pageTitle = 'All Memberships';        
        $memberships = $this->membershipData();
        // dd($memberships); // Debugging line to check memberships data
        return view('admin.memberships.index', compact('memberships', 'pageTitle'));
    }

    public function approve($id)
    {
        $membership = UserMembership::findOrFail($id);
        $membership->status = 'active';
        $membership->save();

        // Optional: notify user
        return back()->with('success', 'Membership approved.');
    }

    public function reject($id)
    {
        $membership = UserMembership::findOrFail($id);
        $membership->status = 'rejected';
        $membership->save();

        // Optional: notify user
        return back()->with('error', 'Membership rejected.');
    }
    public function manage()
    {
        $pageTitle = 'Manage Memberships';
        $membershipplans = MembershipPlan::all(); // Fetch  membershipsplans

        return view('admin.memberships.manage', compact('membershipplans', 'pageTitle'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'duration_days' => 'required',
            'limit' => 'required',
            
        ]);

        $membership =new MembershipPlan();
        $membership->name = $request->name;
        $membership->price = $request->price;
        $membership->duration_days = $request->duration_days;
        $membership->daily_download_limit = $request->limit;       
        $membership->save();

        $notify[] = ['success', 'Membership has been created successfully'];
        return back()->withNotify($notify);
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'limit' => 'required',
            
        ]);

        $membership = MembershipPlan::find($request->id);
        $membership->name = $request->name;
        $membership->price = $request->price;
        $membership->daily_download_limit = $request->limit;        
        $membership->save();

        $notify[] = ['success', 'Membership has been updated successfully'];
        return back()->withNotify($notify);
    }

    protected function membershipData($scope = null)
    {
        //$memberships = UserMembership::with('user', 'plan')->latest()->get();  
        if ($scope) {
            $memberships = UserMembership::$scope();
        } else {
            $memberships = UserMembership::query();
        }

        //search
        $request = request();
        if ($request->search) {
            $search = $request->search;
            $memberships  = $memberships->with('user', 'plan')->where(function ($memberships) use ($search) {
                $memberships->with('user', 'plan')->where('username', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }
        return $memberships->latest()->paginate(getPaginate());
    }
}
