<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the user profile page.
     */
    public function show()
    {
        $user = Auth::user();

        // Eager-load the doctor profile if user is a doctor
        if ($user->role === 'doctor') {
            $user->load('doctor');
        }

        return view('profile.profile', compact('user'));
    }

    /**
     * Update the core account settings (email + password).
     */
    public function updateAccount(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'min:8', 'confirmed'],
        ]);

        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Account settings updated successfully.');
    }

    /**
     * Update the patient-specific vital ledger fields.
     */
    public function updatePatientProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'in:male,female,other'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user->update($validated);

        return back()->with('success', 'Personal information updated successfully.');
    }

    /**
     * Update the patient-specific medical footprint fields.
     */
    public function updatePatientMedical(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'known_allergies' => ['nullable', 'string', 'max:2000'],
            'chronic_conditions' => ['nullable', 'string', 'max:2000'],
        ]);

        $user->update($validated);

        return back()->with('success', 'Medical information saved successfully.');
    }

    /**
     * Update the doctor-specific clinical credentials.
     */
    public function updateDoctorCredentials(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'license_number' => ['required', 'string', 'max:100'],
            'specialization' => ['required', 'string', 'max:255'],
            'year_of_commencement' => ['nullable', 'integer', 'min:1950', 'max:' . date('Y')],
        ]);

        $doctorData = [
            'license_number' => $validated['license_number'],
            'specialization' => $validated['specialization'],
        ];

        // Store year_of_commencement in the doctor table
        // (Will need a migration to add this column)

        $user->doctor()->updateOrCreate(
            ['user_id' => $user->id],
            $doctorData
        );

        return back()->with('success', 'Clinical credentials updated successfully.');
    }

    /**
     * Update the doctor-specific consultation settings.
     */
    public function updateDoctorConsultation(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'bio' => ['nullable', 'string', 'max:3000'],
            'consultation_location' => ['nullable', 'string', 'max:255'],
        ]);

        $user->doctor()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'bio' => $validated['bio'],
            ]
        );

        return back()->with('success', 'Consultation settings saved successfully.');
    }

    /**
     * Display the account settings page.
     */
    public function showAccountSettings()
    {
        $user = Auth::user();
        return view('profile.account-settings', compact('user'));
    }

    /**
     * Update user identity parameters (email + phone).
     */
    public function updateIdentity(Request $request)
    {
        $user = Auth::user();

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'regex:/^\+?[0-9\s\-]{9,20}$/'],
        ], [
            'phone.regex' => 'The phone number format is invalid. Please use only numbers, spaces, hyphens, and optional + prefix (9-20 characters).',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator, 'identity')->withInput();
        }

        $user->update([
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ]);

        return back()->with('success', 'Account identity parameters updated successfully.');
    }

    /**
     * Rotate user security credentials.
     */
    public function updateSecurity(Request $request)
    {
        $user = Auth::user();

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator, 'security');
        }

        $user->update([
            'password' => Hash::make($request->input('new_password')),
        ]);

        return back()->with('success', 'Security credentials updated successfully.');
    }

    /**
     * Revoke all other active sessions for the user.
     */
    public function revokeSessions(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'current_password' => ['required', 'current_password'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator, 'revoke');
        }

        Auth::logoutOtherDevices($request->input('current_password'));

        return back()->with('success', 'Other active device sessions revoked successfully.');
    }

    /**
     * Deactivate/delete the user account ledger.
     */
    public function deactivateAccount(Request $request)
    {
        $user = Auth::user();

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'confirm_deactivation' => ['required', 'accepted'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator, 'deactivate');
        }

        // Log out first to prevent Laravel SessionGuard from cycling the remember token and re-inserting the deleted user
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Cleanly delete the user profile (cascading handles child records)
        $user->delete();

        return redirect('/')->with('success', 'Your account ledger has been deactivated and removed.');
    }
}
