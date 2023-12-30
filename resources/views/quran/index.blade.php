<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quran Project</title>
    <!-- Include Materialize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style>
        body {
            padding: 20px;
        }

        .flex-container {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="container">
        @foreach ($verses as $surah)
            <div class="card horizontal">
                <div class="card-stacked">
                    <div class="card-content">
                        <h2 class="card-title center-align">{{ $surah['id'] }}. Quranic Surah: {{ $surah['name'] }}</h2>
                        <div class="flex-container">
                            <p>{{ $surah['transliteration'] }}</p>
                            <p>{{ $surah['translation'] }}</p>
                            <p>{{ $surah['type'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <ul class="collection">
                        @foreach ($surah['verses'] as $verse)
                            <li class="collection-item">
                                <span class="badge">Verse {{ $verse['id'] }}</span>
                                {{ $verse['text'] }}<br>
                                <span class="grey-text">Translation: {{ $verse['translation'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach

        <!-- Add Pagination Links -->
        <div class="mt-4">
            {{ $verses->links() }}
        </div>
    </div>

    <!-- Include Materialize JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
