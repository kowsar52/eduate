<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title> Account Credential</title>
  <style>
    .container{
      text-align: center;
    }
    .container  small{
      color: green;
    }
  </style>
</head>
<body>
  <div class="container">
    <p>Hello <b>{{$name}}</b>! You are now Member of Eduate. <br>
         You can access your Account and manage your School Using Bellow Information.</p>
    <br>
    <b>Account Credential</b><br>
    ---------------------------------------- <br>
    ---------------------------------------- <br><br>
    <b>User ID : </b><i> {{$username}}</i><br>
    <b>Password : </b><i>{{$password}}</i><br>
    <br><br>
    <i>Thanks. For Any Kind of Help, Please Contact With Us.</i><br>
    <small>If you received this email by mistake, simply delete it. Thanks.</small>
  </div>
</body>
</html>