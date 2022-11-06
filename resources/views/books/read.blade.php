<x-layout>
    
    <x-breadcrumb :pageHeader="$pageHeader" :crumbSuffix="$crumbSuffix"></x-breadcrumb>

    <div class="row">
        <div class="col-md-12 m-auto">

            <div class="card">
                <div class="card-header">
                    
                    <h4 class="mb-3 f-w-400">{{$book->title}}</h4>
                    
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-3">
                            {{-- // Book cover image --}}

                            <img class="read-img" src="{{ $book->cover_image != null ? asset('storage/' . $book->cover_image) : asset('images/no-image.jpg') }}" alt="">
    
                        </div>
    
                        <div class="col-md-5">
                            {{-- // Book Details --}}
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
                            <p>
                                Synopsis: <br>
                                {{$book->synopsis}}
                            </p>
    
                        </div>
    
                        <div class="col-md-2">
                            
                            {{-- Interaction buttons --}}
                            
                           <div class="row mb-5">

                            @php //Show add book button if user is a librarian
                                if (auth()->user()->role_id == 1) {
                            @endphp
                                <a href="/book/{{$book->id}}/edit" class="btn btn-info fa fa-edit"> Edit</a>
                            @php
                                }
                            @endphp

                           </div>
    
                           <div class="row">
                                
                                @php
                                    if ($checkStatus != null && $checkStatus->check_out_status == 0) {
                                        $checkOutDate = $checkStatus->check_out_date;
                                        $expectedDate = $checkStatus->expected_date;
                                        $checkInDate = $checkStatus->check_in_date;
                                        $currentDate = date(Utilities::$DATE_FORMAT, time());
                                @endphp
                                {{-- Show Check in book button --}}

                                    <form method="POST" action="/check-in">
                                        @csrf

                                        <input type="hidden" name="check_out_id" value="{{$checkStatus->id}}">

                                        <button class="btn btn-primary fa fa-arrow-down" type="submit"> Check In</button>
                                    </form>

                                @php
                                        // Get days remaining or overdue warning
                                        $warning = Utilities::getRemainingOrOver($expectedDate, $currentDate);

                                        $warningClass = $expectedDate > $currentDate ? 'info' : 'danger';

                                        echo '</br><span class="' . $warningClass .'">'. $warning . '</span>';

                                    }
                                    else {
                                @endphp
                                
                                    {{-- Show check out book button --}}

                                    <form method="POST" action="/check-out">
                                        @csrf

                                        <input type="hidden" name="book_id" value="{{$book->id}}">

                                        <input type="hidden" name="user_id" value="{{auth()->user()->id}}">

                                        <button class="btn btn-primary fa fa-arrow-up" type="submit"> Check Out</button>
                                    </form>
 
                                @php
                                    }
                                @endphp

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