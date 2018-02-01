<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>kagayaの留言板</title>
    <link href="style.css" rel="stylesheet" type="text/css"> 
    <link href="button.css" rel="stylesheet" type="text/css">

<?php
//error_log("error_message",3,"PHPerror.txt");
require_once('item.php');
require_once('database.php');

$mesgBuf = array();
$db = new DB();//create database object
$nameErr = $emailErr = $genderErr ="";

function loadData()
{
    //echo "load_begin ";
    global $db;
    global $mesgBuf;
    $sql = "SELECT * FROM `all_message` ORDER BY `ID` DESC";
    $result = mysqli_query($db->conn,$sql);

    while($row = mysqli_fetch_array($result))
    {        
        //echo "attribute:".$row['attribute']."<br>";
        $temp = new item($row['name'],$row['email'],$row['gender'],$row['content'],$row['time'],$row['attribute']);
        array_push($mesgBuf,$temp);
    }   
    //echo var_dump($mesgBuf);
    //echo "load_end ";
}

function showAllMessage()
{
    global $mesgBuf;
    loadData();
    foreach($mesgBuf as $m){
        $m->show_item();
    }
}

function saveData($n,$e,$g,$c,$t,$a)
{
    global $db;
    $sql = "INSERT INTO `all_message`(`name`,`email`,`gender`,`content`,`time`,`attribute`)
    VALUES ('".$n."','".$e."','".$g."','".$c."','".$t."','".$a."');";
    //echo $sql;
    //echo '$db->conn:'.var_dump($db->conn);
    //$link = mysqli_connect("localhost","root","899072","messagedb");
    if(!mysqli_query($db->conn,$sql)){
        die("save data fail:".mysqli_error($db->conn));
    }else{
        $url = "./success.html";
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url';";
        echo "</script>";
    }
}

function test_input($data)
{
    $data = trim($data); //去除不必的字符（多余的空格 制表符 换行符）
    $data = stripslashes($data);//去除反斜线
    $data = htmlspecialchars($data);
    return $data;
}
function check_input()//符合要求返回1，否则给报错变量赋值
{
    global $nameErr,$genderErr,$emailErr;
    $insertFlag = 1;
    if(empty($_POST['name'])){
        $nameErr = "Nickname is required";
        $insertFlag &= 0;
    }
    if(empty($_POST['gender'])){
        $genderErr = "Gender is required";
        $insertFlag &= 0;            
    }
    if(!empty($_POST['email'])){
        if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",test_input($_POST["email"]))){
            $emailErr = "Invalid email address";
            $insertFlag &= 0;
        }
    }
    
    return $insertFlag;
}

//从这里开始
if($_SERVER['REQUEST_METHOD']=='POST'){
    if(check_input()){
        $time = date("Y-m-d H:s:i");
        //saveData('yzh','123@qq.com','male','PHP is the best language!',$time);
        saveData($_POST['name'],$_POST['email'],$_POST['gender'],$_POST['content'],$time,$_POST['attribute']);
    }
    //showAllMessage();
}
// if(saveData('yzh','156@ads.com','male','test~are you ok!',data("Y-m-d H:s:i"))){
//     echo "save success!";
// }
?> 

</head>

<body> 
    <div class="header">
        <p id="caption">Hatsune Miku 10周年おめでとう</p>
        <div class="nav">

        </div>
    </div>
    <div class="main">
        <div id="miku">
            <a href="https://zh.moegirl.org/%E5%88%9D%E9%9F%B3%E6%9C%AA%E6%9D%A5#.E5.88.9D.E9.9F.B3.E6.9C.AA.E6.9D.A5_V4X" target="_blank">
            <img src="img/Hatsune_miku_v4x.png" ></a>
        </div>
        
        <div class="container">
            <div class="sub_container">
                <p id="sub_caption">ようこそ！kagayaのmessage boxへ</p>
                <p class="time"><b>欢迎来到我的留言板！今天是<?php echo date("Y-m-d l");?></b></p>
                <form class="userinfo" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" >               
                Nickname:<input type="text" name="name" placeholder="input a name you like"><span class="error">*<?php echo $nameErr?></span>
                 <br>
                E-mail(选填):<input type="text" name="email" placeholder="you@email.com" ><span class="error"><?php echo $emailErr?></span>
                  <br> 
                Gender:<input type="radio" name="gender" id="male" value="male"><label for="male">male</label> 
                    <input type="radio" name="gender" id="female" value="femail"><label for="female">female</label>
                    <input type="radio" name="gender" id="secret" value="secret"><label for="none">secret</label>
                 <span class="error">*<?php echo $genderErr?></span>
                 <br>
                    Message:<br><textarea class="text" rows="10" cols="40" name="content" placeholder="想对我说点什么呢？" required><?php echo $message?></textarea>
                 <br>
                    <input id="public" type="radio" name="attribute" value="public" checked><label for="public">public</label>  
                    <input id="privacy" type="radio" name="attribute" value="privacy"><label for="privacy">privacy</label>              
                    <input type="submit" class="button" name="Submit" value="发布">
                </form>
            </div>
            <br><br>
            <div calss="allMessage">
            <?php showAllMessage();?>
            </div>
        </div>
    </div>
    <div class="footer">
        <span>Copyright© 1997-<?php echo date("Y")?> made by kagaya</span>
    </div>

</body>

</html>