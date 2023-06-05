# HALU-33.github.io

このREADMEは、HTML、CSS、JavaScriptの学習の一環として作成したプロフィールページの技術メモとして、備忘録の役割を果たしています。


## 目次

index.html

style.css

main.js


## index.html

index.htmlは、このプロフィールページのメインとなるHTMLファイルです。HTMLは、Webページの構造を定義するためのマークアップ言語です。このファイルでは、Webページのヘッダー、本文、フッターなどの基本的な構造を定義しています。

### head
  
<meta name="viewport" content="width=device-width, initial-scale=1">: このメタタグは、ビューポートの幅をデバイスの幅に設定し、初期のズームレベルを1に設定します。これは、レスポンシブデザインを実現するために重要です。
  
<meta name="description" content="@HALU_33のプロフィールページ。">: このメタタグは、ウェブページの説明を提供します。これは、検索エンジンの結果ページに表示されることがあります。
  
<link rel="stylesheet" href="./style.css"/>: このリンクタグは、外部CSSファイル（この場合はstyle.css）をHTML文書にリンクします。
  
<title>@HALU_33</title>: このタグは、ウェブページのタイトルを設定します。これは、ブラウザのタブに表示され、検索エンジン結果ページにも表示されます。
  

### body
  
<i class="fab fa-twitter"></i>: このiタグは、Font AwesomeのTwitterアイコンを表示します。
  
<script src="./main.js"></script>: このスクリプトタグは、外部JavaScriptファイル（この場合はmain.js）をHTML文書にリンクします。
  


## style.css

style.cssは、このプロフィールページのスタイルを定義するCSSファイルです。CSSは、Webページのデザインやレイアウトを制御するためのスタイルシート言語です。このファイルでは、色、フォント、レイアウトなど、Webページの見た目に関するスタイルを定義しています。
  
@media screen and (max-width: 480px): このメディアクエリは、画面の幅が480px以下の場合に適用されるスタイルを定義します。これはレスポンシブデザインの一部で、デバイスの画面サイズに応じてスタイルを変更します。
  
.sns i: このセレクタは、snsクラスを持つ要素の中のi要素（アイコン）にスタイルを適用します。ここでは、フォントサイズとホバー時の変形を設定しています。
  
.sns i.fa-twitter, .sns i.fa-discord, .sns i.fa-youtube, .sns i.fa-spotify: これらのセレクタは、特定のSNSのアイコンに色を適用します。
  
.accordion-button: このクラスセレクタは、HTML文書のaccordion-buttonクラスを持つ要素にスタイルを適用します。ここでは、背景色、文字色、カーソルのスタイル、パディング、幅、テキストの配置、ボーダー、アウトライン、トランジションを設定しています。
  
.accordion-button:hover: このセレクタは、accordion-buttonクラスを持つ要素にマウスがホバーしているときにスタイルを適用します。ここでは、背景色を設定しています。
  
.accordion-body: このクラスセレクタは、HTML文書のaccordion-bodyクラスを持つ要素にスタイルを適用します。ここでは、パディング、背景色、マージンを設定しています。
  
.details-section: このクラスセレクタは、HTML文書のdetails-sectionクラスを持つ要素にスタイルを適用します。ここでは、マージンを設定しています。
  
.details-header: このクラスセレクタは、HTML文書のdetails-headerクラスを持つ要素にスタイルを適用します。ここでは、カーソルのスタイル、背景色、パディング、マージン、ボーダー、テキストの配置、フレックスボックスを使用して要素の配置を制御しています。
  
.details-header i: このセレクタは、details-headerクラスを持つ要素の中のi要素（アイコン）にスタイルを適用します。ここでは、マージンを設定しています。
  
.details-content: このクラスセレクタは、HTML文書のdetails-contentクラスを持つ要素にスタイルを適用します。ここでは、表示スタイル、背景色、パディング、ボーダーを設定しています。
  


## main.js
  
main.jsは、このプロフィールページの動的な振る舞いを制御するJavaScriptファイルです。JavaScriptは、Webページにインタラクティブな要素を追加するためのプログラミング言語です。このファイルでは、ユーザーの操作に応じてWebページがどのように反応するかを定義しています。
  
このJavaScriptファイルは、HTMLドキュメントが完全に読み込まれた後に実行されるスクリプトを含んでいます。具体的には、"detailsHeader"というIDを持つ要素と、"detailsContent"というIDを持つ要素に対して操作を行います。
  
document.addEventListener("DOMContentLoaded", function() {...});: この行は、HTMLドキュメントが完全に読み込まれた（DOMが構築された）時に実行される関数を登録しています。この関数内に記述されたコードは、ページが完全に読み込まれてから実行されます。
  
const detailsHeader = document.querySelector("#detailsHeader");: この行では、"detailsHeader"というIDを持つ要素を取得し、それをdetailsHeaderという定数に代入しています。document.querySelectorメソッドは、指定したCSSセレクタに一致する最初の要素を返します。
  
const detailsContent = document.querySelector("#detailsContent");: この行では、"detailsContent"というIDを持つ要素を取得し、それをdetailsContentという定数に代入しています。
  
detailsHeader.addEventListener("click", function() {...});: この行では、detailsHeader要素に対してクリックイベントリスナーを登録しています。この要素がクリックされると、指定した関数が実行されます。
  
const display = detailsContent.style.display;: この行では、detailsContent要素のdisplayスタイルプロパティの値を取得し、それをdisplayという定数に代入しています。
  
if (display === "none") {...} else {...}: この行では、displayの値が"none"（非表示）であるかどうかをチェックしています。もし"none"であれば、detailsContent要素を表示するためにdisplayプロパティを"block"に設定します。それ以外の場合（すでに表示されている場合）は、detailsContent要素を非表示にするためにdisplayプロパティを"none"に設定します。
