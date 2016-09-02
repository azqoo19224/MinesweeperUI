<?php
header("Content-Type:text/html; charset=utf-8");
$maxBomb = $_POST["maxBomb"];
$length = $_POST["length"];
$width = $_POST["width"];

for($x=0; $x<$length; $x++){
    for($y=0; $y<$width; $y++){
        $arr[$x][$y]='0';
    }
}

for($setBomb = 0; $setBomb < $maxBomb; $setBomb++) {
    while(true) {
        // 隨機產生一個炸彈
        $row = rand(0, $length-1);
        $column = rand(0, $width-1);
        if ($arr[$row][$column] != 'M') {
            $arr[$row][$column] = 'M';
            break;
        }
    }
}

for($x = 0; $x < $length; $x++){
    for($y = 0; $y < $width; $y++){
        if($arr[$x][$y]!= 'M'){
            if ($arr[$x+1][$y] == 'M') {
                $arr[$x][$y]++;
            }
            if ($arr[$x-1][$y] == 'M') {
                $arr[$x][$y]++;
            }
            if ($arr[$x][$y+1] == 'M') {
                $arr[$x][$y]++;
            }
            if ($arr[$x][$y-1] == 'M') {
                $arr[$x][$y]++;
            }
            if ($arr[$x+1][$y+1] == 'M') {
                $arr[$x][$y]++;
            }
            if ($arr[$x-1][$y-1] == 'M') {
                $arr[$x][$y]++;
            }
            if ($arr[$x-1][$y+1] == 'M') {
                $arr[$x][$y]++;
            }
            if ($arr[$x+1][$y-1] == 'M') {
                $arr[$x][$y]++;
            }
        }
    }
}
$x=0;
$y=0;
foreach($arr as $value) {
    $y=0;
    foreach ($value as $val) {
        echo "<button id='".($x*$width+$y)."' value=".$val.">-</button>";
        $y++;
    }
    echo "<br>";
    $x++;
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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

<h1>剩餘炸彈:</h1>
<h1 id="showMax"><?php echo $maxBomb;?></h1>
<input type="hidden" id="zCount" value="<?php echo $maxBomb;?>"/>

<div id="showBlock"></div>



</body>
<script>
var v;
var $maxBomb = "<?php echo $maxBomb;?>";
var $length = "<?php echo $length;?>";
var $width = Number("<?php echo $width;?>");
var $count = $width*$length;
var maxCount=0;
var zCount="<?php echo $maxBomb;?>";
    $(function(){
        $(document).bind("contextmenu",function(event){
            return false;
        });
  });
        $("button").mousedown(function(){
            if (event.button == 0) {
                  
                    if ($(this).text() == "!"){
                    } else if ($(this).val() == "M") {
                        $(this).text($(this).val());
                        $(this).css("background-color","#FF0000");
                        alert("你炸掉了! 哈哈哈哈哈哈哈哈 ^^");

                        location.href='https://azqooo-azqoo19224.c9users.io/Game/Minesweeper123.php';
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
                 $("#showBlock").append('<input type="button" value="再來一次" onclick="ok()"/>');
                
        }
        function ok(){
            location.href='https://azqooo-azqoo19224.c9users.io/Game/Minesweeper123.php';
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
</script>
</html>
<!--//http://k.swd.cc/learnGitBranching-ja/-->
<!--http://learngitbranching.js.org/-->