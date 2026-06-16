<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the profile edit form.
     */
    public function edit()
    {
        $user = Auth::user();

        $orderCount = Order::where('user_id', $user->id)->count();
        $totalSpent = Order::where('user_id', $user->id)
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');
        $orders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('customer.profile', compact('user', 'orderCount', 'totalSpent', 'orders'));
    }

    /**
     * Update the user profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update the user password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => ['required', 'string', 'min:8', 'confirmed', Password::defaults()],
        ]);

        $user = Auth::user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Password saat ini tidak cocok.'])
                ->withInput();
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->back()->with('password_success', 'Password berhasil diperbarui.');
    }

    /**
     * Upload user avatar.
     */
    public function uploadAvatar(Request $request)
    {
        $validated = $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Delete old avatar if exists
        $oldPath = public_path('uploads/avatars/' . $user->avatar);
        if ($user->avatar && file_exists($oldPath)) {
            unlink($oldPath);
        }

        // Store in public/uploads/avatars/
        $avatar = $validated['avatar'];
        $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
        $avatar->move(public_path('uploads/avatars'), $avatarName);

        $user->update(['avatar' => $avatarName]);

        return redirect()->back()->with('success', 'Avatar berhasil diupload.');
    }

    /**
     * Delete user account.
     */
    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'delete_confirm' => 'required|string',
            'password' => 'required|string',
        ]);

        if (strtoupper($validated['delete_confirm']) !== 'HAPUS') {
            return redirect()->back()
                ->withErrors(['delete_confirm' => 'Ketik HAPUS untuk konfirmasi.'])
                ->withInput();
        }

        $user = Auth::user();

        if (!Hash::check($validated['password'], $user->password)) {
            return redirect()->back()
                ->withErrors(['password' => 'Password tidak cocok.'])
                ->withInput();
        }

        Auth::logout();
        $user->delete();

        return redirect('/')->with('success', 'Akun Anda telah dihapus.');
    }
}
