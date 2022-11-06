<x-layout>
    
    <x-breadcrumb :pageHeader="$pageHeader" :crumbSuffix="$crumbSuffix"></x-breadcrumb>

    <div class="row">
        <div class="col-md-8 m-auto">

        <h4 class="mb-3 f-w-400">Edit {{$book->title}}</h4>

            <form method="POST" enctype="multipart/form-data" action="/updateBook">
                @method('PUT')
                @csrf

            <input type="hidden" name="id" value="{{$book->id}}">

            <div class="form-group mb-4">
                <label for="title">Title</label>
                <input name="title" type="text" class="form-control" id="title" value="{{$book->title}}">

                @error('title')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="isbn">ISBN</label>
                <input name="isbn" type="text" class="form-control" id="isbn" value="{{$book->isbn}}">

                @error('isbn')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="revision_number">Revision Number</label>
                <input name="revision_number" type="number"  class="form-control" id="revision_number"  selected="{{$book->revision_number}}>

                @error('revision_number')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="published_date">Published Date</label>
                <input name="published_date" type="date" class="form-control" id="published_date" placeholder="dd/mm/yyyy" value="{{date('d/m/Y', strtotime($book->published_date))}}>

                @error('published_date')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="publisher">Publisher</label>
                <input name="publisher" type="text" class="form-control" id="publisher" value="{{$book->publisher}}">

                @error('publisher')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="author">Author</label>
                <input name="author" type="text" class="form-control" id="author" value="{{$book->author}}">

                @error('author')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="genre">Genre</label>
                <input name="genre" type="text" class="form-control" id="genre" value="{{$book->genre}}">

                @error('genre')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="cover_image">Cover Image</label>
                <input type="file"class="form-control" name="cover_image" id="cover_image" />

                @error('cover_image')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror

            </div>

            <div class="form-group mb-4">
                <label for="synopsis">Synopsis</label><br>

                @error('synopsis')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror

                <textarea name="synopsis" id="synopsis" cols="100" class="form-group mb-4" rows="10">{{$book->synopsis}}</textarea>
            </div>

            <div class="form-group mb-4">
                <button type="submit" class="btn btn-info">Update Book</button>
            </div>

        </form>

        </div>
    </div>

</x-layout>