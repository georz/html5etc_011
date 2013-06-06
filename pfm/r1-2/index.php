<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars(basename(dirname($_SERVER['PHP_SELF']))); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<style>
.content {
    display: block;
    width: 100%;
    border: 1px solid #000;
    overflow: scroll;
}
.box1 {
    display: -webkit-box;
    width: 800px;
    height: 400px;
}
.box2 {
    display: -webkit-box;
    width: 800px;
    height: 600px;
}
</style>
</head>
<body>
<div class="box1">
    <iframe src="http://www.google.com/pacman/" class="content"></iframe>
</div>
<div class="box2">
    <iframe src="http://johnbhall.com/iphone-4s/" class="content"></iframe>
</div>
</body>
</html>
