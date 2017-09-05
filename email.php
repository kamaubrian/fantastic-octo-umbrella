<?php
session_start();
require_once 'lib/phpmailer/PHPMailerAutoload.php';

$errors =[];

if(isset($_POST['name'],$_POST['email'],$_POST['message'])){
    $fields=[
        'name'=>$_POST['name'],
        'email'=>$_POST['email'],
        'message'=>$_POST['message']
    ];
    foreach($fields as $field=>$data){
        if(empty($data)){
            $errors[]='The '.$field . ' field is required.';
        }
    }
    if(empty($errors)){

        $m=new PHPMailer;
        $m->isSMTP();
        $m->SMTPAuth=true;
        $m->Host='smtp.gmail.com';
        $m->Username='kamaubrian05@gmail.com';
        $m->Password='GACHOKAZ';
        $m->SMTPSecure='ssl';
        $m->Port=465;

        $m->isHTML();
        $m->Subject ='Contact form Submitted';
        $m->Body='From:'.$fields['name'].'('.$fields['email'].')<p>'.$fields['message'].'</p>';

        $m->FromName='Contact';
        $m->AddAddress('mtotodev@gmail.com','Brian');

        if ($m->send()) {
            header('Location:success.php');
            die();
        }else{
            $errors[]="Sorry ,Could not send email.Try again later.";
        }
    }
}else{
    $errors[]= 'Something went wrong';
}
$_SESSION['errors']=$errors;
//$_SESSION['fields']=$fields;
header ('Location:contact.html');