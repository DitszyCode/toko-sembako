<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Handle contact form submission.
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        // Send email to owner
        Mail::to(config('mail.from.address'))
            ->send(new ContactMail(
                name:        $validated['name'],
                email:       $validated['email'],
                phone:       $validated['phone'] ?? null,
                subjectType: $validated['subject'] ?? null,
                msgBody:     $validated['message'],
            ));

        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim! Kami akan segera merespons dalam 1x24 jam.');
    }
}
