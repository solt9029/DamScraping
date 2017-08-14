<?php
require_once "phpQuery/phpQuery.php";

$csv = getCsv('./data/musics.csv');

for($i=0; $i<count($csv); $i++){
    $code = getCodeWhereArtistAndKeyword($csv[$i][0], $csv[$i][1]);
    $csv[$i][] = $code[0];
    $csv[$i][] = $code[1];
}

setCsv('./output/musics.csv', $csv);

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

function getCodeWhereArtistAndKeyword ($keyword, $artist) {
    $url = 'http://www.clubdam.com/app/search/searchKeywordKaraoke.html';
    $data = array(
        'keyword' => $keyword,
        'searchType' => '1',
        'matchOption' => '0',
        'x' => '44',
        'y' => '20'
    );

    $html = getHtmlWithPost($url, $data);
    $doc = phpQuery::newDocument($html);

    $result = array();

    //完全に一致するとき
    for ($i=1; $i<$doc[".list tr"]->length+1; $i++) {
        $current_code_index = ".list tr:eq(".$i.") td:eq(2)";
        $current_artist_index = ".list tr:eq(".$i.") td:eq(1)";

        $current_code = $doc[$current_code_index]->text();
        $current_artist = $doc[$current_artist_index]->text();

        if($artist === $current_artist){
            return array($current_code, '完全一致');
        }
    }

    //その文字が含まれるとき（歌手）
    for ($i=1; $i<$doc[".list tr"]->length; $i++) {
        $current_code_index = ".list tr:eq(".$i.") td:eq(2)";
        $current_artist_index = ".list tr:eq(".$i.") td:eq(1)";

        $current_code = $doc[$current_code_index]->text();
        $current_artist = $doc[$current_artist_index]->text();

        if(mb_strpos($artist, $current_artist) >= 0){
            return array($current_code, '一部一致');
        }
    }

    return array('一致無し', '一致無し');
}

function setCsv ($filename, $csv) {
    $data = '';

    foreach($csv as $values){
        $line = implode(",", $values);
        $line.="\n";
        $data.=$line;
    }

    mb_convert_encoding($data, "SJIS", "UTF-8");
    file_put_contents($filename, $data);
}