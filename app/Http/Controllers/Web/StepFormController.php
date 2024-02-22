<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FirstFormService;
use App\Services\SecondFormService;
use App\Models\FirstForm;
use App\Models\SecondForm;
use App\Models\RegistrationProcess;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class StepFormController extends Controller
{
    protected $firstFormService;
    protected $secondFormService;
    public function __construct(FirstFormService $firstFormService, SecondFormService $secondFormService){
        $this->firstFormService     = $firstFormService;
        $this->secondFormService    = $secondFormService;
    }

    public function second_form_index($id){
        $get_id = $id;
        // Proceed to show the second form
        return view('step_second', compact('get_id'));
    }

    public function third_form_index($id){
        $get_id = $id;
        // Proceed to show the second form
        return view('step_third', compact('get_id'));
    }
    private function checkStepCompletion($id, $stepNumber, $formModel): ?RedirectResponse
    {
        $form = $formModel::findOrFail($id);

        $stepProgress = $form->registrationProgresses->where('step_number', $stepNumber)->first();

        if (!$stepProgress) {
            // If no registration progress record exists for the step, redirect to the first step form
            return redirect()->route('first-step-form')->with('error', 'Please start from the first step.');
        }
        if (!$stepProgress->completed) {
            if ($stepNumber == 1) {
                return redirect()->route('step-form.index')->with('error', 'Please complete the first step before proceeding.');
            } elseif ($stepNumber == 2) {
                return redirect()->route('second-form-index', ['id' => $id])->with('error', 'Please complete the third step before proceeding.');
            } elseif ($stepNumber == 3) {
                return redirect()->route('third-form-index', ['id' => $id])->with('error', 'Please complete the third step before proceeding.');
            }
        }

        return null;
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
        $redirect = $this->checkStepCompletion($id, 1, FirstForm::class);
        if ($redirect) {
            return $redirect;
        }

        $redirect = $this->checkStepCompletion($id, 2, FirstForm::class);
        if ($redirect) {
            return $redirect;
        }

        $redirect = $this->checkStepCompletion($id, 3, FirstForm::class);
        if ($redirect) {

            return $redirect;
        }
    }

    public function upload(Request $request)
    {

        $image = $request->file('image');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->storeAs('public/images', $imageName);

        $imageUrl = Storage::url('images/'.$imageName);
        $image = asset("storage/{$imageUrl}");
        return response()->json(['image_url' => $imageUrl]);
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

    /**+
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
            $get_last_insert_id = $this->secondFormService->processForm($validatedData);

            return response()->json(['status' => 'success', 'message' => 'Second form submitted successfully','lastInsertedId' => $get_last_insert_id]);
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
