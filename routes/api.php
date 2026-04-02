<?php

use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

Route::post('/leads/{lead}/notes', [LeadController::class, 'storeNote']);
