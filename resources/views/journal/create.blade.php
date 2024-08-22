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

            <!-- Speech-to-Text Button -->
            <button type="button" id="start-record-btn" class="btn-speech">Start Speech to Text</button>
            <p id="speech-status" style="display:none;">Listening...</p>

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

    <!-- Web Speech API Script -->
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

            // Speech to Text functionality
            const startRecordBtn = document.getElementById('start-record-btn');
            const speechStatus = document.getElementById('speech-status');
            let recognition;
            let isListening = false;

            if ('webkitSpeechRecognition' in window) {
                recognition = new webkitSpeechRecognition();
                recognition.continuous = true;
                recognition.interimResults = false;
                recognition.lang = 'en-US';

                recognition.onstart = function() {
                    speechStatus.style.display = 'block';
                };

                recognition.onend = function() {
                    speechStatus.style.display = 'none';
                };

                recognition.onresult = function(event) {
                    let transcript = event.results[event.resultIndex][0].transcript.trim();

                    // Insert the transcript into the current block
                    editor.save().then((outputData) => {
                        const currentBlockIndex = editor.blocks.getCurrentBlockIndex();
                        const blocks = outputData.blocks;

                        // Check if the current block exists and is a paragraph
                        if (blocks[currentBlockIndex] && blocks[currentBlockIndex].type === 'paragraph') {
                            const currentText = blocks[currentBlockIndex].data.text || '';
                            const updatedText = currentText + (currentText ? ' ' : '') + transcript;

                            // Update the paragraph block with the new text
                            editor.blocks.update(currentBlockIndex, {
                                type: 'paragraph',
                                data: {
                                    text: updatedText
                                }
                            });
                        } else {
                            // If not a paragraph, add a new paragraph block with the transcript
                            editor.blocks.insert('paragraph', {
                                text: transcript
                            });
                        }
                    }).catch((error) => {
                        console.error('Error saving data: ', error);
                    });
                };

                startRecordBtn.addEventListener('click', function() {
                    if (isListening) {
                        recognition.stop();
                        isListening = false;
                        startRecordBtn.textContent = 'Start Speech to Text';
                    } else {
                        recognition.start();
                        isListening = true;
                        startRecordBtn.textContent = 'Stop Speech to Text';
                    }
                });
            } else {
                alert('Speech recognition not supported in this browser.');
            }
        });
    </script>
</x-layout>
