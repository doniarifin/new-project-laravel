<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publishers = Publisher::with('books')->get();

        return view('admin.publisher', compact('publishers'));
    }
    public function api()
    {
        $publishers = Publisher::all();
        $datatables = datatables()->of($publishers)
            ->addColumn('date', function ($publisher) {
                return convert_date($publisher->date);
            })->addIndexColumn();

        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.publisher.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => ':attribute cannot be empty',
            'min' => ':attribute must be at least :min characters',
            'max' => ':attribute cannot be more than :max characters',
            'numeric' => ':attribute must be number'
        ];

        $this->validate($request, [
            'name' => 'required|min:5|max:50',
            'email' => 'required',
            'phone_number' => 'required|numeric',
            'address' => 'required'
        ], $messages);

        Publisher::create($request->all());

        return redirect('publishers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function show(Publisher $publisher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function edit(Publisher $publisher)
    {
        return view('admin.publisher.edit', compact('publisher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publisher $publisher)
    {
        $messages = [
            'required' => ':attribute cannot be empty',
            'min' => ':attribute must be at least :min characters',
            'max' => ':attribute cannot be more than :max characters',
            'numeric' => ':attribute must be number'
        ];

        $this->validate($request, [
            'name' => 'required|min:5|max:50',
            'email' => 'required',
            'phone_number' => 'required|numeric',
            'address' => 'required'
        ], $messages);

        // $this->validate($request, [
        //     'name'  => ['required'],
        // ]);

        $publisher->update($request->all());

        return redirect('publishers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return redirect('publishers');
    }
}
