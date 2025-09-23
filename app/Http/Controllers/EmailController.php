<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Spatie\Mjml\Mjml;

class EmailController extends Controller
{
    public function show(Email $email)
    {
        return view('emails.show', [
            'email_content' => Mjml::new()->toHtml(view('emails.templates.default', compact('email'))->render()),
            'email_content_plain' => view('emails.templates.default_PLAIN', compact('email'))->render(),

        ]);
    }
}
