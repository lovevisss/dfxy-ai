<html>

    <head>
        <title>login</title>
    </head>

    <body>
        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{route('check')}}" method="POST">

            @csrf
            <input type="text" name="username" >
            <br>
            <input type="password" name="password">

            <input type="submit" name="submit" value="submit">
        </form>
    </body>
</html>
