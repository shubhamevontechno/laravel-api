<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function showForm()
    {
        return view('upload.form');
    }

    public function processUpload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);
        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file));
        $request->session()->put('csvData', $csvData);
        // return redirect()->route('upload.form');
        // return redirect()->route('upload.form')->with('csvData', $csvData);
        return view('upload.confirm', compact('csvData'));
    }

    // public function processUpdload(Request $request)
    // {
    //     return view('upload.confirm', compact('data'));
    // }

    public function destroy(Request $request, $index){
        $csvData = $request->session()->get('csvData');
        unset($csvData[$index]);
        $check = $request->session()->put('csvData', $csvData);

        // return redirect()->route('upload.process');
        return view('upload.confirm', compact('csvData'));
    }
}
