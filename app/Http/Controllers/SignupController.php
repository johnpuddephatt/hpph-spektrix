<?php

namespace App\Http\Controllers;

use App\Models\SignupForm;

/**
 * Bare test page for the signup form.
 *
 * Submission lives in App\Livewire\SignupForm and the Spektrix write itself in
 * App\Actions\SubscribeCustomer, so the same code runs here and in the page block.
 * Editors place the real thing via the "Signup form" block.
 */
class SignupController extends Controller
{
    public function form()
    {
        $form = SignupForm::orderBy('id')->firstOrFail();

        return view('signup', compact('form'));
    }
}
