<?php
    require_once('connect.php');
    require_once('token.php');

  function generate($username, $new, $db)
  {
    $header= [
      'typ' => 'JWT',
      'alg' => 'HS256',
      'dev' => 'Fernando,Luigie May L.'
    ];

    $header = json_encode($header);
    $header = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

    
    $sql = "SELECT * FROM tbl_std WHERE username = '$username'";
	$result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result);


    $payload = [
      'id' => $row['id'],
      'username' => $row['username']
      
    ];

    $payload = json_encode($payload);
    $payload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

    $signature = hash_hmac('sha256', $header.".".$payload, base64_encode('123'));
    $signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

    $jwt = "$header.$payload.$signature";
    return $jwt;
  }

 function validateToken($username, $userToken, $db){
      
    $existingToken = generate($username, 1, $db);

        if($userToken===$existingToken){
            echo "1";
        }else{
            echo "0";
        }
    }
    

?>
