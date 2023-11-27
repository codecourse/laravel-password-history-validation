<?php

namespace App\Http\Controllers\Auth\Password;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Rules\NotFromPasswordHistory;

class PasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('auth.passwords.change');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'password' => [
                'required',
                new NotFromPasswordHistory($request->user(), 5)
            ]
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->withStatus('Your password was changed');
    }
}
