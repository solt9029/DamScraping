<?php
require_once "phpQuery/phpQuery.php";

$csv = getCsv('./data/musics.csv');

$html = selectCodeWhereAuthorAndKeyword('前前前世', 'RADWINPS');

$doc = phpQuery::newDocument($html);

var_dump($doc[".list tr"]->length - 1);//出てくるtr要素の数(一番上はタイトルとかなので除くよ)

var_dump($doc[".list tr:eq(1) td:eq(2)"]->text());//曲のコード
var_dump($doc[".list tr:eq(1) td:eq(1)"]->text());//歌っている人

//csvファイルを取得する
function getCsv ($filename) {
    $f = fopen($filename, "r");
    $csv = array();
    while($line = fgetcsv($f)){
        $csv[] = $line;
    }
    fclose($f);
    return $csv;
}

//postした後にHTMLを取得する関数
function getHtmlWithPost ($url, $data = array()) {
    $options = array("http" => array(
        "method" => "POST",
        "content" => http_build_query($data)
    ));
    $html = file_get_contents($url, false, stream_context_create($options));
    return $html;
}

function selectCodeWhereAuthorAndKeyword ($keyword, $author) {
    $url = 'http://www.clubdam.com/app/search/searchKeywordKaraoke.html';
    $data = array(
        'keyword' => $keyword,
        'searchType' => '1',
        'matchOption' => '0',
        'x' => '44',
        'y' => '20'
    );

    $html = getHtmlWithPost($url, $data);

    return $html;
}