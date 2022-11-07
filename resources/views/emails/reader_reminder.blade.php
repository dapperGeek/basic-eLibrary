<html>
    <head>

    </head>

    <body>
        <p>
            Hello {{$reminder->email}}, <br><br>

            You have until {{date('F j, Y', strtotime($reminder->expected_date))}} to check in the book '{{$reminder->title}}' <br><br>
            
            Happy reading!!! <br><br>

            Kindly return on schedule.
            <br><br>

            Best regards,<br>
            Librarian
        </p>
    </body>
</html>