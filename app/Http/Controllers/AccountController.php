<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AccountRequest;
use Illuminate\Http\UploadedFile;


class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $accounts = Account::all();
            $accountsWithImages = $accounts->map(function ($account) {
                // Append the image URL to the account data
                $account['logo'] = asset("storage/{$account->logo}");
                return $account;
            });

            return response()->json(['status' => 200, 'accounts' => $accountsWithImages]);
        } catch (\Exception $e) {
            Log::error("Error getting accounts: " . $e->getMessage());
            return response()->json(['status' => 500, 'message' => 'An error occurred while getting the accounts'], 500);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
           // Check if a file is uploaded
        $validated = $request->validate([
            'bank_name'=>'required',
            'account_name'=>'required',
            'account_number'=>'required',
            'logo'=>'required|image',
        ]);
        try {
            if(!$validated){
                return response()->json(['status'=>403, $validated]);
            }
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoFile = $request->file('logo');
                $logoPath = $logoFile->store('images', 'local');
            }

            // Use Eloquent mass assignment
            $account = Account::create([
                'user_id'        => $request->user_id,
                'bank_name'      => $request->bank_name,
                'account_name'   => $request->account_name,
                'account_number' => $request->account_number,
                'logo'           => $logoPath,
            ]);
            // Log the created account
            Log::info('Account created successfully', ['account_id' => $account->id]);
            return response()->json(['status' => 200, 'message' => 'Account has been created successfully'], 201);

        } catch (\Exception $e) {
            Log::error("Error creating account: " . $e->getMessage());
            return response()->json(['status' => 500, 'message' => 'An error occurred while creating the account'.$e->getMessage()], 500);
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
        try {
            $account = Account::findOrFail($id)->first();
            $account->delete();
            return response()->json(['status' => 200, 'message' => 'Account has been moved to trash'], 201);
        } catch (\Exception $e) {
            Log::error("message from user deleting" . $e->getMessage());
            return response()->json(['status' => 500, 'message' => 'An error occurred while deteing the account'], 500);
        }

    }
}
