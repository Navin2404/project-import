<?php

namespace App\Http\Controllers;

use App\Models\BulkData; 
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\BulkDataImportJob; 
use App\Imports\BulkDataImport;
use Illuminate\Support\Facades\Log;
use Yoeunes\Toastr\Facades\Toastr;


class BulkDataController extends Controller
{
    public function index()
    {
        $data = BulkData::paginate(100);
        return view('bulkdata.index', compact('data'));
    }

    public function importPage()
    {
        return view('bulkdata.import');
    }

    public function imported(Request $request)
{
    // Validate the uploaded file
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
    ]);

    try {
        $file = $request->file('file');

        // Increase memory limit and set execution time
        ini_set('memory_limit', '2048M');
        set_time_limit(0);

        // Queue the import job
        Excel::queueImport(new BulkDataImport, $file);

        Log::info('Import job dispatched successfully.');
        Toastr::success('Import process started. Data will be available shortly');
        return redirect()->route('bulkdata.index');
        // ->with('success', 'Import process started. Data will be available shortly.');
    } catch (\Throwable $th) {
        Log::error('Import error: ' . $th->getMessage());
        return redirect()->route('bulkdata.import.page')->with('error', 'Error during import: ' . $th->getMessage());
    }
}


    public function update(Request $request, $id)
    {
        $data = BulkData::findOrFail($id);
        $data->update($request->all());

        return redirect()->back()->with('success', 'Data updated successfully!');
    }
}
