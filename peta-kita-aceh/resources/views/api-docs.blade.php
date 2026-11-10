<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - PetaKita Aceh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .markdown-body {
            font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Helvetica,Arial,sans-serif;
            font-size: 16px;
            line-height: 1.5;
            word-wrap: break-word;
        }
        .markdown-body h1, .markdown-body h2 {
            border-bottom: 1px solid #eaecef;
            padding-bottom: .3em;
            margin-top: 24px;
            margin-bottom: 16px;
        }
        .markdown-body pre {
            background-color: #f6f8fa;
            border-radius: 3px;
            padding: 16px;
            overflow: auto;
        }
        .markdown-body code {
            background-color: rgba(27,31,35,.05);
            border-radius: 3px;
            padding: .2em .4em;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    PetaKita Aceh
                </h1>
                <a href="/" class="text-indigo-600 hover:text-indigo-900">Kembali ke Beranda</a>
            </div>
        </header>
        <main>
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <div class="bg-white px-8 py-8 shadow sm:rounded-lg">
                    <div class="markdown-body">
                        {!! $html !!}
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
