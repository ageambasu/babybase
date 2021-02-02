<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LanguagesController extends Controller
{
    public function index()
    {
        $languages = Language::all();
        return view('languages.index', ['languages' => $languages]);
    }

    public function store(Request $request)
    {
        $lang = Language::firstOrCreate(['name' => $request['name']]);
        $languages = Language::all();
        return redirect(route('languages.index'));
    }

}
?>
