<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload large file</title>
    <script src="https://cdn.jsdelivr.net/npm/resumablejs/resumable.js"></script>
</head>
<body>
<h1>Upload large file</h1>
<button id="browseButton">Chose file</button>
<div id="progress"></div>

<h2>Files list:</h2>
<ul id="uploadedFiles"></ul>

<script>
    // Files upload
    const resumable = new Resumable({
        target: '/upload',
        method: 'post',
        query: function (resumableFile, chunk) {
            return {
                _token: '{{ csrf_token() }}',
                fileName: resumableFile.fileName,
                chunkIndex: chunk.offset,
                totalChunks: resumableFile.chunks.length,
            };
        },
        chunkSize: 1 * 1024 * 1024, // Size chunk 1MB
        simultaneousUploads: 3,
        testChunks: false,
        throttleProgressCallbacks: 1,
    });

    resumable.assignBrowse(document.getElementById('browseButton'));

    resumable.on('fileAdded', function (file) {
        resumable.upload();
    });

    resumable.on('fileProgress', function (file) {
        const progress = Math.floor(file.progress() * 100);
        document.getElementById('progress').innerText = `Uploading: ${progress}%`;
    });

    resumable.on('fileSuccess', function (file, message) {
        console.log('Success upload', message);
    });

    resumable.on('fileError', function (file, message) {
        console.error('Error upload', message);
    });

    // Files list
    function loadUploadedFiles() {
        fetch('/uploaded-files')
            .then(response => response.json())
            .then(files => {
                const fileList = document.getElementById('uploadedFiles');
                fileList.innerHTML = '';

                files.forEach(file => {
                    const li = document.createElement('li');

                    const link = document.createElement('a');
                    link.href = `/download/${encodeURIComponent(file.replace('uploads/', ''))}`;
                    link.textContent = file.replace('uploads/', '');
                    link.target = '_blank';

                    li.appendChild(link);
                    fileList.appendChild(li);
                });
            })
            .catch(error => {
                console.error('Error listing files:', error);
            });
    }

    document.addEventListener('DOMContentLoaded', loadUploadedFiles);
</script>
</body>
</html>
