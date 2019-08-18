<?php

namespace App\Http\Controllers;

use App\Truism;
use Illuminate\Http\Request;

class TruismController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['response' => ['Good']], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Truism  $truism
     * @return \Illuminate\Http\Response
     */
    public function show(Truism $truism)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Truism  $truism
     * @return \Illuminate\Http\Response
     */
    public function edit(Truism $truism)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Truism  $truism
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Truism $truism)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Truism  $truism
     * @return \Illuminate\Http\Response
     */
    public function destroy(Truism $truism)
    {
        //
    }
}
