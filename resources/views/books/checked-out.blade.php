<x-layout>

    <x-breadcrumb :pageHeader="$pageHeader" :crumbSuffix="$crumbSuffix">

    </x-breadcrumb>

    <h3>Hello Library</h3>
   
   <div class="row">
        <div class="col-md-9 mb-2 col-xl-9">&nbsp;</div>
        <div class="col-md-3 col-xl-3">
            
            @php //Show add book button if user is a librarian
                if (auth()->user()->role_id == 1) {
            @endphp
                <a href="/book" class="btn btn-info fa fa-plus float-right">
                    Add Book To Library
                </a>
            @php
                }
            @endphp
        </div>
   </div>

   <p></p>

   <div class="row">

        <div class="card">

            <div class="card-body">

                <table class="table table-striped table-bordered table-responsive" id="bookListTable">
                    <thead>
                        <tr>
                            <th>
                                COVER
                            </th>
                            <th>
                                TITLE
                            </th>
                            <th>
                                READER
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
                                $currentDate = date(Utilities::$DATE_FORMAT, time());
                        @endphp
                                <tr>
                                    <td>
                                        <img class="table-thumb" src="{{ $book->cover_image != null ? asset('storage/' . $book->cover_image) : asset('images/no-image.jpg') }}" alt="">
                                    </td>
                                    <td>
                                        <a href="/book/{{$book->id}}">{{$book->title}}</a>
                                    </td>
                                    <td>
                                        <img src="" alt="">
                                        <br>
                                        {{$book->name}}
                                        <br>
                                        {{$book->email}}
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



</x-layout>