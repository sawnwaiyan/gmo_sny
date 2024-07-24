<?php

namespace App\Http\Controllers;

use App\Models\Asking;
use Illuminate\Http\Request;

class AskingController extends Controller
{
    public function index()
    {
        $askings = Asking::all();
        foreach ($askings as $asking) {
            $asking->questionnaire = json_decode($asking->questionnaire, true);
        }
        return view('askings.index', compact('askings'));
    }

    public function show($id)
    {
        $askings = Asking::findOrFail($id);
        // JSONデータdecode
        $askings->questionnaire = json_decode($askings->questionnaire, true);
        return response()->json($askings->questionnaire);
    }
}
