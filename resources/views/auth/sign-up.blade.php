<x-auth-layout>

    <h4 class="f-w-400">Sign up</h4>
    <hr>
        <form method="POST" action="/registerUser">
            @csrf
            <div class="form-group mb-3">
                <input name="email" type="text" class="form-control" id="Email" placeholder="Email address">

                @error('email')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            
            </div>
            <div class="form-group mb-3">
                <select name="role_id" class="form-control">
                    <option value="1">Librarian</option>
                    <option value="2">Reader</option>
                </select>

                @error('role_id')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            
            </div>
            <div class="form-group mb-4">
                <input name="password" type="password" class="form-control" id="Password" placeholder="Password">

                @error('password')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            
            </div>
            <div class="form-group mb-4">
                <input name="password_confirmation" type="password" class="form-control" id="Password" placeholder="Confirm Password">

                @error('password_confirmation')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            
            </div>
            <button type="submit" class="btn btn-primary btn-block mb-4">Sign up</button>
                
        </form>
    <hr>
    <p class="mb-2">Already have an account? <a href="/login" class="f-w-400">Sign In</a></p>
    
    <p class="mb-2"><a href="/docs" class="f-w-400">APP DOCUMENTATION</a></p>

</x-auth-layout>