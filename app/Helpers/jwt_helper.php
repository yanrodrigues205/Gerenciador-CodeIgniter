<?php
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    function readToken($token)
    {   
        $key = "6R22lQVJVuWJxorJfeQww5NwsraIkpXVCJ9.eyJzdWIi0PjaOYhAMj9jNMO5YLm"; 
        $alg = "HS384";
        $data_token = JWT::decode($token, new Key($key, $alg));
        if(!$data_token)
        {
            return false;
        }
        return $data_token;
    }

?>