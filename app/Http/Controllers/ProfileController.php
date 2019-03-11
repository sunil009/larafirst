<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Country;
use App\State;
use App\City;
use App\Http\Requests\StoreUserProfile;
use Illuminate\Support\Facades\Storage;



class ProfileController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $data['users'] = User::with('role', 'profile')->paginate(3);
        // dd($users);
        return view('admin.users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $data['roles'] = Role::all();
        $data['countries'] = Country::all();

        return view('admin.users.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserProfile $request) {

        $path = 'images/no-thumbnail.jpeg';
        if($request->has('thumbnail')) {

            $extension = ".".$request->thumbnail->getClientOriginalExtension();
            $name = basename($request->thumbnail->getClientOriginalName(), $extension).time().$extension;
            $name = strtolower(str_replace(" ", "-", $name));

            $path = $request->thumbnail->storeAs('public/uploads/profile', $name);
        }

        $user = User::create([
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'status'   => $request->status,
        ]);

        if($user) {
            $profile = Profile::create([
                'user_id'     => $user->id,
                'name'        => $request->name,
                'thumbnail'   => $path,
                'address'     => $request->address,
                'country_id'  => $request->country_id,
                'state_id'    => $request->state_id,
                'city_id'     => $request->city_id,
                'slug'        => $request->slug,
                'phone'       => $request->phone,
            ]);
        }

        if($user && $profile) {
            return back()->with('message', 'User Created Successfully.');
        } else  {
            return back()->with('message', 'Error Inserting Record!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile) {

        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile) {

        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile) {

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile) {

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function remove(Profile $profile) {
        
        if ($profile->delete()) {
            return back()->with('message', 'Product Successfully Trashed!');
        } else {
            return back()->with('message', 'Error Deleting Product');
        }
    }

    public function getStates(Request $request, $id) {

        if($request->ajax()) {

            return State::where('country_id', $id)->get();
        } else {

            return 0;
        }
    }

    public function getCities(Request $request, $id) {

        if($request->ajax()) {

            return City::where('state_id', $id)->get();
        } else {

            return 0;
        }
    }
}
