<?php

namespace App\Http\Controllers\API;

use App\Venue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Venue::latest()->paginate(10);
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
            'name' => 'required|string|max:255|unique:venues',
            'description' => 'string|min:55',
            'location' => 'string|min:6',
            'capacity' => 'integer|min:6'
        ]);
        return Venue::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'location' => $request['location'],
            'capacity' => $request['capacity'],
            'status' => $request['status'],
            'user_id' => 1
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function show(Venue $venue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venue $venue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venue $venue)
    {
        $res = $venue->delete();
        return response()->json([
            'message' => $res ? 'Venue deleted successfully.' : 'Not so much'
        ]);
    }
}
