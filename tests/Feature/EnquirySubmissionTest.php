<?php

namespace Tests\Feature;

use App\Mail\EnquiryMail;
use App\Mail\ThanksMail;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Spatie\Honeypot\ProtectAgainstSpam;
use Tests\TestCase;

class EnquirySubmissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Contact::create([
            'name' => 'IntSource Test',
            'email' => 'admin@intsource.com',
            'phones' => ['+1 (800) 555-0199'],
            'address' => 'San Francisco, CA & Remote Worldwide',
        ]);
    }

    public function test_contact_section_is_rendered_on_homepage(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Send an enquiry');
        $response->assertSee('name="messages"', false);
    }

    public function test_enquiry_form_submits_successfully_and_saves_to_database(): void
    {
        Mail::fake();

        $payload = [
            'name' => 'Alice Developer',
            'email' => 'alice@example.com',
            'phone' => '+15551234567',
            'messages' => 'Looking to build a modern web application.',
        ];

        $response = $this->withoutMiddleware(ProtectAgainstSpam::class)
            ->from('/')
            ->post(route('enquiry.mail'), $payload);

        $response->assertRedirect('/#enquiry');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('enquiries', [
            'name' => 'Alice Developer',
            'email' => 'alice@example.com',
            'phone' => '+15551234567',
            'messages' => 'Looking to build a modern web application.',
        ]);

        Mail::assertSent(EnquiryMail::class, function ($mail) {
            return $mail->name === 'Alice Developer'
                && $mail->email === 'alice@example.com';
        });

        Mail::assertSent(ThanksMail::class, function ($mail) {
            return $mail->name === 'Alice Developer'
                && $mail->hasTo('alice@example.com');
        });
    }

    public function test_enquiry_form_validates_required_fields(): void
    {
        Mail::fake();

        $response = $this->withoutMiddleware(ProtectAgainstSpam::class)
            ->from('/')
            ->post(route('enquiry.mail'), []);

        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['name', 'email', 'phone', 'messages']);

        Mail::assertNothingSent();
    }

    public function test_enquiry_form_accepts_message_parameter(): void
    {
        Mail::fake();

        $payload = [
            'name' => 'Bob Test',
            'email' => 'bob@example.com',
            'phone' => '+15559876543',
            'message' => 'Alternative field name for message test.',
        ];

        $response = $this->withoutMiddleware(ProtectAgainstSpam::class)
            ->from('/')
            ->post(route('enquiry.mail'), $payload);

        $response->assertRedirect('/#enquiry');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('enquiries', [
            'name' => 'Bob Test',
            'email' => 'bob@example.com',
            'messages' => 'Alternative field name for message test.',
        ]);
    }
}
