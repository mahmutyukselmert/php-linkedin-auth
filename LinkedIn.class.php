<?php

namespace myPHPNotes;

class LinkedIn  
{
    protected $app_id;
    protected $app_secret;
    protected $callback;
    protected $csrf;
    protected $scopes;
    protected $ssl;
    private $token;
    public function __construct(string $app_id, string $app_secret, string $callback, string $scopes, bool $ssl = true)
    {
        $this->app_id = $app_id;
        $this->app_secret = $app_secret;
        $this->scopes =  $scopes;
        $this->csrf = random_int(111111,99999999999);
        $this->callback = $callback;
        $this->ssl = $ssl;

        $this->token = null;
        if (isset($_SESSION['LinkedInAccessToken'])) {
            $this->token = $_SESSION['LinkedInAccessToken'];
        }
    }
    public function getAuthUrl()
    {
        $_SESSION['linkedincsrf'] = $this->csrf;
        return "https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=". $this->app_id . "&redirect_uri=".$this->callback ."&state=". $this->csrf."&scope=". $this->scopes;
    }
    public function getAccessToken($code)
    {
        $url = "https://www.linkedin.com/oauth/v2/accessToken";
        $headers = [
            "Content-Type" => "application/x-www-form-urlencoded"
        ];
        $parameters = [
            'client_id' => $this->app_id,
            'client_secret' => $this->app_secret,
            'redirect_uri' => $this->callback,
            'code' => $code,
            'grant_type' => 'authorization_code',
        ];
        $response = $this->request('GET', $url, $headers, $parameters);

        $accessToken = json_decode($response)->access_token;
        return $accessToken;
    }
    public function setToken($token) 
    {
        $this->token = $token;
        $_SESSION['LinkedInAccessToken'] = $token;
    }
    public function getToken() 
    {
        if (isset($_SESSION['LinkedInAccessToken'])) {
            $this->token = $_SESSION['LinkedInAccessToken'];
        } else {
            return false;
        }
        return $this->token;
    }
    public function request($method, $url, $headers = [], $parameters = "") 
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->ssl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if ( is_array($headers) && !array_key_exists('Content-Type', $headers) ) {
            $headers['Content-Type'] = 'application/x-www-form-urlencoded'; 
        }
        
        if (!empty($parameters)) {
            if ( in_array("application/x-www-form-urlencoded", $headers) ) {
                $parameters = http_build_query($parameters);
            } else {
                $parameters = json_encode($parameters);
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        }

        $formattedHeaders = [];
        foreach ($headers as $key => $value) {
            $formattedHeaders[] = "$key: $value";
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $formattedHeaders);

        $result = curl_exec($ch);

        if(curl_errno($ch)) {
            throw new \Exception(curl_error($ch));
        }

        curl_close($ch);
        return $result;
    }
    public function getProfileInfo()
    {
        $url = "https://api.linkedin.com/v2/userinfo";
        $headers = [
            'Authorization' => "Bearer ".$this->getToken()
        ];
        $response = $this->request('GET', $url, $headers);
        $response = json_decode($response);
        return $response;
    }
    public function linkedInTextPost($accessToken, $person_id, $message, $visibility = "PUBLIC")
    {
        $parameters = [
            "author" => "urn:li:person:" . $person_id,
            "lifecycleState" => "PUBLISHED",
            "specificContent" => [
                "com.linkedin.ugc.ShareContent" => [
                    "shareCommentary" => [
                        "text" => $message
                    ],
                    "shareMediaCategory" => "NONE",
                ],
                
            ],
            "visibility" => [
                "com.linkedin.ugc.MemberNetworkVisibility" => $visibility,
            ]
        ];

        $url = "https://api.linkedin.com/v2/userinfo";
        $headers = [
            'Authorization' => "Bearer ".$this->getToken(),
            'Content-Type' => "application/json"
        ];
        $response = $this->request('POST', 'https://api.linkedin.com/v2/ugcPosts', $headers, $parameters);
        $response = json_decode($response,true);
        return $response;
    }
}