<?php
$page = file_get_contents('https://www.tainan.gov.tw/News_Photo_Content.aspx?n=36312&s=7924003');
$needle = '<a   href="https://w3fs.tainan.gov.tw/001/Upload/1/relpic/';
$pos = strpos($page, $needle);
$listFh = fopen(__DIR__ . '/list.csv', 'w');
while (false !== $pos) {
    $posEnd = strpos($page, 'data-title=', $pos);
    $parts = explode('"', substr($page, $pos, $posEnd - $pos));
    $parts[3] = strtolower($parts[3]);
    if (substr($parts[3], -3) !== 'jpg') {
        $parts[3] = $parts[3] . '.jpg';
    }
    $listLine = substr($parts[3], 0, -4);
    fputcsv($listFh, [substr($listLine, 0, 4), substr($listLine, 4)]);
    $targetFile = __DIR__ . '/img/' . str_replace(' ', '_', $parts[3]);
    if (!file_exists($targetFile)) {
        $p = pathinfo($parts[1]);
        $nameParts = explode('@', $parts[1]);
        file_put_contents($targetFile, file_get_contents($nameParts[0] . '.' . $p['extension']));
    }
    $pos = strpos($page, $needle, $posEnd);
}
