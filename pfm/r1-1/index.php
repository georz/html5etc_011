<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars(basename(dirname($_SERVER['PHP_SELF']))); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<style>
.content {
    display: block;
    width: 50%;
    border: 1px solid #000;
    overflow: scroll;
}
.box {
    display: -webkit-box;
    width: 800px;
    height: 300px;
}
</style>
</head>
<body>
<div class="box">
    <iframe src="before.html" class="content"></iframe>
    <iframe src="after.html" class="content"></iframe>
</div>
<div class="box">
    <div class="content"><pre><?= htmlspecialchars(file_get_contents('before.html')); ?></pre></div>
    <div class="content"><pre><?= htmlspecialchars(file_get_contents('after.html')); ?></pre></div>
</div>
</body>
</html>