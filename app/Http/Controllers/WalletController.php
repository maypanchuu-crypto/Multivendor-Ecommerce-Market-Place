<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Wallet;

class WalletController extends Controller
{
    // Wallet Account View ပြသပေးမည့် Method ( create / show )
    public function index()
    {
        $user = auth()->user();
        $wallet = $user->wallet; // User model relationship မှ wallet ရယူမည်

        return view('wallet.index', compact('wallet', 'user'));
    }

    // Wallet Account အသစ် ဖန်တီးပေးမည့် Method
    public function store(Request $request)
    {
        $user = auth()->user();

        // အကောင့်တစ်ခုရှိပြီးသားဆိုလျှင် ထပ်မံဆောက်မရအောင် တားဆီးမည်
        if ($user->wallet) {
            return redirect()->route('wallet.index')->with('status', 'Wallet account already exists.');
        }

        $request->validate([
            'wallet_password' => 'required|string|min:6|confirmed',
        ], [
            'wallet_password.required' => 'ကျေးဇူးပြု၍ Password ထည့်သွင်းပေးပါ။',
            'wallet_password.min' => 'Password သည် အနည်းဆုံး ၆ လုံး ရှိရပါမည်။',
            'wallet_password.confirmed' => 'Confirm Password မတူညီပါ။',
        ]);

        // Wallet အသစ်ဆောက်ပေးပြီး Default Balance 2,000,000 ထည့်ပေးမည်
        Wallet::create([
            'user_id' => $user->id,
            'balance' => 2000000.00,
            'wallet_password' => Hash::make($request->wallet_password),
        ]);

        return redirect()->route('wallet.index')->with('success', 'Wallet account created successfully with 2,000,000 MMK balance!');
    }

    // Update Form ပြသပေးမည့် View
    public function editPassword()
    {
        return view('wallet.edit-password');
    }

    // Wallet Password ပြောင်းလဲပေးမည်
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = auth()->user();
        $wallet = $user->wallet;

        if (!$wallet) {
            return back()->withErrors(['current_password' => 'Wallet account not found.']);
        }

        if (!Hash::check($request->current_password, $wallet->wallet_password)) {
            return back()->withErrors(['current_password' => 'Current Wallet Password is incorrect.']);
        }

        $wallet->update([
            'wallet_password' => Hash::make($request->new_password)
        ]);

        return back()->with('status', 'Wallet Password updated successfully.');
    }
}