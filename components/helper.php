<?php

    class Helper
    {
        public static function generateToken($size = 32):string
        {
            $symbols = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'e', 'f', 'g'];
            $symbolsLength = count($symbols);
            $token = "";
            for ($i = 0; $i < $size; $i++) {
                $token .= $symbols[rand(0, $symbolsLength - 1)];
            }
            return $token;
        }

        public static function checkCaptcha($token)
        {
            $ch = curl_init("https://smartcaptcha.yandexcloud.net/validate");
            $args = [
                "secret" => SMARTCAPTCHA_SERVER_KEY,
                "token" => $token,
                "ip" => $_SERVER['REMOTE_ADDR'], // Нужно передать IP-адрес пользователя.
                // Способ получения IP-адреса пользователя зависит от вашего прокси.
            ];
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($args));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpcode !== 200) {
                echo "Allow access due to an error: code=$httpcode; message=$server_output\n";
                return true;
            }

            $resp = json_decode($server_output);
            return $resp->status === "ok";
        }


}
