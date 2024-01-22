<?php
$namea = $_POST['姓'];
$nameb = $_POST['名'];
$bng = $_POST['bng'];
$birthday = $_POST['birthday'];
$pid = $_POST['pid'];
$phone = $_POST['phone'];
$jsmail = $_POST['jsmail'];
$food = $_POST['food'];
$healthy=$_POST['healthy'];
$others = $_POST['others'];
 
require_once("./TCPDF-master/tcpdf.php");
$pdf=new TCPDF();

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();
$pdf->SetFont('stsongstdlight','', 25);

$html = <<<EOF

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link type = "text/css" href = "styles.css">
        em       { font-weight: bold;color: black; }
        h1       { font-family: tahoma, helvetica, sans-serif; }
        p        { font-size: 12pt;font-family: arial, sans-serif; }
        .special { color: purple; }
		table,th,td { border:1px solid black; }
        #table { margin-left: 650px;  border-collapse: collapse; }
      </style>

    </style>
</head>
<body>
<h2>四資迎新報名確認表</h2>
<table>
<tr>
    <td colspan = "2" >
		姓:$namea
    </td>
    <td colspan = "2" >
		名字:$nameb
    </td>
	<td colspan = "2" >
		性別:$bng
    </td>
</tr>
<tr>
    <td colspan = "6">生日:$birthday</td>
</tr>
<tr>
    <td colspan = "6">身分證字號:$pid</td>
</tr>
<tr>
	<td colspan = "6">手機號碼:$phone</td>
</tr>
<tr>
    <td colspan = "6">
		Email:$jsmail
	</td>
</tr>
<tr>
    <td colspan = "3">飲食習慣:$food</td>
	<td colspan = "3">特殊疾病:$healthy</td>
</tr>
<tr>
    <td rowspan ="3" colspan = "6">其他:$others</td>
</tr>
</table>

</body>

EOF;
$pdf->writeHTMLCell(190,50,'','',$html,0,50,0,true,'',true);
$pdf->Output('example_011.pdf', 'I');


require_once('./PHPMailer-master/PHPMailerAutoload.php');
   
    $mail= new PHPMailer();                    
    $mail->SMTPDebug = 2;                        
    $mail->IsSMTP();                           
    $mail->SMTPAuth = true;                    //設定SMTP需要驗證
    $mail->SMTPSecure = "ssl";                 // Gmail的SMTP主機需要使用SSL連線
    $mail->Host = "smtp.gmail.com";            //Gamil的SMTP主機
    $mail->Port = 465;                         //Gamil的SMTP主機的埠號(Gmail為465)。
    $mail->CharSet = "utf-8";                  
    $mail->Username = "jschen9999@gmail.com";     //Gamil帳號
    $mail->Password = "j1020180";                 //Gmail密碼
    $mail->From = "jschen9999@gmail.com";         //寄件者信箱
    $mail->FromName = "jessie";                   //寄件者姓名
    $mail->Subject ="四資迎新";                   //郵件標題
    $mail->Body = "親愛的 ".$nameb."(".$jsmail.")，您好!以下為您的報名資料：<br /><br />性別:".$bng."<br />生日:".$birthday."
			<br />身分證字號:".$pid."<br />手機號碼:".$phone."<br />飲食習慣:".$food."<br />健康狀況:".$healthy."<br />其他:".$others.//郵件內容
    $mail->addAttachment('qrcodepic.png','qrcode'); //附件
    $mail->IsHTML(true);                             
    $mail->AddAddress("$jsmail");              //收件者郵件及名稱
    if(!$mail->Send()){
        echo "確認信未寄出" . $mail->ErrorInfo;
    }else{
        echo "<b>確認信已寄出</b>";
    }

 $conn = mysqli_connect("localhost", "jessie", "000000");
    if(mysqli_select_db($conn,"web_hw2" ))
    {
    mysqli_query( $conn, "SET NAMES 'utf8'");
	mysqli_query($conn,  "SET collation_connection = 'utf8_general_ci'");

      $SQL="CREATE TABLE $nameb select '$namea' As 姓,'$nameb' As 名,'$bng' As 性別,'$birthday' As 生日,'$pid' As 身分證字號,'$jsmail' As mail,'$food' As 飲食習慣,'$healthy' As 身體狀況,'$others' As 其他";
 
	mysqli_query( $conn,$SQL);
     }
    else
     {
      echo "Fail";
     }

?>

