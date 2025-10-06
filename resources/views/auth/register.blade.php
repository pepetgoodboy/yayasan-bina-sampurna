<x-guest-layout title="Daftar">
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Kata Sandi')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Pertanyaan --}}
        <div class="mt-4">
            <x-input-label for="id_pertanyaan" :value="__('Pertanyaan Keamanan')" />
            <select id="id_pertanyaan" name="id_pertanyaan" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
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
            <x-text-input id="jawaban" class="block mt-1 w-full" type="text" name="jawaban" :value="old('jawaban')" required />
            <x-input-error :messages="$errors->get('jawaban')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Sudah Memiliki Akun?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
