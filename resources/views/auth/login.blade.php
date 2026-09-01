<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Header -->
    <div class="grid auto-rows-min grid-rows-[auto_auto] items-start gap-1.5 grid-cols-[1fr_auto] mb-6">
        <h1 class="leading-none font-semibold text-xl text-white">Login to your account</h1>
        <p class="text-sm text-white/80 row-start-2 col-start-1">Enter your email below to login to your account</p>
        <div class="col-start-2 row-span-2 row-start-1 self-start justify-self-end mt-0.5">
            <a href="{{ route('register') }}" class="text-sm text-white font-medium hover:underline underline-offset-4">Sign Up</a>
        </div>
    </div>

    <!-- Content -->
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="flex flex-col gap-5">
            <!-- Email Address -->
            <div class="grid gap-2">
                <label for="email" class="text-sm font-medium leading-none text-white">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="m@example.com"
                       class="flex h-10 w-full rounded-md border border-white/20 bg-white/10 px-3 py-2 text-sm text-white placeholder:text-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all backdrop-blur-md" />
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-300" />
            </div>

            <!-- Password -->
            <div class="grid gap-2">
                <div class="flex items-center justify-between">
                    <label for="password" class="text-sm font-medium leading-none text-white">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="inline-block text-sm text-white/80 underline-offset-4 hover:underline hover:text-white transition-colors">
                            Forgot your password?
                        </a>
                    @endif
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="flex h-10 w-full rounded-md border border-white/20 bg-white/10 px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all backdrop-blur-md" />
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-300" />
            </div>

            <!-- Footer Buttons -->
            <div class="flex flex-col gap-3 mt-2">
                <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-10 px-4 py-2 bg-black text-white hover:bg-black/90 transition-colors w-full shadow-lg">
                    Login
                </button>
                <button type="button" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-10 px-4 py-2 hover:bg-white/10 hover:text-white transition-colors w-full">
                    Login with Google
                </button>
            </div>
        </div>
    </form>
</x-guest-layout>
