<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FirstFormService;
use App\Services\SecondFormService;
use App\Models\FirstForm;
use App\Models\SecondForm;
use App\Models\RegistrationProcess;

class StepFormController extends Controller
{
    protected $firstFormService;
    protected $secondFormService;
    public function __construct(FirstFormService $firstFormService, SecondFormService $secondFormService){
        $this->firstFormService     = $firstFormService;
        $this->secondFormService    = $secondFormService;
    }

    private function checkStepCompletion($id, $stepNumber, $formModel)
    {
        $form = FirstForm::findOrFail($id);

        $completedSteps = $form->registrationProgresses->pluck('step_number', 'completed')->toArray();
        // dd($completedSteps);
        for ($i = 1; $i < $stepNumber; $i++) {
            if (!in_array($i, $completedSteps)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('step_first');
    }

    public function second_form($id)
    {
        if (!$this->checkStepCompletion($id, 1, FirstForm::class)) {
            // First step is not completed, so redirect back or show an error message
            return redirect()->route('step-form.index')->with('error', 'Please complete the first step before accessing the second step.');
        }

        if ($this->checkStepCompletion($id, 2, SecondForm::class)) {
            // Second step is already completed, so redirect back or show an error message
            return redirect()->route('step-form.index')->with('error', 'You have already completed the second step.');
        }
        $get_id = $id;
        // Proceed to show the second form
        return view('step_second', compact('get_id'));
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
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:first_forms|email',
        ]);
        if($validatedData){
            $get_last_insert_id = $this->firstFormService->processForm($request->all());
        }
        return response()->json(['status' => 'success', 'message' => 'Form submitted successfully','lastInsertedId' => $get_last_insert_id]);
    }

    public function store_second_form(Request $request){
        try {
            $validatedData = $this->secondFormService->validateFormData($request->all());
            $this->secondFormService->processForm($validatedData);
            return response()->json(['status' => 'success', 'message' => 'Second form submitted successfully']);
        } catch (\Illuminate\Validation\ValidationException $ex) {
            return response()->json(['errors' => $ex->errors()], 422);
        } catch (\Exception $ex) {
            return response()->json(['errors' => ['integrity_constraint_violation' => [$ex->getMessage()]]], 500);
        }
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
