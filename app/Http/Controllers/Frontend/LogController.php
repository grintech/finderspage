<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogController extends Controller
{
    public function store(Request $request)
    {
        // Debug request data
        file_put_contents(storage_path('logs/debug.log'), print_r($request->all(), true), FILE_APPEND);

        $message = $request->input('message');
        $type = $request->input('type');

        // Log message to debug file
        file_put_contents(storage_path('logs/debug.log'), "Message: $message, Type: $type\n", FILE_APPEND);

        if ($type === 'error') {
            Log::channel('custom')->error($message);
        } else {
            Log::channel('custom')->info($message);
        }

        return response()->json(['status' => 'success']);
    }
}
