<x-layout>
    
    <x-breadcrumb :pageHeader="$pageHeader" :crumbSuffix="$crumbSuffix"></x-breadcrumb>

    <div class="row">
        <div class="col-md-8 m-auto">

        <h4 class="mb-3 f-w-400">Edit Profile</h4>

            <form method="POST" enctype="multipart/form-data" action="/update-profile">
                @method('PUT')
                @csrf

            <input type="hidden" name="id" value="{{auth()->user()->id}}">

            <div class="form-group mb-4">
                <label for="name">Name</label>
                <input name="name" type="text" class="form-control" id="title" value="{{$user->name}}">

                @error('name')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="email">Email</label>
                <input disabled name="email" type="text" class="form-control" id="email" value="{{$user->email}}">

                @error('email')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="avatar">Profile Picture</label>
                <input type="file"class="form-control" name="avatar" id="avatar" />

                @error('avatar')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror

            </div>

            <div class="form-group mb-4">
                <button type="submit" class="btn btn-info mr-2">Update Profile</button>

                <a href="/my-profile" class="btn btn-warning">Cancel</a>
            </div>

        </form>

        </div>
    </div>

</x-layout>