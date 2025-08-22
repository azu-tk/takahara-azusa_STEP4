<?php
$values = [
    'name'    => '',
    'age'     => '',
    'phone'   => '',
    'email'   => '',
    'address' => '',
    'question'=> '',
    'gender'  => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['__stage']) && $_POST['__stage'] === 'input') {

    foreach ($values as $k => $v) {
        $values[$k] = isset($_POST[$k]) ? trim($_POST[$k]) : '';
    }

    foreach (['name','age','phone','email','address','question','gender'] as $key) {
        if ($values[$key] === '') {
            $errors[$key] = '未入力です。';
        }
    }

    if ($values['name'] !== '' && !preg_match('/^[\p{Hiragana}\p{Katakana}\p{Han}A-Za-z\s]+$/u', $values['name'])) {
        $errors['name'] = '名前はひらがな、カタカナ、漢字、英字のみ使用できます。';
    }

    if ($values['age'] !== '' && (!ctype_digit($values['age']) || (int)$values['age'] < 0 || (int)$values['age'] > 150)) {
        $errors['age'] = '年齢は0から150の間で入力してください。';
    }

    if ($values['phone'] !== '' && !preg_match('/^[0-9-]+$/', $values['phone'])) {
        $errors['phone'] = '電話番号は半角数字とハイフンのみ使用できます。';
    }

    if ($values['email'] !== '' && !filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'メールアドレスの形式が正しくありません。';
    }

    if ($values['address'] !== '' && !preg_match('/^[\p{Hiragana}\p{Katakana}\p{Han}A-Za-z\s]+$/u', $values['address'])) {
        $errors['address'] = '住所はひらがな、カタカナ、漢字、英字のみ使用できます。';
    }

    if (empty($errors)) {
        echo '<!DOCTYPE html><html lang="ja"><head><meta charset="UTF-8"><title>送信中</title></head><body>';
        echo '<form id="forward" action="comform.php" method="post">';
        foreach ($values as $k => $v) {
            $safe = htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
            echo "<input type=\"hidden\" name=\"{$k}\" value=\"{$safe}\">";
        }
        echo '</form>';
        echo '<script>document.getElementById("forward").submit();</script>';
        echo '</body></html>';
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>フォーム入力</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="wrap">
    <h1 class="title">フォーム入力</h1>

    <form action="form.php" method="post" class="form">
        <input type="hidden" name="__stage" value="input">

        <div class="form-group">
            <label for="name">名前：</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($values['name'], ENT_QUOTES, 'UTF-8') ?>">
            <?php if(isset($errors['name'])): ?><p class="error"><?= $errors['name'] ?></p><?php endif; ?>
        </div>

        <div class="form-group">
            <label for="age">年齢：</label>
            <input type="number" id="age" name="age" min="0" max="150" value="<?= htmlspecialchars($values['age'], ENT_QUOTES, 'UTF-8') ?>">
            <?php if(isset($errors['age'])): ?><p class="error"><?= $errors['age'] ?></p><?php endif; ?>
        </div>

        <div class="form-group">
            <label for="phone">電話番号：</label>
            <input type="text" id="phone" name="phone" placeholder="例) 03-1234-5678" value="<?= htmlspecialchars($values['phone'], ENT_QUOTES, 'UTF-8') ?>">
            <?php if(isset($errors['phone'])): ?><p class="error"><?= $errors['phone'] ?></p><?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">メールアドレス：</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($values['email'], ENT_QUOTES, 'UTF-8') ?>">
            <?php if(isset($errors['email'])): ?><p class="error"><?= $errors['email'] ?></p><?php endif; ?>
        </div>

        <div class="form-group">
            <label for="address">住所：</label>
            <input type="text" id="address" name="address" value="<?= htmlspecialchars($values['address'], ENT_QUOTES, 'UTF-8') ?>">
            <?php if(isset($errors['address'])): ?><p class="error"><?= $errors['address'] ?></p><?php endif; ?>
        </div>

        <div class="form-group">
            <label for="question">質問：</label>
            <textarea id="question" name="question" rows="4"><?= htmlspecialchars($values['question'], ENT_QUOTES, 'UTF-8') ?></textarea>
            <?php if(isset($errors['question'])): ?><p class="error"><?= $errors['question'] ?></p><?php endif; ?>
        </div>

        <div class="form-group">
            <label for="gender">性別：</label>
            <select id="gender" name="gender">
                <option value="" <?= $values['gender']===''?'selected':''; ?>>選択してください</option>
                <option value="男性" <?= $values['gender']==='男性'?'selected':''; ?>>男性</option>
                <option value="女性" <?= $values['gender']==='女性'?'selected':''; ?>>女性</option>
                <option value="無回答" <?= $values['gender']==='無回答'?'selected':''; ?>>無回答</option>
            </select>
            <?php if(isset($errors['gender'])): ?><p class="error"><?= $errors['gender'] ?></p><?php endif; ?>
        </div>

        <button type="submit" class="btn-primary">送信</button>
    </form>
</main>
</body>
</html>
