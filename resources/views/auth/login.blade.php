<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
<div class="user-voltar">
    <a href="{{ route('site.home') }}" class="btn">Voltar</a>
</div>
<div class="login-container">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <h1>login</h1>
        <label for="username">Email:</label>
        <input type="text" id="username" name="email" :value="old('email')" required autofocus autocomplete="username">
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required autocomplete="current-password">
        <x-primary-button class="">
            
            {{ __('Entrar') }}
        </x-primary-button>
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('register') }}">
                Cadastre-se
            </a>
        </div>
    </form>
</div>
<footer>
    <p>&copy; 2023 - Todos os direitos reservados</p>
</footer>



<!-- Remember Me -->
<!-- <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
            @endif

            <x-primary-button class="ml-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div> -->