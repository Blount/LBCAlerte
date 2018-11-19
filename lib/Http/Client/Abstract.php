<?php

abstract class HttpClientAbstract
{
    protected $_proxy_type;
    protected $_proxy_ip;
    protected $_proxy_port;
    protected $_proxy_user;
    protected $_proxy_password;
    protected $_url;
    protected $_method;
    protected $_user_agent;
    protected $_body;
    protected $_download_body = true;
    protected $_respond_code;
    protected $_follow_location;
    protected $_location;
    protected $_cookie_path;
    protected $_referer;
    protected $_headers;
    protected $_response_headers;
    protected $_time_between_requests;
    protected $_time_last_request;

    protected $_default_headers = array(
        "Accept" => "text/html",
        "Accept-Language" => "fr,fr-FR;q=0.8",
        "Cache-Control" => "max-age=0",
        "Connection" => "keep-alive",
        "DNT" => 1,
        "Upgrade-Insecure-Requests" => 1,
    );

    const METHOD_GET = "get";
    const METHOD_POST = "post";

    const PROXY_TYPE_HTTP = 1;
    const PROXY_TYPE_SOCKS5 = 2;
    const PROXY_TYPE_WEB = 3;

    /**
     * @param string $ip
     * @return HttpClientAbstract
     */
    public function setProxyType($type)
    {
        if ($type != self::PROXY_TYPE_HTTP && $type != self::PROXY_TYPE_SOCKS5 && $type != self::PROXY_TYPE_WEB) {
            throw new Exception("Type de proxy invalide.");
        }
        $this->_proxy_type = $type;
        return $this;
    }

    public function getProxyType()
    {
        return $this->_proxy_type;
    }

    /**
     * @param string $ip
     * @return HttpClientAbstract
     */
    public function setProxyIp($ip)
    {
        if (0 === strpos($ip, "http://") || 0 === strpos($ip, "https://")) {
            $this->setProxyType(self::PROXY_TYPE_WEB);
        } elseif (0 === strpos($ip, "socks") {
            $this->setProxyType(self::PROXY_TYPE_SOCKS5);
        } else {
            $this->setProxyType(self::PROXY_TYPE_HTTP);
        }
        $this->_proxy_ip = $ip;
        return $this;
    }

    public function getProxyIp()
    {
        return $this->_proxy_ip;
    }

    /**
    * @param int $proxy_port
    * @return HttpClientAbstract
    */
    public function setProxyPort($proxy_port)
    {
        $this->_proxy_port = $proxy_port;
        return $this;
    }

    /**
    * @return int
    */
    public function getProxyPort()
    {
        return $this->_proxy_port;
    }

    /**
    * @param string $proxy_user
    * @return HttpClientAbstract
    */
    public function setProxyUser($proxy_user)
    {
        $this->_proxy_user = $proxy_user;
        return $this;
    }

    /**
    * @return string
    */
    public function getProxyUser()
    {
        return $this->_proxy_user;
    }

    /**
     * @return boolean
     */
    public function hasProxy()
    {
        return !empty($this->_proxy_ip) && !empty($this->_proxy_port);
    }

    /**
    * @param string $proxy_password
    * @return HttpClientAbstract
    */
    public function setProxyPassword($proxy_password)
    {
        $this->_proxy_password = $proxy_password;
        return $this;
    }

    /**
    * @return string
    */
    public function getProxyPassword()
    {
        return $this->_proxy_password;
    }

    /**
    * @param string $user_agent
    * @return HttpClientAbstract
    */
    public function setUserAgent($user_agent)
    {
        $this->_user_agent = $user_agent;
        return $this;
    }

    /**
    * @return string
    */
    public function getUserAgent()
    {
        return $this->_user_agent;
    }

    /**
     * @param string $method
     * @throws Exception
     * @return HttpClientAbstract
     */
    public function setMethod($method)
    {
        if ($method != self::METHOD_GET && $method != self::METHOD_POST) {
            throw new Exception("Méthode invalide.");
        }
        $this->_method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->_method;
    }

    /**
     * Définit l'URL à appeler.
     * @param string $url
     * @return HttpClientAbstract
     */
    public function setUrl($url)
    {
        $this->_url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * @param string $cookie_path
     * @return HttpClientAbstract
     */
    public function setCookiePath($cookie_path)
    {
        $this->_cookie_path = $cookie_path;
        return $this;
    }

    /**
     * @return string
     */
    public function getCookiePath()
    {
        return $this->_cookie_path;
    }

    /**
     * @param string $location
     * @return HttpClientAbstract
     */
    public function setLocation($location)
    {
        $this->_location = $location;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->_location;
    }

    /**
     * @param bool $follow_location
     * @return HttpClientAbstract
     */
    public function setFollowLocation($follow_location)
    {
        $this->_follow_location = $follow_location;
        return $this;
    }

    /**
     * @return bool
     */
    public function getFollowLocation()
    {
        return $this->_follow_location;
    }

    /**
     * @param bool $download_body
     * @return HttpClientAbstract
     */
    public function setDownloadBody($download_body)
    {
        $this->_download_body = (bool)$download_body;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->_body;
    }

    /**
     * @param time_between_requests $time_between_request
     * @return HttpClientAbstract
     */
    public function setTimeBetweenRequests($time_between_request)
    {
        $this->_time_between_requests = $time_between_request;
        return $this;
    }

    /**
     * @return time_between_requests
     */
    public function getTimeBetweenRequests()
    {
        return $this->_time_between_requests;
    }

    /**
     * @return int
     */
    public function getRespondCode()
    {
        return $this->_respond_code;
    }

    /**
     * @param float $time_last_request
     * @return HttpClientAbstract
     */
    public function setTimeLastRequest($time_last_request)
    {
        $this->_time_last_request = $time_last_request;
        return $this;
    }

    /**
     * @return float
     */
    public function getTimeLastRequest()
    {
        return $this->_time_last_request;
    }

    /**
     * @param string $name
     * @param string $value
     * @return HttpClientAbstract
     */
    public function setHeader($name, $value)
    {
        $this->_headers[$name] = $value;
        return $this;
    }

    /**
     * @param string $name
     * @return HttpClientAbstract
     */
    public function removeHeader($name)
    {
        unset($this->_headers[$name]);
        return $this;
    }

    /**
     * Retourne la dernière erreur générée.
     * @return string
     */
    abstract function getError();

    abstract function request();
}
