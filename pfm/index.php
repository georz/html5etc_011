<?php

$type    = $_REQUEST['type'];
$expires = intval($_REQUEST['expires']); // Expires       | -1: past / 0: none / 1: future
$last    = intval($_REQUEST['last']);    // Last-Modified | -1: file-timestamp / 0: none
$sleep   = intval($_REQUEST['sleep']);

switch ($type) {
    case 'css':
        header('Content-Type: text/css');
        break;

    case 'js':
        header('Content-Type: application/x-javascript');
        break;

    case 'html':
        header('Content-Type: text/html');
        break;

    case 'png':
        header('Content-Type: image/png');
        break;

    default:
        $type = 'png';
        header('Content-Type: image/png');
        break;
}

switch ($expires) {
    case '1':
        //header('Cache-control: must-revalidate');
        //header("Cache-Control: maxage=" . 3600 * 24 * 14);
        header('Expires: ' . gmdate('D, d M Y H:i:s T', strtotime('+1 year')));
        break;

    case '-1':
        //header('Cache-control: must-revalidate');
        //header("Cache-Control: maxage=" . 3600 * 24 * 14);
        header('Expires: ' . gmdate('D, d M Y H:i:s T', strtotime('-1 year')));
        break;

    case '0':
    default:
        break;
}

$last_modified = gmdate('D, d M Y H:i:s T', filemtime($type));
switch ($last) {
    case '-1':
        header('Last-Modified: ' . $last_modified);
        break;

    case '0':
    default:
        break;
}

if ($_SERVER['HTTP_IF_MODIFIED_SINCE'] == $last_modified) {
    header('HTTP/1.1 304 Not Modified');
}

if ($sleep > 0) {
    sleep($sleep);
}

print file_get_contents($type);