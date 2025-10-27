@extends('layouts.app')

@section('content')
<section class="py-10 bg-gray-50">
  <div class="max-w-6xl mx-auto bg-white rounded-md shadow-md border border-gray-200">
    <div class="bg-gradient-to-r from-pink-100 via-blue-50 to-green-50 py-6">
      <div class="flex justify-center items-center space-x-12 text-center text-sm font-medium text-indigo-900">
        <div>
          <div class="mx-auto w-8 h-8 flex items-center justify-center rounded-full border-2 border-indigo-900 text-indigo-900 font-semibold">1</div>
          <p class="mt-1 text-gray-700">Your Cart</p>
        </div>
        <div class="w-12 h-[1px] bg-indigo-300"></div>
        <div>
          <div class="mx-auto w-8 h-8 flex items-center justify-center rounded-full border-2 border-indigo-900 text-indigo-900 font-semibold">2</div>
          <p class="mt-1 text-gray-700">Shipping</p>
        </div>
        <div class="w-12 h-[1px] bg-indigo-300"></div>
        <div>
          <div class="mx-auto w-8 h-8 flex items-center justify-center rounded-full border-2 border-indigo-900 bg-indigo-900 text-white font-semibold">3</div>
          <p class="mt-1 text-indigo-900 font-semibold">Payment</p>
        </div>
        <div class="w-12 h-[1px] bg-indigo-300"></div>
        <div>
          <div class="mx-auto w-8 h-8 flex items-center justify-center rounded-full border-2 border-indigo-300 text-indigo-300 font-semibold">4</div>
          <p class="mt-1 text-gray-400">Complete</p>
        </div>
      </div>
    </div>

    <div class="p-10 space-y-10">
      <div class="border border-indigo-200 rounded-lg p-6 bg-white">
        <div class="flex items-start justify-between">
          <div class="text-gray-700 text-base leading-relaxed">
            <p class="font-semibold text-indigo-900">
              Address:
              @if ($address)
                {{ $user->Fname }} {{ $user->Lname }} | (+66) {{ $user->Phone ?? '—' }}
              @else
                <span class="text-red-500 ml-1">กรุณาเพิ่มที่อยู่สำหรับจัดส่ง</span>
              @endif
            </p>
            @if ($address)
              <p class="mt-2">{{ $address->AddressLine }}</p>
              <p>{{ $address->Subdistrict }}, {{ $address->District }}, {{ $address->Province }} {{ $address->PostalCode }}</p>
            @endif
          </div>
          <a href="{{ route('checkout.edit') }}" class="text-indigo-600 font-semibold hover:underline">Edit</a>
        </div>
      </div>

      <div class="border border-indigo-200 rounded-lg bg-white">
        <div class="divide-y divide-indigo-100">
          @foreach ($cartItems as $item)
            <div class="flex items-center gap-4 px-6 py-4">
              <img
                src="{{ $item->book->cover_image ? (filter_var($item->book->cover_image, FILTER_VALIDATE_URL) ? $item->book->cover_image : asset('images/' . ltrim($item->book->cover_image, '/'))) : asset('images/default-book.jpg') }}"
                alt="{{ $item->book->BookName }}"
                class="w-20 h-28 object-cover rounded-lg border border-indigo-100 shadow-sm"
              >
              <div class="flex-1">
                <p class="text-indigo-900 font-semibold uppercase tracking-wide">{{ $item->book->BookName }}</p>
                <p class="text-sm text-gray-500 uppercase tracking-widest">
                  {{ $item->book->author?->AuthorName ?? 'UNKNOWN AUTHOR' }}
                </p>
              </div>
              <div class="text-right">
                <p class="text-sm text-gray-500">x{{ $item->Quantity }}</p>
                <p class="text-base font-semibold text-indigo-900">฿{{ number_format($item->book->Price * $item->Quantity, 2) }}</p>
              </div>
            </div>
          @endforeach
        </div>

        <div class="px-6 py-6 space-y-2">
          <div class="flex justify-between text-sm text-gray-600">
            <span>Order Value</span>
            <span>฿{{ number_format($orderValue, 2) }}</span>
          </div>
          <div class="flex justify-between text-sm text-gray-600">
            <span>Delivery</span>
            <span class="text-green-500 font-semibold">{{ $deliveryFee === 0 ? 'FREE' : '฿' . number_format($deliveryFee, 2) }}</span>
          </div>
          <div class="flex justify-between items-center pt-4 border-t border-indigo-100 text-lg font-semibold text-indigo-900">
            <span>Total</span>
            <span>฿{{ number_format($total, 2) }}</span>
          </div>
        </div>

        <div class="px-6 pb-6">
          @if ($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-700">
              <ul class="list-disc pl-6 space-y-1">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          @if (session('success'))
            <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700">
              {{ session('success') }}
            </div>
          @endif

          <form action="{{ route('checkout.payment.process') }}" method="POST" class="flex flex-col gap-6" id="payment-form">
            @csrf

            <div class="rounded-2xl border border-indigo-100 bg-gradient-to-br from-indigo-50 via-white to-indigo-50 p-6 shadow-sm">
              <h3 class="text-lg font-semibold text-indigo-900 uppercase tracking-wide mb-4">Payment Method</h3>
              <div class="grid gap-4 md:grid-cols-[repeat(4,minmax(0,1fr))] lg:grid-cols-[minmax(0,1.2fr),minmax(0,1.8fr),minmax(0,1.1fr),minmax(0,0.9fr)]">
                <div class="md:col-span-2 lg:col-span-1">
                  <label for="card_type" class="block text-sm font-medium text-gray-700 uppercase tracking-wide">Card Type</label>
                  <select
                    id="card_type"
                    name="card_type"
                    class="mt-2 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-700 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100"
                    required
                  >
                    <option value="visa" @selected(old('card_type') === 'visa')>Visa</option>
                    <option value="mastercard" @selected(old('card_type') === 'mastercard')>MasterCard</option>
                  </select>
                </div>
                <div class="md:col-span-2 lg:col-span-2">
                  <label for="card_number" class="block text-sm font-medium text-gray-700 uppercase tracking-wide">Card Number</label>
                  <input
                    type="text"
                    id="card_number"
                    name="card_number"
                    value="{{ old('card_number') }}"
                    maxlength="25"
                    class="mt-2 w-full rounded-md border border-gray-300 px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-200 transition"
                    placeholder="xxxx xxxx xxxx xxxx"
                    required
                  >
                  <p data-error-for="card_number" class="mt-1 text-xs text-red-500 hidden"></p>
                </div>

                <div class="lg:col-span-1">
                  <label for="expiration" class="block text-sm font-medium text-gray-700 uppercase tracking-wide">Expiration</label>
                  <input
                    type="text"
                    id="expiration"
                    name="expiration"
                    value="{{ old('expiration') }}"
                    class="mt-2 w-full rounded-md border border-gray-300 px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-200 transition"
                    placeholder="MM/YY"
                    required
                    oninput="validateExpiration(this)"
                  >
                  <p class="mt-1 text-xs text-gray-500">Format: MM/YY</p>
                  <p data-error-for="expiration" class="mt-1 text-xs text-red-500 hidden"></p>
                </div>

                <div class="lg:col-span-1">
                  <label for="security_code" class="block text-sm font-medium text-gray-700 uppercase tracking-wide">Security Code</label>
                  <input
                    type="text"
                    id="security_code"
                    name="security_code"
                    value="{{ old('security_code') }}"
                    maxlength="4"
                    class="mt-2 w-full rounded-md border border-gray-300 px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-200 transition"
                    placeholder="CVV"
                    required
                  >
                  <p data-error-for="security_code" class="mt-1 text-xs text-red-500 hidden"></p>
                </div>
              </div>
            </div>

            <button type="submit"
              class="inline-flex items-center justify-center self-end rounded-md bg-orange-500 px-6 py-3 text-white text-sm font-semibold uppercase tracking-wide shadow hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-300 transition">
              Checkout
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  const expirationInput = document.getElementById('expiration');
  const cardNumberInput = document.getElementById('card_number');
  const securityCodeInput = document.getElementById('security_code');

  function getErrorElement(input) {
    return document.querySelector(`[data-error-for="${input.id}"]`);
  }

  function markInvalid(input, message) {
    input.classList.add('border-red-500', 'focus:ring-red-100', 'focus:border-red-500');
    input.classList.remove('border-gray-300');
    const errorEl = getErrorElement(input);
    if (errorEl) {
      errorEl.textContent = message || '';
      errorEl.classList.remove('hidden');
    }
  }

  function clearInvalid(input) {
    input.classList.remove('border-red-500', 'focus:ring-red-100', 'focus:border-red-500');
    input.classList.add('border-gray-300');
    const errorEl = getErrorElement(input);
    if (errorEl) {
      errorEl.textContent = '';
      errorEl.classList.add('hidden');
    }
  }

  function validateExpiration(input) {
    const value = input.value.trim();
    const pattern = /^(0[1-9]|1[0-2])\/\d{2}$/;
    if (!pattern.test(value)) {
      markInvalid(input, 'รูปแบบต้องเป็น MM/YY');
      return false;
    }

    const [monthStr, yearStr] = value.split('/');
    const month = parseInt(monthStr, 10);
    const year = 2000 + parseInt(yearStr, 10);
    const now = new Date();
    const currentYear = now.getFullYear();
    const currentMonth = now.getMonth() + 1;

    if (year < currentYear || (year === currentYear && month < currentMonth)) {
      markInvalid(input, 'วันหมดอายุของบัตรต้องอยู่ในอนาคต');
      return false;
    }

    clearInvalid(input);
    return true;
  }

  function validateCardNumber(input) {
    const digits = input.value.replace(/\D/g, '');
    if (digits.length < 12) {
      markInvalid(input, 'หมายเลขบัตรไม่ถูกต้อง');
      return false;
    }

    clearInvalid(input);
    return true;
  }

  function validateSecurityCode(input) {
    const digits = input.value.replace(/\D/g, '');
    if (digits.length < 3 || digits.length > 4) {
      markInvalid(input, 'รหัสความปลอดภัยไม่ถูกต้อง');
      return false;
    }

    clearInvalid(input);
    return true;
  }

  if (expirationInput) {
    expirationInput.addEventListener('input', () => validateExpiration(expirationInput));
  }

  if (cardNumberInput) {
    cardNumberInput.addEventListener('input', () => validateCardNumber(cardNumberInput));
  }

  if (securityCodeInput) {
    securityCodeInput.addEventListener('input', () => validateSecurityCode(securityCodeInput));
  }

  const paymentForm = document.getElementById('payment-form');
  if (paymentForm) {
    paymentForm.addEventListener('submit', (event) => {
      let valid = true;
      if (cardNumberInput && !validateCardNumber(cardNumberInput)) {
        valid = false;
      }
      if (expirationInput && !validateExpiration(expirationInput)) {
        valid = false;
      }
      if (securityCodeInput && !validateSecurityCode(securityCodeInput)) {
        valid = false;
      }

      if (!valid) {
        event.preventDefault();
      }
    });
  }
</script>
@endsection
