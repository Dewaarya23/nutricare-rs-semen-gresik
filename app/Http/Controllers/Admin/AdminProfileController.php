<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AdminProfileController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        if ($request->hasFile('photo')) {

            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $path = $request->file('photo')->store('profile', 'public');

            $user->photo = $path;
            $user->save();
        }

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function delete()
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->photo = null;
        $user->save();

        return back()->with('success', 'Foto profil berhasil dihapus.');
    }

    public function editProfile()
{
    $user = Auth::user();
    return view('admin.profile-form', compact('user'));
}

public function updateProfile(Request $request)
{
    $request->validate([
        'berat_badan' => 'required|numeric|min:1',
        'tinggi_badan' => 'required|numeric|min:1',
        'jenis_kelamin' => 'required|in:L,P',
    ]);

    $user = User::find(Auth::id());

    $user->update([
        'berat_badan' => $request->berat_badan,
        'tinggi_badan' => $request->tinggi_badan,
        'jenis_kelamin' => $request->jenis_kelamin,
    ]);

    return redirect()->route('dashboard.admin')
        ->with('success', 'Profil berhasil diperbarui.');
}


}
