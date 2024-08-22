<x-layout>
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
    <x-topbar />

    <div class="form-container">
        <h1>Create a New Journal Entry</h1>

        <form action="{{ route('journal.store') }}" method="POST" enctype="multipart/form-data" id="journalForm">
            @csrf

            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" name="date" id="date" value="{{ $defaultDate }}" required>
            </div>

            <div class="form-group">
                <label for="content">Content:</label>
                <div id="editorjs"></div> <!-- Editor.js holder -->
                <input type="hidden" name="content" id="content"> <!-- Hidden field to store JSON data -->
            </div>

            <div class="form-group">
                <label for="image">Image (optional):</label>
                <input type="file" name="image" id="image" accept="image/*">
            </div>

            <button type="submit" class="btn-submit">Save Entry</button>
        </form>
    </div>

    <!-- Include Editor.js and necessary tools -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/simple-image@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/list@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/quote@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/embed@latest"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editor = new EditorJS({
                holder: 'editorjs',
                tools: {
                    header: Header,
                    image: SimpleImage,
                    list: List,
                    quote: Quote,
                    embed: Embed
                },
                onChange: () => {
                    editor.save().then((outputData) => {
                        document.getElementById('content').value = JSON.stringify(outputData);
                    }).catch((error) => {
                        console.error('Saving failed: ', error);
                    });
                }
            });

            // Capture form submission to ensure Editor.js data is saved
            document.getElementById('journalForm').addEventListener('submit', function () {
                editor.save().then((outputData) => {
                    document.getElementById('content').value = JSON.stringify(outputData);
                }).catch((error) => {
                    console.error('Saving failed: ', error);
                });
            });
        });
    </script>
</x-layout>
