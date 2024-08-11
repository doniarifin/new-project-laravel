<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
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
        return view('admin.member');
    }
    public function api()
    {
        $members = Member::all();
        $datatables = datatables()->of($members)
            ->addColumn('date', function ($member) {
                return convert_date($member->date);
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
        $messages = [
            'required' => ':attribute cannot be empty',
            'min' => ':attribute must be at least :min characters',
            'max' => ':attribute cannot be more than :max characters',
            'numeric' => ':attribute must be number'
        ];

        $this->validate($request, [
            'name' => 'required|min:5|max:50',
            'phone_number' => 'required|numeric',
            'address' => 'required',
            'email' => 'required'
        ], $messages);

        Member::create($request->all());

        return redirect('members');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        $messages = [
            'required' => ':attribute cannot be empty',
            'min' => ':attribute must be at least :min characters',
            'max' => ':attribute cannot be more than :max characters',
            'numeric' => ':attribute must be number'
        ];

        $this->validate($request, [
            'name' => 'required|min:5|max:50',
            'gender' => 'required',
            'phone_number' => 'required|numeric',
            'address' => 'required',
            'email' => 'required'
        ], $messages);

        $member->update($request->all());

        return redirect('members');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        $member->delete();
    }
}
