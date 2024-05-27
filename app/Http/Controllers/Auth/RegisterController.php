<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'          => ['required', 'string', 'min:8', 'confirmed'],
            'username'          => ['required', 'string'],
            'mobile'            => ['required', 'string', 'max:20'],
            'image'             => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:5000'],
        ]);
    }

    protected function create(array $data)
    {
        // Handle the file upload
        $imageName = null;
        if (isset($data['image'])) {
            $image = $data['image'];
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move('public_path'('uploads/user_image'), $imageName); // Save the image to storage/app/public/uploads/user_image
        }

        return User::create([
            'name'              => $data['name'],
            'email'             => $data['email'],
            'password'          => Hash::make($data['password']),
            'username'          => $data['username'],
            'mobile'            => $data['mobile'],
            'image'             => $imageName,
        ]);
    }

    protected function registered(Request $request, $user)
    {
        return redirect('/login')->with('status', 'Registration successful! Please login.');
    }
}
