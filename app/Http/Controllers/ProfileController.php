<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\DetailDosen;
use App\Models\DetailMahasiswa;
use App\Models\Fakultas;
use App\Models\Jurusan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();
        $isMahasiswa = $user->hasRole('mahasiswa');
        $isDosen = $user->hasRole('dosen');

        $detail = null;
        if ($isMahasiswa) {
            $detail = $user->detailMahasiswa ?? new DetailMahasiswa();
        } elseif ($isDosen) {
            $detail = $user->detailDosen ?? new DetailDosen();
        }

        return view('profile.edit', [
            'user'        => $user,
            'detail'      => $detail,
            'isMahasiswa' => $isMahasiswa,
            'isDosen'     => $isDosen,
            'fakultas'    => Fakultas::all(),
            'jurusans'    => $detail?->fakultas_id
                ? Jurusan::where('fakultas_id', $detail->fakultas_id)->get()
                : collect(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updateDetail(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasRole('mahasiswa')) {
            $request->validate([
                'fakultas_id' => 'nullable|exists:fakultas,id',
                'jurusan_id'  => 'nullable|exists:jurusans,id',
                'angkatan'    => 'nullable|string|max:10',
                'no_hp'       => 'nullable|string|max:20',
                'alamat'      => 'nullable|string',
            ]);

            DetailMahasiswa::updateOrCreate(
                ['user_id' => $user->id],
                $request->only(['fakultas_id', 'jurusan_id', 'angkatan', 'no_hp', 'alamat'])
            );
        } elseif ($user->hasRole('dosen')) {
            $request->validate([
                'fakultas_id'      => 'nullable|exists:fakultas,id',
                'jurusan_id'       => 'nullable|exists:jurusans,id',
                'bidang_keahlian'  => 'nullable|string|max:255',
                'no_hp'            => 'nullable|string|max:20',
                'alamat'           => 'nullable|string',
            ]);

            DetailDosen::updateOrCreate(
                ['user_id' => $user->id],
                $request->only(['fakultas_id', 'jurusan_id', 'bidang_keahlian', 'no_hp', 'alamat'])
            );
        }

        return Redirect::route('profile.edit')->with('status', 'detail-updated');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'min:8', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        return Redirect::route('profile.edit')->with('status', 'password-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
