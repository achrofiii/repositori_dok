<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index()
    {
        $data = [
            'dosen' => User::role('dosen')->get(),
            'mahasiswa' => User::role('mahasiswa')->get(),
            'all' => User::all(),
        ];
        return view('cs.custommer-service', $data);
    }

    public function store(UserRequest $request)
    {
        // dd($request->all());
        $data = $request->validated();
        $base = strtolower(str_replace(' ', '', $data['name']));
        $username = $base;

        while (User::where('username', $username)->exists()) {
            $username = $base . rand(100, 999);
        }

        $data['username'] = $username;
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        $user->assignRole($request->role);

        return redirect()->route('custommer-service.index')->with('success', 'User berhasil ditambahkan');
    }


    public function update(UserRequest $request, User $custommer_service)
    {
        $data = $request->validated();
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $custommer_service->update($data);
        return redirect()->route('custommer-service.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $custommer_service)
    {
        $custommer_service->delete();
        return redirect()->route('custommer-service.index')->with('success', 'User berhasil dihapus'); 
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
            'role' => 'required|in:mahasiswa,dosen'
        ]);

        Excel::import(new UsersImport($request->role), $request->file('file'));

        return back()->with('success', 'Data berhasil diimpor.');
    }
}
