<x-auth-layout>

    <h4 class="mb-3 f-w-400">Sign In</h4>
    <hr>
        <form method="POST" action="/authenticateUser">
            @csrf
            <div class="form-group mb-3">
                <input name="email" type="text" class="form-control" id="Email" placeholder="Email address">

                @error('email')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror

            </div>
            <div class="form-group mb-4">
                <input name="password" type="password" class="form-control" id="Password" placeholder="Password">

                @error('password')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror

            </div>
            <div class="custom-control custom-checkbox text-left mb-4 mt-2">
                <input type="checkbox" class="custom-control-input" id="customCheck1">
                <label class="custom-control-label" for="customCheck1">Save credentials.</label>
            </div>
            <button type="submit" class="btn btn-block btn-primary mb-4">Sign In</button>
        </form>
    <hr>
    <p class="mb-2 text-muted">Forgot password? <a href="auth-reset-password.html" class="f-w-400">Reset</a></p>
    <p class="mb-0 text-muted">Don’t have an account? <a href="/register" class="f-w-400">Sign Up</a></p>
        
</x-auth-layout>