<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Plant Image</title>
</head>

<body>
    <h1>Upload an Image for Plant Classification</h1>
    <form action="{{ route('classify.plant') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Classify Plant</button>
    </form>

    <h2>for example</h2>
    <img src="{{ asset('img/banana.jpg') }}" height="200" />
</body>

</html>
