<?php
$basePath = dirname(__DIR__);
$fh = fopen($basePath . '/raw', 'r');
$pool = [];
while ($line = fgets($fh, 1024)) {
    $pool[substr($line, 0, 3)] = trim(substr($line, 4));
}
ksort($pool);
$date1 = strtotime('2018-11-24');
$theDate = strtotime('-100 days', $date1);
$newDate = strtotime('2022-11-26');

//$oFh = fopen($basePath . '/todo.csv', 'w');
$listFh = fopen($basePath . '/list.csv', 'w');
fputcsv($listFh, ['id', '+/-', 'politics', 'check']);
foreach ($pool as $k => $line) {
    $dateText = date('Y-m-d', $theDate);
    $dayCount = 100 - intval($k) + 1;
    $newDateText = date('Y-m-d', strtotime("-{$dayCount} days", $newDate));
    $contentTextFile = $basePath . "/txt/{$newDateText}_{$k}.txt";
    if (!file_exists($contentTextFile)) {
        file_put_contents($contentTextFile, '');
    }
    $contentText = file_get_contents($contentTextFile);
    fputcsv($listFh, [$k, '', $line, $contentText]);
    $longText = "再次早安，台南！\n\n今天({$newDateText})是 2022 大選前 {$dayCount} 天，2018 大選前 {$dayCount} 天是 {$dateText} ， #黃偉哲 市長在這天透過早安圖提出政見 『{$line}』，江明宗想跟大家回顧這個政見過去 4 年的執行情況。";
    $longText .= "\n\n{$contentText}\n你覺得這個政見實現了嗎？歡迎留言聊聊你的看法，或是分享給更多朋友知道！\n\n#江明宗的科技監督\n#北中西區台南市議員參選人江明宗\n#江明宗競選官網 https://tainan.olc.tw";
    //fputcsv($oFh, [$dateText, $k . '/100', $line, $longText]);
    file_put_contents($basePath . '/txt/' . $newDateText . '.txt', $longText);
    $theDate = strtotime('+1 day', $theDate);
}