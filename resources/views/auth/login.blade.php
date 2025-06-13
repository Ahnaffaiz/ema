<x-guest-layout>
    <div class="text-center">
        <h5 class="font-medium text-gray-700 dark:text-gray-100">Welcome Back!</h5>
        <p class="mt-2 mb-4 text-gray-500 dark:text-gray-100/60">Sign in to continue to {{ config('app.name') }}.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form class="pt-2" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-4">
            <label class="block mb-2 font-medium text-gray-700 dark:text-gray-100" for="email">Email</label>
            <input type="email" name="email" class="w-full py-1.5 border-gray-50 rounded placeholder:text-13 bg-gray-50/30 dark:bg-zinc-700/50 dark:border-zinc-600 dark:text-gray-100 dark:placeholder:text-zinc-100/60 focus:ring focus:ring-violet-500/20 focus:border-violet-100 text-13" id="email" value="{{ old('email') }}" placeholder="Enter email" required autofocus>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="mb-3">
            <div class="flex">
                <div class="flex-grow-1">
                    <label class="block mb-2 font-medium text-gray-600 dark:text-gray-100" for="password">Password</label>
                </div>
            </div>

            <div class="flex">
                <input type="password" name="password" class="w-full py-1.5 border-gray-50 rounded ltr:rounded-r-none rtl:rounded-l-none bg-gray-50/30 placeholder:text-13 text-13 dark:bg-zinc-700/50 dark:border-zinc-600 dark:text-gray-100 dark:placeholder:text-zinc-100/60 focus:ring focus:ring-violet-500/20 focus:border-violet-100" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon" required>
                <button class="px-4 border rounded border-gray-50 bg-gray-50 ltr:rounded-l-none rtl:rounded-r-none ltr:border-l-0 rtl:border-r-0 dark:bg-zinc-700 dark:border-zinc-600 dark:text-gray-100" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="mb-6 row">
            <div class="col">
                <div>
                    <input type="checkbox" name="remember" class="w-4 h-4 mt-1 align-top transition duration-200 bg-white bg-center bg-no-repeat bg-contain border border-gray-300 rounded cursor-pointer focus:outline-none ltr:float-left rtl:float-right ltr:mr-2 rtl:ml-2 focus:ring-offset-0" id="remember_me">
                    <label class="font-medium text-gray-600 align-middle dark:text-gray-100" for="remember_me">
                        Remember me
                    </label>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <button class="w-full py-2 text-white border-transparent shadow-md btn bg-violet-500 w-100 waves-effect waves-light shadow-violet-200 dark:shadow-zinc-600" type="submit">Log In</button>
        </div>
    </form>

    @push('scripts')
    <script>
        // Password visibility toggle
        document.getElementById('password-addon').addEventListener('click', function() {
            var passwordInput = document.querySelector('input[name="password"]');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });
    </script>
    @endpush
</x-guest-layout>
