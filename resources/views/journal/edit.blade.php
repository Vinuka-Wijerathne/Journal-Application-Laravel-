<x-layout>
    <x-topbar />

    <div class="journal-edit-container">
        <h1>Edit Journal Entry for {{ \Carbon\Carbon::parse($journalEntry->date)->format('F j, Y') }}</h1>

        <form method="POST" action="{{ route('journal.update', $journalEntry->id) }}">
            @csrf
            @method('PUT') <!-- Specify the PUT method for update -->

            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" value="{{ \Carbon\Carbon::parse($journalEntry->date)->format('Y-m-d') }}" required>
            </div>

            <!-- Editor.js container -->
            <div id="editorjs"></div>

            <!-- Hidden input to store Editor.js data -->
            <input type="hidden" name="content" id="editorjs-content">

            <!-- Speech-to-Text Button -->
            <button type="button" id="start-record-btn" class="btn-primary">Start Speech Recognition</button>

            <button type="submit" class="btn-primary">Update Journal</button>
        </form>
    </div>

    <!-- Include Editor.js and initialization script -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/list@latest"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize Editor.js with existing content
            const editor = new EditorJS({
                holder: 'editorjs',
                tools: {
                    header: Header,
                    list: List,
                },
                data: {!! json_encode($journalEntry->content) !!}, // Ensure this is a valid JSON
                onChange: () => {
                    editor.save().then((outputData) => {
                        document.getElementById('editorjs-content').value = JSON.stringify(outputData);
                    }).catch((error) => {
                        console.log('Saving failed: ', error);
                    });
                }
            });

            // Speech Recognition
            const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
            recognition.interimResults = true;

            recognition.addEventListener('result', (event) => {
                const transcript = Array.from(event.results)
                    .map(result => result[0])
                    .map(result => result.transcript)
                    .join('');
                editor.blocks.insert('paragraph', {
                    text: transcript
                });
            });

            recognition.addEventListener('end', () => {
                // The recognition stops automatically when you stop speaking
            });

            document.getElementById('start-record-btn').addEventListener('click', () => {
                recognition.start();
            });
        });
    </script>
</x-layout>
