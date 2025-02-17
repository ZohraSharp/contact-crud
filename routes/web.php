<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;


Route::get('/', function () {
    return redirect()->route('contacts.index'); // Fix: Added return
});
Route::resource('contacts', ContactController::class);
Route::post('contacts/import-xml', [ContactController::class, 'importXML'])->name('contacts.importXML');

