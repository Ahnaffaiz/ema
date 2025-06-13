<x-guest-layout>
    <div class="text-center">
        <h5 class="font-medium text-gray-700 dark:text-gray-100">Register Account</h5>
        <p class="mt-1 text-gray-500 dark:text-zinc-100/60">Get your free {{ config('app.name') }} account now.</p>
    </div>

    <form class="pt-2 mt-4" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-4">
            <label class="block mb-2 font-medium text-gray-700 dark:text-gray-100" for="name">Name</label>
            <input type="text" name="name" class="w-full py-1.5 border-gray-100 rounded placeholder:text-13 bg-gray-50/30 dark:bg-zinc-700/50 dark:border-zinc-600 dark:text-gray-100 dark:placeholder:text-zinc-100/60 focus:ring focus:ring-violet-500/20 focus:border-violet-100 text-13" id="name" value="{{ old('name') }}" placeholder="Enter name" required autofocus>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div class="mb-4">
            <label class="block mb-2 font-medium text-gray-700 dark:text-gray-100" for="email">Email</label>
            <input type="email" name="email" class="w-full py-1.5 border-gray-100 rounded placeholder:text-13 bg-gray-50/30 dark:bg-zinc-700/50 dark:border-zinc-600 dark:text-gray-100 dark:placeholder:text-zinc-100/60 focus:ring focus:ring-violet-500/20 focus:border-violet-100 text-13" id="email" value="{{ old('email') }}" placeholder="Enter Email" required>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="mb-4">
            <div>
                <div class="flex-grow-1">
                    <label class="block mb-2 font-medium text-gray-700 dark:text-gray-100" for="password">Password</label>
                </div>
            </div>

            <div class="flex">
                <input type="password" name="password" class="w-full py-1.5 border-gray-100 rounded placeholder:text-13 bg-gray-50/30 dark:bg-zinc-700/50 dark:border-zinc-600 dark:text-gray-100 dark:placeholder:text-zinc-100/60 focus:ring focus:ring-violet-500/20 focus:border-violet-100 text-13" placeholder="Enter password" aria-label="Password" required>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="mb-4">
            <div>
                <div class="flex-grow-1">
                    <label class="block mb-2 font-medium text-gray-700 dark:text-gray-100" for="password_confirmation">Confirm Password</label>
                </div>
            </div>

            <div class="flex">
                <input type="password" name="password_confirmation" class="w-full py-1.5 border-gray-100 rounded placeholder:text-13 bg-gray-50/30 dark:bg-zinc-700/50 dark:border-zinc-600 dark:text-gray-100 dark:placeholder:text-zinc-100/60 focus:ring focus:ring-violet-500/20 focus:border-violet-100 text-13" placeholder="Confirm password" aria-label="Password Confirmation" required>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        <div class="mb-6 row">
            <div class="col">
                <div>
                    <p class="text-gray-700 dark:text-zinc-100/60">By registering you agree to the {{ config('app.name') }} <a href="#" class="text-violet-500">Terms of Use</a></p>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <button class="btn border-transparent bg-violet-500 w-full py-2.5 text-white w-100 waves-effect waves-light shadow-md shadow-violet-200 dark:shadow-zinc-600" type="submit">Register</button>
        </div>
    </form>

    <div class="pt-2 mt-4 text-center">
        <div>
            <h6 class="mb-3 font-medium text-gray-500 text-14 dark:text-zinc-100/60">- Sign in with -</h6>
        </div>

        <div class="flex justify-center gap-3">
            <a href="" class="w-8 h-8 leading-8 rounded-full bg-violet-500">
                <i class="text-sm text-white mdi mdi-facebook"></i>
            </a>
            <a href="" class="w-8 h-8 leading-8 rounded-full bg-sky-500">
                <i class="text-sm text-white mdi mdi-twitter"></i>
            </a>
            <a href="" class="w-8 h-8 leading-8 bg-red-400 rounded-full">
                <i class="text-sm text-white mdi mdi-google"></i>
            </a>
        </div>
    </div>

    <div class="mt-12 text-center">
        <p class="text-gray-500 dark:text-zinc-100/60">Already have an account? <a href="{{ route('login') }}" class="font-semibold text-violet-500">Login</a></p>
    </div>
</x-guest-layout>
