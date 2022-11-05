<x-layout>

    <x-breadcrumb>

    </x-breadcrumb>

    <h3>Hello Library</h3>
   
   <div class="row">
        <div class="col-md-9 mb-2 col-xl-9">&nbsp;</div>
        <div class="col-md-3 col-xl-3">
            <a href="/book" class="btn btn-info fa fa-plus">
                Add Book To Library
            </a>
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
                                TITLE
                            </th>
                            <th>
                                ISBN
                            </th>
                            <th>
                                DATE PUBLISHED
                            </th>
                            <th>
                                PUBLISHER
                            </th>
                            <th>
                                AUTHOR
                            </th>
                            <th>
                                GENRE
                            </th>
                        </tr>
                    </thead>
                    <tbody>
            
                        @php
                            foreach ($books as $book) {
                                $date = strtotime($book->published_date);
                                $dateFormatted = date('F j, Y', $date);
                        @endphp
                                <tr>
                                    <td>
                                        {{$book->title}}
                                    </td>
                                    <td>
                                        {{$book->isbn}}
                                    </td>
                                    <td>
                                        {{$dateFormatted}}
                                    </td>
                                    <td>
                                        {{$book->publisher}}
                                    </td>
                                    <td>
                                        {{$book->author}}
                                    </td>
                                    <td>
                                        {{$book->genre}}
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