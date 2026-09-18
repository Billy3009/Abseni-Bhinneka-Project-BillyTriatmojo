<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function dashboard()
{
    return view('admin.dashboard',[
        'totalUser'=>User::count(),
        'pending'=>User::where('status','pending')->count(),
        'aktif'=>User::where('status','aktif')->count(),
        'ditolak'=>User::where('status','ditolak')->count(),
        'users'=>User::latest()->get(),
    ]);
}

public function users(Request $request)
{
    $query = User::query();

    if ($request->search) {
        $query->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('username', 'like', '%' . $request->search . '%');
    }

    if ($request->role) {
        $query->where('role', $request->role);
    }

    if ($request->status) {
        $query->where('status', $request->status);
    }

    $users = $query->latest()->paginate(10);

    return view('admin.users', compact('users'));
}

    public function approve($id)
    {
        User::findOrFail($id)->update([
            'status'=>'aktif'
        ]);

        return back()->with('success','Akun berhasil disetujui.');
    }

    public function reject($id)
    {
        User::findOrFail($id)->update([
            'status'=>'ditolak'
        ]);

        return back()->with('success','Akun berhasil ditolak.');
    }
}