<x-layout>
    
    <x-breadcrumb :pageHeader="$pageHeader" :crumbSuffix="$crumbSuffix"></x-breadcrumb>

    <div class="row">
        <div class="col-md-10 m-auto">

            <div class="card">
                <div class="card-header">
                    <h4 class="mb-3 f-w-400">{{$book->title}}</h4>

                    @php //Show add book button if user is a librarian
                    if (auth()->user()->role_id == 1) {
                @endphp
                    <a href="/book/{{$book->id}}/edit" class="btn btn-info fa fa-edit">Edit</a>
                @php
                    }
                @endphp
                    
                </div>
                <div class="card-body">

                    <img src="{{ $book->cover_image != null ? asset('storage/' . $book->cover_image) : asset('images/no-image.jpg') }}" alt="">

                    <p>
                        Author : {{$book->author}}
                    </p>
                    <p>
                        Publisher : {{$book->publisher}}
                    </p>
                    <p>
                        Date Published : {{date('F j, Y', strtotime($book->published_date))}}
                    </p>
                    <p>
                        ISBN : {{$book->isbn}}
                    </p>
                    <p>
                        Genre : {{$book->genre}}
                    </p>
                </div>
            </div>

        </div>
    </div>

</x-layout>