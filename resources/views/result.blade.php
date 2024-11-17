<x-bootstrap title="Plant Classification Result">


    <div class="container">
        <h1>Plant Classification Result</h1>
        @if (isset($result['results']))
            <div>
                @foreach ($result['results'] as $plant)                
                    <hr>
                    <div class="col-lg-12">
                        <strong># {{ $loop->iteration }}  </strong> <br />
                        <strong>Scientific Name:</strong> {{ $plant['species']['scientificName'] }}<br>
                        <strong>Common Name:</strong> {{ $plant['species']['commonNames'][0] ?? 'N/A' }}<br>
                        <strong>Probability:</strong> {{ round($plant['score'], 2) }}<br>
                        <strong>Images:</strong><br>
                        @foreach ($plant['images'] as $image)
                            <img src="{{ $image['url']['o'] }}" alt="Plant Image" style="height:200px; margin:5px;">
                        @endforeach
                    </div>
                @endforeach
            </div>
        @else
            <p>No classification results available.</p>
        @endif
    </div>

</x-bootstrap>
