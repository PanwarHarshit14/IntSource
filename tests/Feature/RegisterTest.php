<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Contact;
use App\Models\Register;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Honeypot\ProtectAgainstSpam;
use Tests\TestCase;

class RegisterTest extends TestCase
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

    public function test_student_can_submit_registration_via_web(): void
    {
        $payload = [
            'course' => 'MERN Stack Web Development',
            'student_name' => 'John Doe',
            'father_name' => 'Robert Doe',
            'gender' => 'Male',
            'dob' => '2001-08-15',
            'mobile' => '+91 98765 43210',
            'email' => 'john.doe@example.com',
        ];

        $response = $this->withoutMiddleware(ProtectAgainstSpam::class)
            ->post(route('register.post'), $payload);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('registers', [
            'student_name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'course' => 'MERN Stack Web Development',
            'gender' => 'Male',
        ]);
    }

    public function test_student_can_submit_registration_via_ajax_json(): void
    {
        $payload = [
            'course' => 'Python & Django Full Stack',
            'student_name' => 'Jane Smith',
            'father_name' => 'David Smith',
            'gender' => 'female',
            'dob' => '2000-04-20',
            'mobile' => '+91 98765 11111',
            'email' => 'jane.smith@example.com',
        ];

        $response = $this->withoutMiddleware(ProtectAgainstSpam::class)
            ->postJson(route('register.post'), $payload);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
            ]);

        $this->assertDatabaseHas('registers', [
            'student_name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'gender' => 'Female',
        ]);
    }

    public function test_registration_fails_with_validation_errors(): void
    {
        $response = $this->withoutMiddleware(ProtectAgainstSpam::class)
            ->postJson(route('register.post'), []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'course',
                'student_name',
                'father_name',
                'gender',
                'dob',
                'mobile',
                'email',
            ]);
    }

    protected function createAdmin(): Admin
    {
        $admin = new Admin;
        $admin->name = 'Super Admin';
        $admin->username = 'admin';
        $admin->email = 'admin@test.com';
        $admin->password = bcrypt('password');
        $admin->save();

        return $admin;
    }

    public function test_admin_can_view_registrations_list(): void
    {
        $admin = $this->createAdmin();

        Register::factory()->create([
            'student_name' => 'Sarah Connor',
            'course' => 'AI, Machine Learning & Data Science',
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->get(route('admin.register.index'));

        $response->assertStatus(200);
        $response->assertSee('Student Registrations');
        $response->assertSee('Sarah Connor');
        $response->assertSee('AI, Machine Learning & Data Science');
    }

    public function test_admin_can_delete_registration(): void
    {
        $admin = $this->createAdmin();

        $registration = Register::factory()->create([
            'student_name' => 'To Be Deleted',
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->delete(route('admin.register.destroy', $registration));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('registers', [
            'id' => $registration->id,
        ]);
    }

    public function test_admin_can_bulk_delete_registrations(): void
    {
        $admin = $this->createAdmin();

        $reg1 = Register::factory()->create();
        $reg2 = Register::factory()->create();

        $response = $this->actingAs($admin, 'admin')
            ->post(route('admin.register.bulk-delete'), [
                'delIds' => [$reg1->id, $reg2->id],
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('registers', ['id' => $reg1->id]);
        $this->assertDatabaseMissing('registers', ['id' => $reg2->id]);
    }

    public function test_admin_can_view_student_certificate(): void
    {
        $admin = $this->createAdmin();

        $registration = Register::factory()->create([
            'student_name' => 'Alexander Wright',
            'course' => 'Cloud Computing & DevOps',
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->get(route('admin.register.certificate', $registration));

        $response->assertStatus(200);
        $response->assertSee('Alexander Wright');
        $response->assertSee('Cloud Computing &amp; DevOps', false);
        $response->assertSee('Print Certificate');
    }

    public function test_admin_can_view_multiple_selected_certificates(): void
    {
        $admin = $this->createAdmin();

        $reg1 = Register::factory()->create([
            'student_name' => 'First Student',
            'course' => 'MERN Stack Web Development',
        ]);

        $reg2 = Register::factory()->create([
            'student_name' => 'Second Student',
            'course' => 'Python & Django Full Stack',
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->get(route('admin.register.certificate').'?ids='.$reg1->id.','.$reg2->id);

        $response->assertStatus(200);
        $response->assertSee('First Student');
        $response->assertSee('Second Student');
        $response->assertSee('2 Student Certificates Selected');
        $response->assertSee('Print All Certificates (2)');
    }

    public function test_guest_cannot_view_student_certificate(): void
    {
        $registration = Register::factory()->create();

        $response = $this->get(route('admin.register.certificate', $registration));

        $response->assertRedirect(route('admin.login'));
    }
}
