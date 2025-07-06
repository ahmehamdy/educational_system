<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Student;
use App\Models\Instructor;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Notifications\AccountApprovalNotification;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function getPendingUsers()
    {
        if (Auth::user()->type !== 'admin') {
            return response()->json(['message' => 'Unauthorized. Only admins can approve users.'], 403);
        }

        $users = User::where('status', 'pending')->get();
        return response()->json($users);
    }

    public function approveUser($id)
    {
        if (Auth::user()->type !== 'admin') {
            return response()->json(['message' => 'Unauthorized. Only admins can approve users.'], 403);
        }

        $user = User::findOrFail($id);
        $user->status = 'approved';
        $user->save();

        if ($user->type === 'student' && !$user->student) {
            Student::create([
                'user_id' => $user->id,
                'level_id' => request()->level_id
            ]);
        }

        if ($user->type === 'instructor' && !$user->instructor) {
            Instructor::create(['user_id' => $user->id]);
        }
        if ($user->type === 'admin' && !$user->admin) {
            Admin::create(['user_id' => $user->id]);
        }

        $user->notify(new AccountApprovalNotification('approved'));

        return response()->json(['message' => 'User approved and added to the system.']);
    }


    public function rejectUser($id)
    {
        if (auth()->user()->type !== 'admin') {
            return response()->json(['message' => 'Unauthorized. Only admins can reject users.'], 403);
        }

        $user = User::findOrFail($id);
        $user->status = 'rejected';
        $user->save();
        $user->notify(new AccountApprovalNotification('rejected'));
        return response()->json(['message' => 'User rejected.']);
    }
}
