<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShippingController extends Controller
{
    // ฟังก์ชันสำหรับแสดงหน้า Checkout
    public function showShippingForm()
    {
        return view('checkout.index');
    }

    // ฟังก์ชันแก้ไขที่อยู่การจัดส่ง
    public function editShippingForm()
    {
        return view('checkout.edit');
    }

    // ฟังก์ชันบันทึกที่อยู่การจัดส่ง
    public function saveShippingAddress(Request $request)
    {
        // ตรวจสอบข้อมูลที่กรอก
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        // เก็บข้อมูลใน session หรือฐานข้อมูล
        session()->put('shipping_address', $validatedData);

        // เปลี่ยนเส้นทางไปยังหน้าถัดไป
        return redirect()->route('checkout');
    }
}