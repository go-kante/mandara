<?php
require __DIR__ . '/vendor/autoload.php';

// サービスアカウントのJSONファイルパス
$serviceAccountPath = 'focus-empire-461908-m6-c31b39398bd6.json';
// スプレッドシートID
$spreadsheetId = '10hDB2ARaSeOUswzKMwKc5_UkYGiJ67P3AtfLP6JlJwc';
// 書き込み先のシート名とセル範囲
$range = 'シート1!A1:L15'; // 例：シート1のA1からB2の範囲

// フォームから送信されたデータを取得
$formData = $_POST['your_form_data_name'];

// Google_Clientオブジェクトを作成し、認証情報を設定
$client = new Google_Client();
$client->setAuthConfig($serviceAccountPath);
$client->setScopes([Google_Service_Sheets::SPREADSHEETS]);

// Google_Service_Sheetsオブジェクトを作成
$service = new Google_Service_Sheets($client);

try {
    // データの準備
    // マンダラチャートのデータを適切な配列形式に整形
    // 例: [['目標1', '目標2'], ['内容A', '内容B']]
    $values = [
        ['目標', '内容'],
        ['次へ', 'グーグルシートに転記'],
        // フォームから取得した残りのデータもここに追加
    ];

    // Request bodyを準備
    $body = new Google_Service_Sheets_ValueRange([
        'values' => $values
    ]);

    // 書き込みの実行
    $result = $service->spreadsheets_values->update(
        $spreadsheetId,
        $range,
        $body,
        ['valueInputOption' => 'USER_ENTERED']
    );

    // 成功メッセージ
    echo 'スプレッドシートにデータを転記しました！';

} catch (Exception $e) {
    // エラーハンドリング
    echo 'エラーが発生しました: ' . $e->getMessage();
}

?>