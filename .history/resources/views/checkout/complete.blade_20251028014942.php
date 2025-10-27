@extends('layouts.app')

@section('content')
<section class="min-h-[70vh] flex items-center justify-center bg-gray-50 px-4 py-16">
  <div class="max-w-xl w-full bg-white rounded-3xl shadow-lg border border-gray-200 px-10 py-12 text-center">
    <div class="mx-auto mb-8 flex h-24 w-24 items-center justify-center rounded-full bg-emerald-100 text-emerald-500">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </div>

    <h1 class="text-3xl font-semibold text-emerald-600">Thank You!</h1>
    <p class="mt-2 text-gray-600">Payment completed successfully.</p>
    <p class="mt-1 text-sm text-gray-400">
      You&apos;ll be redirected to the home page shortly. If not, use the button below.
    </p>

    <a href="{{ route('home') }}"
       class="mt-8 inline-flex items-center justify-center rounded-full bg-emerald-500 px-8 py-3 text-white font-medium shadow hover:bg-emerald-600 transition">
      Home
    </a>
  </div>
</section>

<script>
  setTimeout(() => {
    window.location.href = "{{ route('home') }}";
  }, 5000);
</script>
@endsection
