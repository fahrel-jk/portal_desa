<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class OperatorController extends Controller
{
    /**
     * Display a listing of the operators.
     */
    public function index(Request $request)
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        $operators = User::where('village_id', $village->id)
            ->where('role', 'perwakilan_desa')
            ->get();

        return view('desa.operators.index', compact('village', 'operators'));
    }

    /**
     * Show the form for creating a new operator.
     */
    public function create(Request $request)
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        return view('desa.operators.create', compact('village'));
    }

    /**
     * Store a newly created operator in storage.
     */
    public function store(Request $request)
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'perwakilan_desa',
            'village_id' => $village->id,
        ]);

        return redirect()->route('desa.operators.index')
            ->with('success', 'Operator tambahan berhasil ditambahkan.');
    }

    /**
     * Remove the specified operator from storage.
     */
    public function destroy(Request $request, User $operator)
    {
        $user = $request->user();
        $village = $user->village;

        abort_unless($village && $village->isPublished(), 403);
        abort_unless($operator->village_id === $village->id, 403);

        if ($operator->id === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $operator->delete();

        return redirect()->route('desa.operators.index')
            ->with('success', 'Operator berhasil dihapus.');
    }
}
