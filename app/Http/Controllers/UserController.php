<?php


namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request)
    {
        
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users',
            'username' => 'required|alpha|unique:users',
            'name' => 'nullable',
        ]);

      
        $user = User::create([
            'email' => $validatedData['email'],
            'username' => $validatedData['username'],
            'name' => $validatedData['name'],
        ]);
     

        return response()->json($user);
    }
    public function getUser(Request $request)
    {
        $user = $request->user();

        return response()->json($user);
    }
    public function updateUser(Request $request)
    {
        $user = $request->user();
     

        $validatedData = $request->validate([
            'username' => 'required|alpha|unique:users,username,'.$user->id,
            'name' => 'nullable',
        ]);

       
        $user->username = $validatedData['username'];
        $user->name = $validatedData['name'];
        $user->save();

      
        return response()->json($user);
    }
    public function deleteUser(Request $request)
    {
        $user = $request->user();

        
        $user->delete();

       
        return response()->json(['message' => 'User deleted successfully']);
    }
     

    //опреации над пользователями 
        public function edit(Request $request, $id)
    {
      
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'username' => 'required|alpha|unique:users,username,' . $id,
            'name' => 'nullable',
        ]);

      
        $user = User::findOrFail($id);

        $user->update([
            'email' => $validatedData['email'],
            'username' => $validatedData['username'],
            'name' => $validatedData['name'],
        ]);

    
        return response()->json(['message' => 'User updated successfully'], 200);
    }

    public function block($id)
    {
        $user = User::findOrFail($id);

        $user->update(['is_blocked' => true]);

        return response()->json(['message' => 'User blocked successfully'], 200);
    }

    public function unblock($id)
    {
        $user = User::findOrFail($id);

        $user->update(['is_blocked' => false]);

        return response()->json(['message' => 'User unblocked successfully'], 200);
    }
}