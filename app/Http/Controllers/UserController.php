<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('pages.user.index', compact('users'));
    }

    public function show(Request $request)
    {
        $user = User::findOrFail($request->id);
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'success' => true,
                notyf()->position('y', 'top')->success('User berhasil dibuat'),
                'data' => $user
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' => true, notyf()->position('y', 'top')->error('User gagal dibuat. Silakan coba lagi.')]);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json([notyf()->position('y', 'top')->success('User berhasil dihapus')]);
        } catch (\Exception $e) {
            return response()->json([notyf()->position('y', 'top')->error('User gagal dihapus. Silakan coba lagi.')], 500);
        }
    }
}
