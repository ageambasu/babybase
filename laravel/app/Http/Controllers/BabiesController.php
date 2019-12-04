<?php

namespace App\Http\Controllers;

use App\Baby;
use Illuminate\Http\Request;

class BabiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $babies = Baby::paginate(1);

        return view ('babies.index', ['babies' => $babies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('babies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => ['required', 'min:2', 'max:255']
        ]);

        $baby = new Baby();
        $baby->name = request('name');
        $baby->save();

        return redirect('/babies');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Baby  $baby->id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $baby = Baby::find($id);

        return view('babies.show', ['baby' => $baby]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Baby  $baby->id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $baby = Baby::find($id);

        return view('babies.edit', ['baby' => $baby]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Baby  $baby->id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        request()->validate([
            'name' => ['required', 'min:2', 'max:255']
        ]);

        $baby = Baby::find($id);
        $baby->name = request('name');
        $baby->save();

        return redirect('/babies/' . $baby->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Baby  $baby
     * @return \Illuminate\Http\Response
     */
    public function destroy(Baby $baby)
    {
        //
    }
}
