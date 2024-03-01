<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StepRequest;
use App\Models\FirstForm;
use App\Services\UserService;

class StepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $getDatas = FirstForm::with('secondForm','thirdForm','registrationProgresses')->get();
        return view('user_info',compact('getDatas'));
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
    public function store(StepRequest $request)
    {
        $validated = $request->validated();
        $created = new FirstForm;
        $created->name = $validated->name;
        $created->email = $validated->email;
        $created->save();
        return response()->json(['status'=>HTTP_OK,'message'=>'inserted successfully']);
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $results = FirstForm::where('name', 'like', "%$query%")
                          ->orWhere('email', 'like', "%$query%")
                          ->limit(5)->get();
        return response()->json($results);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
