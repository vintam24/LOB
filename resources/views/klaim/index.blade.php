<!DOCTYPE html>
<html>
<head>
    <title>Data Klaim</title>
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top: 4px solid #3498db;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6" style="text-align:center">Data Klaim per LOB</h1>

        <div class="text-right mb-6">
            <button id="backup-button" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Backup Data Button
            </button>
        </div>

        <div id="loading-spinner" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
            <div class="spinner"></div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 border-b">LOB</th>
                        <th class="py-2 px-4 border-b">Penyebab Klaim</th>
                        <th class="py-2 px-4 border-b">Periode</th>
                        <th class="py-2 px-4 border-b">Nilai Beban Klaim</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($klaim as $item)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $item->sub_cob }}</td>
                        <td class="py-2 px-4 border-b">{{ $item->penyebab_klaim }}</td>
                        <td class="py-2 px-4 border-b">{{ $item->periode }}</td>
                        <td class="py-2 px-4 border-b">{{ number_format($item->nilai_beban_klaim, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="popup-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <p id="popup-message" class="text-lg"></p>
            <button id="close-modal" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Close
            </button>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#backup-button').on('click', function() {
                $('#loading-spinner').removeClass('hidden');

                $.ajax({
                    url: '{{ route('klaim.backup') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        $('#popup-message').text('Data backup completed successfully!');
                        $('#popup-modal').removeClass('hidden');
                    },
                    error: function(xhr) {
                        $('#popup-message').text('Failed to backup data. Please try again.');
                        $('#popup-modal').removeClass('hidden');
                    },
                    complete: function() {
                        $('#loading-spinner').addClass('hidden');
                    }
                });
            });

            $('#close-modal').on('click', function() {
                $('#popup-modal').addClass('hidden');
            });
        });
    </script>

</body>
</html>
