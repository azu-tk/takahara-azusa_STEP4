<?php
function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: form.php');
    exit;
}

$fields = ['name','age','phone','email','address','question','gender'];
$data = [];
foreach ($fields as $f) { $data[$f] = $_POST[$f] ?? ''; }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>入力内容確認</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body { font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif; line-height: 1.8; padding: 24px; }
    h1 { font-size: 24px; margin-bottom: 16px; }
    dl { max-width: 640px; }
    dt { font-weight: 600; }
    dd { margin: 0 0 12px 0; }
    a { text-decoration: none; }
  </style>
</head>
<body>
  <h1>入力内容確認</h1>
  <dl>
    <dt>名前：</dt><dd><?= h($data['name']) ?></dd>
    <dt>年齢：</dt><dd><?= h($data['age']) ?></dd>
    <dt>電話番号：</dt><dd><?= h($data['phone']) ?></dd>
    <dt>メールアドレス：</dt><dd><?= h($data['email']) ?></dd>
    <dt>住所：</dt><dd><?= h($data['address']) ?></dd>
    <dt>質問：</dt><dd><?= nl2br(h($data['question'])) ?></dd>
    <dt>性別：</dt><dd><?= h($data['gender']) ?></dd>
  </dl>

  <p><a href="form.php">戻る</a></p>
</body>
</html>
