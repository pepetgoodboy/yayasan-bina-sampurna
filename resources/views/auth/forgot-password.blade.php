<x-guest-layout title="Ubah Kata Sandi">
    {{-- <div class="mb-4 text-sm text-gray-600 text-center">
        {{ __('Lupa Kata Sandi? Silahkan masukkan email yang terdaftar beserta pertanyaan dan jawaban keamanan anda.') }}
    </div> --}}

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Pertanyaan Keamanan --}}
        <div class="mt-4">
            <x-input-label for="id_pertanyaan" :value="__('Pertanyaan Keamanan')" />
            <select id="id_pertanyaan" name="id_pertanyaan"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                required>
                <option value="" disabled selected>Pilih Pertanyaan</option>
                @foreach ($pertanyaans as $pertanyaan)
                    <option value="{{ $pertanyaan->id }}">{{ $pertanyaan->pertanyaan }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('id_pertanyaan')" class="mt-2" />
        </div>

        {{-- Jawaban --}}
        <div class="mt-4">
            <x-input-label for="jawaban" :value="__('Jawaban Pertanyaan Keamanan')" />
            <x-text-input id="jawaban" class="block mt-1 w-full" type="text" name="jawaban" :value="old('jawaban')"
                required />
            <x-input-error :messages="$errors->get('jawaban')" class="mt-2" />
        </div>

        {{-- Kata Sandi Baru --}}
        <div class="mt-4">
            <x-input-label for="password" :value="__('Kata Sandi Baru')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Ubah Kata Sandi') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
