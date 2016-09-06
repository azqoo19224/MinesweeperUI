<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="jquery.js"></script>
</head>
<style>
	button{
		width:30px;
		height:30px;
		display: inline-block;
		margin-right: -4px;
        margin-top: -1px;
        background-color:#000000;
	}
</style>
<body >
    <div id="showBlock"></div>
    <div id="form">
        <form>
            <table align='center' valign="middle">
                
            <tr>
            <td><input type="text" id = "maxBomb" name="maxBomb" value='10'/></td><td>炸彈數</td>
            </tr>
            <tr>
            <td><input type="text" id = "length" name="length" value='10'/></td><td>長</td>
            </tr>
            <tr>
            <td><input type="text" id = "width" name="width" value='10'/></td><td>寬</td>
            </tr>
            <tr>
            <td colspan = 2><input type="button" onclick="btnOk()" value="開始遊戲"/></td>
            </tr>
            </table>
        </form>
    </div>
    <div id = "info" style="display: none">
        <h1 id="bob">剩餘炸彈:</h1>
        <h1 id="showMax"></h1>
        <input type="hidden" id="zCount" value=""/>
        <input id = "again" type="button" style="display: none" value="再來一次" onclick="again()"/>
    </div>


</body>
<script>
var con=0;
var v;
var $maxBomb;
var $length;
var $width;
var $count;
var maxCount = 0;
var zCount;
//在玩一次
function again() {
    location.href='https://azqooo-azqoo19224.c9users.io/Minesweeper/Minesweeper123.php';
}
//開始遊戲
function btnOk() {
    getData();
    $("#form").hide();
    $("#showMax").text($maxBomb);
    $("#info").show();
}
//抓取地圖資訊 && 設值
function getData() { 
    $maxBomb = $("#maxBomb").val();
    $length = $("#length").val();
    $width = Number($("#width").val());
    zCount = $("#maxBomb").val();
    $count = $width * $length;
    $.ajax(
    {
        type:"GET",
        url:"text.php?maxBomb="+$maxBomb+"&length="+$length+"&width="+$width,
        dataType:"text",
        error:function(Xhr)
        {
            alert("error");
        },
        success:function(json)
        { 
            var arr=JSON.parse(json);
            var str = arr.str.split(",");
            var val = arr.val.split(",");

            for(i = 0; i < str.length; i++){
                if (con%$width == 0) {
                    $("#showBlock").append("<br>");
                }
                $("#showBlock").append("<button id='"+str[i]+"' value="+val[i]+">-</button>");
                con++;
                
            }
                 go();
        }
  });
    
}
//取消右鍵選單
$(function(){
        $(document).bind("contextmenu",function(event){
            return false;
        });
  });
  
