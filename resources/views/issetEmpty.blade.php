<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=s, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Isset and Empty</title>
</head>
<body>
    <p>
        @isset($name)
            Hello, my name is {{$name}}
        @endisset
    </p>
    <p>
        @empty($hobbies)
            I don't have hobbies
        @endempty
    </p>
</body>
</html>