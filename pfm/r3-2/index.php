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
.box {
    display: -webkit-box;
    width: 800px;
    height: 750px;
}
</style>
</head>
<body>
<div class="box">
    <iframe src="http://dean.edwards.name/packer/" class="content"></iframe>
</div>
</body>
</html>
