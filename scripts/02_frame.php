<?php
$basePath = dirname(__DIR__);
$imgPath = $basePath . '/img';
if (!file_exists($imgPath)) {
    mkdir($imgPath, 0777);
}
$newDate = strtotime('2022-11-26');

foreach (glob($basePath . '/raw_img/*.*') as $jpgFile) {
    $p = pathinfo($jpgFile);
    $dayCount = 100 - intval($p['filename']) + 1;
    $newDateText = date('Y-m-d', strtotime("-{$dayCount} days", $newDate));
    $targetFile = $imgPath . '/' . $newDateText . '.jpg';
    $image = new Imagick($basePath . '/frame.png');
    $src1 = new Imagick($jpgFile);
    $src1->scaleImage(413, 413, true);
    $src1->setImageType (2);
    $image->compositeImage($src1, Imagick::COMPOSITE_DEFAULT, 667, 374);
    $image->writeImage($targetFile);
}
