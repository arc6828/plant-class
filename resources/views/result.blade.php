<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Classification Result</title>
</head>

<body>
    <h1>Plant Classification Result</h1>
    @if (isset($result['results']))
        <ul>
            @foreach ($result['results'] as $plant)
                <li>
                    <strong>Scientific Name:</strong> {{ $plant['species']['scientificName'] }}<br>
                    <strong>Common Name:</strong> {{ $plant['species']['commonNames'][0] ?? 'N/A' }}<br>
                    <strong>Probability:</strong> {{ round($plant['score'], 2) }}<br>
                    <strong>Images:</strong><br>
                    @foreach ($plant['images'] as $image)
                        <img src="{{ $image['url']['o'] }}" alt="Plant Image" style="width:150px; margin:5px;">
                    @endforeach
                </li>
                <br>
            @endforeach
        </ul>
    @else
        <p>No classification results available.</p>
    @endif
</body>

</html>
