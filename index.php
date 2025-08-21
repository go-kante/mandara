
<?php
require __DIR__ . '/vendor/autoload.php';

$json_file_path = dirname(__DIR__) . '/pass/to/focus-empire-461908-m6-2c7d03130cab.json';

$client = new \Google_Client();
$client->setApplicationName('Google Sheets API');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAuthConfig($json_file_path);

// Google Sheetsサービスを構築
$service = new \Google_Service_Sheets($client);

// フォームが送信された場合にのみスプレッドシートを作成
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    try {
        $goal = $_POST['goal'] ?? '新しい目標シート';

        // 新しいスプレッドシートのプロパティを定義
        $spreadsheetProperties = new \Google_Service_Sheets_SpreadsheetProperties([
            'title' => $goal
        ]);
        
        // スプレッドシートオブジェクトを構築
        $spreadsheet = new \Google_Service_Sheets_Spreadsheet([
            'properties' => $spreadsheetProperties
        ]);

        // スプレッドシートを新規作成
        $response = $service->spreadsheets->create($spreadsheet, [
            'fields' => 'spreadsheetId'
        ]);

        // 新しく作成されたスプレッドシートのIDを取得
        $newSpreadsheetId = $response->getSpreadsheetId();

        echo "新しいスプレッドシートが正常に作成されました。\n";
        echo "スプレッドシートID: " . $newSpreadsheetId . "\n";
        echo "URL: https://docs.google.com/spreadsheets/d/" . $newSpreadsheetId . "/edit\n";

    } catch (\Google\Service\Exception $e) {
        echo "スプレッドシートの作成中にエラーが発生しました: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<header>
    <a href=""class="top">＜top画面</a>
</header>
<body>
    <div class="title">
        <h2 class="fas fa-bullseye mr-3">マンダラチャート作成ツール</h2>
    </div>    
    <div class="goal">
        <th>
            <p>目標を設定</p>
            <form action="" method="post">
                <input type="text" name="goal"placeholder="例：フルスタックエンジニアになる">
                <button type="submit" name="submit" class="btn btn-primary" style="margin-top: 10px;">決定</button>
            </form>
        </th>   
    </div>
</body>
</html>