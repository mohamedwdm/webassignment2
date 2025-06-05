<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class RegisterController extends Controller
{
    // Show the registration form
    public function showForm()
    {
        return view('register');
    }

    // Handle form submission
    public function register(Request $request)
    {
        // Validate form input
        $request->validate([
            'full_name' => 'required|string|max:255',
            'user_name' => 'required|string|max:255|unique:users,user_name',
            'phone' => 'required|string|max:20',
            'whatsapp' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => [
                'required',
                'string',
                'confirmed' 
            ],
            'user_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle image upload
        $filename = null;
        if ($request->hasFile('user_image')) {
            $file = $request->file('user_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/user_images', $filename);
        }

        // Store the user in the database
        User::create([
            'full_name' => $request->full_name,
            'user_name' => $request->user_name,
            'phone' => $request->phone,
            'whatsapp' => $request->whatsapp,
            'address' => $request->address,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'user_image' => $filename,
        ]);

        return redirect()->back()->with('success', 'Insertion performed successfully');
    }

    // AJAX: Check if username exists
    public function checkUsername(Request $request)
    {
        $exists = User::where('user_name', $request->user_name)->exists();
        return response()->json(['exists' => $exists]);
    }
}

