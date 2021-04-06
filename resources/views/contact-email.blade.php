<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Contact Message</title>

    <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$name}} send you a new message</h3>
            </div>
            <div class="card-body">
                <p><strong>Name: </strong>{{$name}}</p>
                <p><strong>Email: </strong>{{$email}}</p>
                <p><strong>Subject: </strong>{{$subject}}</p>
                <p>{{$body}}</p>
            </div>
        </div>
    </div>
    
</body>
</html>