//  點擊執行功能
function go(){
            $("button").mousedown(function(){
            if (event.button == 0) {
                    if ($(this).text() == "!"){
                    } else if ($(this).val() == "M") {
                        $(this).text($(this).val());
                        $(this).css("background-color","#FF0000");
                        alert("你炸掉了! 哈哈哈哈哈哈哈哈 ^^");

                        location.href='https://azqooo-azqoo19224.c9users.io/Minesweeper/Minesweeper123.php';
                    }
                    else if ($(this).val() == "0") {
                        var $x = Number($(this).attr('id'));
                        $(this).text($(this).val());
                        $(this).css("background-color","#FFFFFF");
                        $(this).val("999");
                        maxCount++;
                        run($x);
                        
                        
                    } else if($(this).val() == "999") {

                    }    
                    else {
                        $(this).text($(this).val());
                        maxCount++;
                        $(this).val(999);
                        $(this).css("background-color","#FFFFFF");
                    }
                        if(maxCount >= $length*$width-$maxBomb){
                            endGame();
                        }
                }
            if(event.button == 2){

                if($(this).val() != 999){
                    if($(this).text() == "!"){
                        $(this).text("-");
                        $(this).css("background-color","#000000");
                        zCount++;
                        $("#showMax").text(zCount);

                    } else {
                        $(this).text("!");
                        $(this).css("background-color","#FF0000");
                        zCount--;
                        $("#showMax").text(zCount);
                    
                    }
                }
            }
        });
        //破關顯示
        function endGame(){
                alert("恭喜破關~");
                 $("#again").show();
                
        }
        //0相鄰連開
        function open($x) {
            if ($("#"+$x).val() == "0" && $("#"+$x).text() != "!") {
                $("#"+$x).text($("#"+$x).val());
                $("#"+$x).css("background-color","#FFFFFF");
                $("#"+$x).val("999");
                maxCount++;
                run($x);
           
            } else if($("#"+$x).text() != "!"){ 
                if($("#"+$x).val() != "999")
                maxCount++;
                $("#"+$x).text($("#"+$x).val());
                $("#"+$x).val("999");
                $("#"+$x).css("background-color","#FFFFFF");
            }
        }
    //判斷位置    
        function run($x) {
            var z1 = -1;
            var z2 = -1;
            var z3 = -1;
            var z4 = -1;
            var z5 = -1;
            var z6 = -1;
            var z7 = -1;
            var z8 = -1;
            //最左邊
            if($x%$width == 0) {
                 z2 = $x-$width;//上
                 z3 = $x-$width+1;//右上
                 z5 = $x+1;//右
                 z7 = $x+$width;//下
                 z8 = $x+$width+1;//右下
                
                if($count > z7 && z7 > -1 && $("#"+z7).val() != "999")
                    open(z7);
                if($count > z2 && z2 > -1 && $("#"+z2).val() != "999")
                    open(z2);
                if($count > z5 && z5 > -1 && $("#"+z5).val() != "999")
                    open(z5);
                if($count > z8 && z8 > -1 && $("#"+z8).val() != "999")
                    open(z8);
                if($count > z3 && z3 > -1 && $("#"+z3).val() != "999")
                    open(z3);
            //最右邊
            } else if ($x%$width == $width-1){
                 z1 = $x-$width-1;//左上
                 z2 = $x-$width;//上
                 z4 = $x-1;//左
                 z6 = $x+$width-1;//左下
                 z7 = $x+$width;//下

                if($count > z1 && z1 >-1 && $("#"+z1).val() != "999"){
                    open(z1);
                }
                if($count > z2 && z2 >-1 && $("#"+z2).val() != "999"){
                    open(z2);
                }
                if($count > z4 && z4 >-1 && $("#"+z4).val() != "999"){
                    open(z4);
                }
                if($count > z6 && z6 >-1 && $("#"+z6).val() != "999"){
                    open(z6);
                }
                if($count > z7 && z7 >-1 && $("#"+z7).val() != "999") {
                    open(z7);
                }
            } else {
                 search($x);
            }
            //遞迴
            function search(){
                z1 = $x-$width-1;
                z2 = $x-$width;
                z3 = $x-$width+1;
                z4 = $x-1;
                z5 = $x+1;
                z6 = $x+$width-1;
                z7 = $x+$width;
                z8 = $x+$width+1;
            
                if($count > z1 && z1 >-1 && $("#"+z1).val() != "999")
                    open(z1);
                if($count > z2 && z2 >-1 && $("#"+z2).val() != "999")
                    open(z2);
                if($count > z3 && z3 >-1 && $("#"+z3).val() != "999")
                    open(z3);
                if($count > z4 && z4 >-1 && $("#"+z4).val() != "999")
                    open(z4);
                if($count > z5 && z5 >-1 && $("#"+z5).val() != "999")
                    open(z5);
                if($count > z6 && z6 >-1 && $("#"+z6).val() != "999")
                    open(z6);
                if($count > z7 && z7 >-1 && $("#"+z7).val() != "999")
                    open(z7);
                if($count > z8 && z8 >-1 && $("#"+z8).val() != "999")
                    open(z8);
                
            }
        }
}

        </script>
       
    </head>
    <body>
    </body>
</html>