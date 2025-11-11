<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI画像分析システム</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
        }
        .form-card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        input[type="text"]:focus {
            outline: none;
            border-color: #4CAF50;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
        }
        button:hover {
            background-color: #45a049;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .logs-card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }
        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        tr:hover {
            background-color: #f8f9fa;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: 500;
        }
        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>AI画像分析システム</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="form-card">
            <h2>画像分析実行</h2>
            <form action="{{ route('ai-analysis.analyze') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="image_path">画像ファイルパス</label>
                    <input type="text"
                           id="image_path"
                           name="image_path"
                           placeholder="/image/d03f1d36ca69348c51aa/c413eac329e1c0d03/test.jpg"
                           value="{{ old('image_path') }}"
                           required>
                </div>
                <button type="submit">分析実行</button>
            </form>
        </div>

        <div class="logs-card">
            <h2>分析ログ一覧</h2>
            @if($logs->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>画像パス</th>
                            <th>ステータス</th>
                            <th>メッセージ</th>
                            <th>クラス</th>
                            <th>信頼度</th>
                            <th>リクエスト日時</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td>{{ $log->id }}</td>
                                <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ $log->image_path }}
                                </td>
                                <td>
                                    @if($log->success)
                                        <span class="badge badge-success">成功</span>
                                    @else
                                        <span class="badge badge-error">失敗</span>
                                    @endif
                                </td>
                                <td>{{ $log->message }}</td>
                                <td>{{ $log->class ?? '-' }}</td>
                                <td>{{ $log->confidence ?? '-' }}</td>
                                <td>{{ $log->request_timestamp ? $log->request_timestamp->format('Y-m-d H:i:s') : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $logs->links() }}
                </div>
            @else
                <p style="color: #666;">まだログがありません。</p>
            @endif
        </div>
    </div>
</body>
</html>
