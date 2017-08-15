# 概要

- DAMのページからコードを自動的に取得するプログラム

# 実行環境

- php: 5.6.28

- windows: 10

# 使い方

- dataディレクトリにmusics.csvを置く

- musics.csvの内容は以下のように「曲名,歌手」となるようにする

```
人生花暦,鳥羽一郎
俺は浪花の暴れん坊,鏡五郎
野菊の君だから,北山たけし
横濱のブルース,北川大介
雪花角館,黒川真一朗
津軽の風,徳永ゆうき
はぐれ花,市川由紀乃
かぼちゃの花,中村美津子
飛鳥川,永井裕子
オホーツク海岸,川野夏美
母情歌,井上由美子
ソーラン鴎唄,椎名佐千子
おんな泣かせ,三山ひろし
```

- その後、以下のコマンドをDamScrapingディレクトリにて以下のコマンドを打つ

```
php index.php
```

- すると、outputディレクトリにmusics.csvが作成される

- musics.csvは以下のように「曲名,歌手,コード,検索結果状態」を示す

```
人生花暦,鳥羽一郎,5077-14,完全一致
俺は浪花の暴れん坊,鏡五郎,6866-96,完全一致
野菊の君だから,北山たけし,1955-16,完全一致
横濱のブルース,北川大介,6443-04,完全一致
雪花角館,黒川真一朗,5339-41,完全一致
津軽の風,徳永ゆうき,2321-59,完全一致
はぐれ花,市川由紀乃,4053-43,完全一致
かぼちゃの花,中村美津子,2034-12,一部一致
飛鳥川,永井裕子,6371-18,完全一致
オホーツク海岸,川野夏美,5841-92,完全一致
母情歌,井上由美子,2547-54,完全一致
ソーラン鴎唄,椎名佐千子,6775-64,完全一致
おんな泣かせ,三山ひろし,1888-48,完全一致

```

- 曲名検索→そのリストの中から指定した歌手に一致するものがあるか？という手順での検索が行われている

- 検索結果状態に「完全一致」と示されているものについては、リストにあった歌手名と完全に一致している

- 検索結果状態に「一部一致」とある場合には、歌手名が一部一致している（なので、名字だけ指定したりした場合でも曲名が珍しければOKだと思う）

- 検索結果状態とコードが「一致無し」になる場合には自分で調べると良い

# 注意

- 文字コード変換とかを書いてないからExcelでぱっと開けない

- てきとーにnotepadとかで開いて文字コードUTF-8にしてくれるとありがたい