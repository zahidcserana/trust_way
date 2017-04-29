<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 3/8/2016
 * Time: 9:16 PM
 */

class MailGun
{
    private $requestText;
    private $responseText;
    private $responseHttpCode;
                
    
    function SendEmailUsingMailGun($toEmail, $subject, $body)
    {
        $fromName = 'Signup';
        $fromEmail = 'zahid1004048@gmail.com';
        $url = 'https://api.mailgun.net/v3/sandboxbe3562eb97444275b22e5273a6bef6c8.mailgun.org/messages';
        $parameters = [
            'from'      =>  "{$fromName} <{$fromEmail}>",
            'to'        =>  $toEmail,
            'subject'   =>  $subject,
            'html'      =>  $body
        ];
        $request = http_build_query($parameters);
        $this->requestText = $request;
        
        $ch = curl_init($url);
        $options = [
            CURLOPT_RETURNTRANSFER => true,         // return web page
            CURLOPT_HEADER         => false,        // don't return headers
            CURLOPT_FOLLOWLOCATION => false,         // follow redirects
            CURLOPT_ENCODING       => "utf-8",           // handle all encodings
            CURLOPT_AUTOREFERER    => true,         // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 200,          // timeout on connect
            CURLOPT_TIMEOUT        => 200,          // timeout on response
            CURLOPT_POST           => 1,            // i am sending post data
            CURLOPT_POSTFIELDS     => $request,    // this are my post vars
            CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
            CURLOPT_SSL_VERIFYPEER => false,        //
            CURLOPT_VERBOSE        => 1,
            CURLOPT_USERPWD        => 'api:key-5f60c3d17917bd177e11948639622f15'

        ];
        curl_setopt_array($ch, $options);
        $data = curl_exec($ch);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        $this->responseText = $data;
        $this->responseHttpCode = $httpStatusCode;
        
        return [ 'response_code' => $httpStatusCode, 'data' => $data ];
        //return $data;
    }

    function GetLastAPICallInfo()
    {
        return [
                'request_text' => $this->requestText,
                'response_text' => $this->responseText,
                'response_http_code' => $this->responseHttpCode,
            ];
    }
}

                
