<x-layout>
    
    <x-breadcrumb :pageHeader="$pageHeader" :crumbSuffix="$crumbSuffix"></x-breadcrumb>

    <div class="row">
        <div class="col-md-12 m-auto">

            <div class="card">
                <div class="card-header">
                    
                    <h4 class="mb-3 f-w-400">{{$user->name != null ? $user->name : $user->email}}</h4>

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

    <div class="row">
        <div class="col-md-12 m-auto">

            <div class="card">

                <div class="card-header">
                    <h4>Book Currently Checked Out By user</h4>
                </div>

                <div class="card-body">

                    <table class="table table-striped table-bordered" id="bookListTable">
                        <thead>
                            <tr>
                                <th>
                                    COVER
                                </th>

                                <th>
                                    TITLE
                                </th>
                                
                                <th>
                                    CHECKED OUT
                                </th>
                                
                                <th>
                                    EXPECTED CHECK IN
                                </th>
                                
                                <th>
                                    STATUS
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                
                            @php
                                foreach ($books as $book) {
                                    $checkOutDate = $book->check_out_date;
                                    $expectedDate = $book->expected_date;
                                    $checkInDate = $book->check_in_date;
                                    $currentDate = date(Utilities::DATE_FORMAT, time());
                            @endphp
                                    <tr>
                                        <td>
                                            <img class="w-25" src="{{ $book->cover_image != null ? asset('storage/' . $book->cover_image) : asset('images/no-image.jpg') }}" alt="">
                                        </td>
                                        <td>
                                            <a href="/book/{{$book->id}}">{{$book->title}}</a>
                                        </td>
                                        <td>
                                            {{Utilities::displayDateFormat($checkOutDate)}}
                                        </td>
                                        <td>
                                            {{Utilities::displayDateFormat($expectedDate)}}
                                        </td>
                                        <td>
                                            @php
                                                // Get days remaining or overdue warning
                                                $warning = Utilities::getRemainingOrOver($expectedDate, $currentDate);
                                                $warningClass = $expectedDate > $currentDate ? 'info' : 'danger';
                                                echo '</br><span class="' . $warningClass .'">'. $warning . '</span>';
                                            @endphp
                                        </td>
                                    </tr>
                            @php
                                }
                            @endphp
                        </tbody>
                        
                    </table>
                </div>
            </div>

        </div>
    </div>

</x-layout>