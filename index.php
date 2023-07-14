<?php
$init = curl_init('https://api.nbrb.by/exrates/rates?ondate&periodicity=0');

curl_setopt($init, CURLOPT_RETURNTRANSFER, true);

$json = curl_exec($init);
$decode = json_decode($json);
$result = '';

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    foreach ($decode as $v) {
        if($v->{'Cur_ID'} == isset($_GET['currency']) && isset($_GET['num']) !== NULL) {
            $result = $v->{'Cur_OfficialRate'} * $_GET['num'];
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Converter</title>
</head>
<body>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get">
    <label for="val"> Выберите валюту:
        <select name="currency" id="val">

            <?php foreach ($decode as $v) {?>
                <option value="<?= $v->{'Cur_ID'} ?>"> <?= $v->{'Cur_Name'} ?> </option>
            <?php } ?>

        </select>
    </label>

    <label for="num">
        Введите сумму покупки валюты: <input type="text" name="num" id="num">
    </label>

    <input type="submit" name="send" value="Конвертировать" >
</form>

<div class="result">
   Ваша сумма: <?= $result ?>
</div>
</body>
</html>
