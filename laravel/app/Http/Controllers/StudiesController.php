<?php

namespace App\Http\Controllers;

use App\Study;
use Illuminate\Http\Request;

class StudiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sortColumn = $request->get('sortColumn', null);
        $sortOrder = $request->get('sortOrder', null);

        if (isset($sortColumn) && $sortColumn != NULL && isset($sortOrder) && $sortOrder != NULL) {

            return view ('studies.index', ['studies' => Study::where('id', '>', 0)->orderBy($sortColumn, $sortOrder)->paginate(10), 'fieldsOnDatabase' => Study::$fieldsOnDatabase]);

        } else {
            
            return view ('studies.index', ['studies' => Study::where('id', '>', 0)->paginate(10), 'fieldsOnDatabase' => Study::$fieldsOnDatabase]);
        
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('studies.create', ['fieldsOnDatabase' => Study::$fieldsOnDatabase]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Study::create($this->validateStudy());

        return redirect(route('studies.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Study  $study
     * @return \Illuminate\Http\Response
     */
    public function show(Study $study)
    {
        return view('studies.show', ['study' => $study, 'fieldsOnDatabase' => Study::$fieldsOnDatabase]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Study  $study
     * @return \Illuminate\Http\Response
     */
    public function edit(Study $study)
    {
        return view('studies.edit', ['study' => $study, 'fieldsOnDatabase' => Study::$fieldsOnDatabase]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Study  $study
     * @return \Illuminate\Http\Response
     */
    public function update(Study $study)
    {
        $validatedAttributes = $this->validateStudy();

        $study->update($validatedAttributes);

        return redirect(route('studies.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Study::where('id', $id)->delete();

        return redirect(route('studies.index'))->with('success','Study deleted successfully.');
    }

    /**
     * Validates the submitted fields.
     *
     * @return \Illuminate\Http\Response
     */
    protected function validateStudy()
    {
        return request()->validate([
            'study_type' => 'required|string|min:2|max:255',
            'study_name' => 'required|string|min:2|max:255',
            'study_age_range_start' => 'required|numeric',
            'study_age_range_end' => 'required|numeric',
            'notes' => 'nullable|string|min:2|max:255',
        ]);
    }
}
