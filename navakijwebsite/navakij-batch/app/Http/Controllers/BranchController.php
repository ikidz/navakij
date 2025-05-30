<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BranchBulk;
use App\Jobs\ImportBranchJob;
class BranchController extends Controller
{
    public function create(Request $request, $id)
    {
        $job = BranchBulk::findOrFail($id);
        if($job->bulk_status != "pending"){
            return response()->json([
                'status' => 'error',
                'message' => 'Import job is running.'
            ]);
        }
        ImportBranchJob::dispatch($job);
        return response()->json([
            'status' => 'success',
            'message' => 'Import job is created.'
        ]);
    }
    public function retryBatch(Request $request, $id)
    {
        $job = BranchBulk::findOrFail($id);
        $job->update(['bulk_status' => 'pending']);
        ImportBranchJob::dispatch($job);
        return response()->json([
            'status' => 'success',
            'message' => 'Import job is created.'
        ]);
    }
}
