<x-guest-layout>
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    


    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    
    <div class="container">
        <div class="card rounded-3 text-black mx-auto" style="width: 70%;">
            <div class="card-body p-md-5 mx-md-4">
                <div class="mb-4 text-sm text-gray-600 text-center">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mx-auto" style="width: 50%;">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="form-control mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="text-center mt-4">
            <button class="btn btn-block fa-lg gradient-custom-3 mb-1 btn-login text-white" style="width: 50%;">
                    {{ __('Email Password Reset Link') }}
            </button>
        </div>
    </form>
            </div>
        </div>
    </div>
</x-guest-layout>
