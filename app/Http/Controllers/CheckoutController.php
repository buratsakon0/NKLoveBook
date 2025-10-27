<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    // ฟังก์ชันสำหรับแสดงหน้า Checkout
    public function index()
    {
        return view('checkout.index');
    }

    // ฟังก์ชันสำหรับการ submit ข้อมูลใน Checkout
    public function submit(Request $request)
    {
        // ตรวจสอบข้อมูลที่กรอก
        $validatedData = $request->validate([
            'address' => 'required|string|max:255',
            // เพิ่มเงื่อนไขการตรวจสอบข้อมูลที่คุณต้องการ
        ]);

        // เก็บข้อมูลการชำระเงินและที่อยู่การจัดส่ง

        // ตัวอย่างการเก็บข้อมูลใน session
        session()->put('shipping_address', $validatedData['address']);

        // หากต้องการเปลี่ยนเส้นทางไปยังหน้าอื่น (เช่น หน้า Confirmation)
        return redirect()->route('confirmation'); // หรือหน้าอื่นที่คุณต้องการ
    }

      public function __construct()
    {
        $this->middleware('auth'); // ใช้ middleware เช็กว่า user login หรือไม่
    }

    public function index()
    {
        // หาก user login แล้ว ให้ไปที่หน้า checkout
        return view('checkout');
    }

    public function submit(Request $request)
    {
        // ทำการส่งข้อมูลการชำระเงิน หรือประมวลผลที่เกี่ยวกับการ checkout
    }
}

