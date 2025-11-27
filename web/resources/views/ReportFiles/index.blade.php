<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Files and Directories</title>
</head>
<body>
    <h1>Directories</h1>
    <ul>
        @foreach($directories as $directory)
            <li>
                Directory: {{ basename($directory) }}
            </li>
        @endforeach
    </ul>

    <h1>Files</h1>
    <ul>
        @foreach($files as $file)
            <li>
                File: {{ $file->getFilename() }}
                <a href="{{ route('files.show', ['filename' => $file->getFilename()]) }}" target="_blank">View</a>
                <a href="{{ route('files.download', ['filename' => $file->getFilename()]) }}">Download</a>
            </li>
        @endforeach
    </ul>
</body>
</html>
