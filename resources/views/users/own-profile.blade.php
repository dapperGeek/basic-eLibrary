<x-layout>
    
    <x-breadcrumb :pageHeader="$pageHeader" :crumbSuffix="$crumbSuffix"></x-breadcrumb>

    <div class="row">
        <div class="col-md-12 m-auto">

            <div class="card">
                <div class="card-header">
                    
                    <h4 class="mb-3 f-w-400">{{$user->name != null ? $user->name : $user->email}}</h4>

                    <a href="/my-profile/update" class="btn btn-info fa fa-edit">&nbsp; Update Profile</a>
                    
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-3">
                            {{-- // Book cover image --}}

                            <img class="read-img" src="{{ $user->avatar != null ? asset('storage/' . $user->avatar) : asset('images/no-image.jpg') }}" alt="">
    
                        </div>
    
                        <div class="col-md-5">
                            {{-- // User Details --}}
                            
                            <b>Name: </b> {{$user->name}} <br><br>
                            <b>Email: </b> {{$user->email}} <br><br>
                            <b>Password: </b> hidden <br><br>
    
                        </div>
    
                        <div class="col-md-2">
                            
                            {{-- Interaction buttons --}}
                            
                           <div class="row mb-5">

                            

                           </div>
    
                           <div class="row">
                                
                               

                           </div>
    
                           <div class="row">
                            
                           </div>
    
                            
                        </div>
    
                    </div>

                </div>
            </div>

        </div>
    </div>

</x-layout>