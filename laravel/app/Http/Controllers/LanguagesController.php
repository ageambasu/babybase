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

    public function rename(Language $language)
    {
        return view('languages.rename', ['language' => $language]);
    }

    public function update(Language $language, Request $request)
    {
        if($request->validate(['name' => 'required|string|min:2|max:255'])) {
            $language->update(['name' => $request->get('name')]);
            return redirect(route('languages.index'));
        }
        return redirect(route('languages.rename', $language));
    }
}
?>
