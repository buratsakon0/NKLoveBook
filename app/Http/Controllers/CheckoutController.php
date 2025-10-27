<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        //  ตรวจสอบว่าผู้ใช้ล็อกอินหรือยัง
        if (!Auth::check()) {
            // ถ้ายังไม่ login → ส่งกลับไปหน้า login
            return redirect()->route('login')
                ->with('error', 'กรุณาเข้าสู่ระบบก่อนทำการชำระเงิน');
        }

        //  ถ้า login แล้ว → แสดงหน้า checkout (shipping)
        return view('checkout');
    }
}
