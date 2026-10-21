<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\EnquiryMail;
use App\Mail\ThanksMail;
use App\Models\Enquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Handle inbound enquiry form submission and dispatch notification emails.
     */
    public function sendmail(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'messages' => ['required_without:message', 'nullable', 'string'],
            'message' => ['required_without:messages', 'nullable', 'string'],
        ]);

        $messageContent = trim($request->input('messages') ?? $request->input('message') ?? '');

        // Save enquiry to database
        Enquiry::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'messages' => $messageContent,
        ]);

        // Destination admin email address with fallback
        $adminEmail = $this->contact?->email ?: config('mail.from.address', 'admin@intsource.com');

        try {
            // Send Enquiry Mail to Admin
            if (! empty($adminEmail)) {
                Mail::to($adminEmail)->send(
                    new EnquiryMail(
                        $validated['name'],
                        $validated['email'],
                        $validated['phone'],
                        $messageContent
                    )
                );
            }

            // Send Confirmation / Thank You Mail to User
            Mail::to($validated['email'])->send(
                new ThanksMail($validated['name'], $this->contact)
            );
        } catch (\Throwable $e) {
            Log::error('Failed to send enquiry emails: '.$e->getMessage(), [
                'exception' => $e,
                'email' => $validated['email'],
            ]);
        }

        $previousUrl = strtok(url()->previous(), '#');
        $path = parse_url($previousUrl, PHP_URL_PATH);
        if (empty($path) || $path === '') {
            $previousUrl .= '/';
        }

        return redirect($previousUrl.'#enquiry')->with('success', 'Thank you for reaching out! We have received your enquiry and will contact you shortly.');
    }
}
