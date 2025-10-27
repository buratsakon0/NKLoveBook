<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class ShippingController extends Controller
{
    // ฟังก์ชันสำหรับแสดงหน้า Checkout
    public function showShippingForm()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $address = Address::where('UserID', $user->getKey())->first();

        return view('checkout.index', compact('address', 'user'));
    }

    // ฟังก์ชันแก้ไขที่อยู่การจัดส่ง
    public function editShippingForm()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $address = Address::where('UserID', $user->getKey())->first();

        return view('checkout.edit', compact('address', 'user'));
    }

    // ฟังก์ชันบันทึกที่อยู่การจัดส่ง
    public function saveShippingAddress(Request $request)
    {
        // ตรวจสอบข้อมูลที่กรอก
        $validatedData = $request->validate([
            'province' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'subdistrict' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'address_line' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'กรุณาเข้าสู่ระบบเพื่อบันทึกที่อยู่จัดส่ง');
        }

        Address::updateOrCreate(
            ['UserID' => $user->getKey()],
            [
                'Province' => $validatedData['province'],
                'District' => $validatedData['district'],
                'Subdistrict' => $validatedData['subdistrict'],
                'PostalCode' => $validatedData['postal_code'],
                'AddressLine' => $validatedData['address_line'],
            ]
        );

        return redirect()->route('checkout')->with('success', 'บันทึกที่อยู่จัดส่งเรียบร้อยแล้ว');
    }
}
