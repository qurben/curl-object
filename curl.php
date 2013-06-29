<?php
/**
 * Basic cURL wrapper for PHP
 * Copyright © 2013 Gerben Oolbekkink
 */
class CURL {
  private $ch;
  private $response;

  private $gz = false;

  public function __construct($url = null, $method = 'get', $postfields = false) {
    $this->ch = curl_init();

    $this->setOption(CURLOPT_RETURNTRANSFER,true);

    if(isset($url))
      $this->setUrl($url);

    if(strtolower($method) == 'post')
      $this->setOption(CURLOPT_POST,true);
    else
      $this->setOption(CURLOPT_POST,false);

    if($postfields!=false)
      $this->setPostfields($postfields);
  }

  /**
   * Set any option, a gateway for curl_setopt
   * @param key
   * The key for the option
   * @param value
   * The value for the option
   */
  public function setOption($key,$value) {
    if($key == CURLOPT_HTTPHEADER)
      return setHeader($value);
    else
      return curl_setopt($this->ch,$key,$value);
  }

  /**
   * Sets the url of the request
   * @param url
   * The url
   */
  public function setUrl($url) {
    return curl_setopt($this->ch,CURLOPT_URL,$url);
  }

  /**
   * Sets the header of the request
   * @param header
   * The header as array
   */
  public function setHeader($header) {
    $this->gz = (is_array($header) && in_array("Accept-Encoding: gzip",$header));

    return curl_setopt($this->ch,CURLOPT_HTTPHEADER,$header);
  }

  /**
   * Set the postfields for the request
   * @param fields
   * The fields, either as formatted string (id=9&value=5) or as an associative array (array('id'=>'9','value'=>'5'))
   */
  public function setPostfields($fields) {
    if(is_array($fields)) {
      $fields = http_build_query($fields,'','&');
    }

    return curl_setopt($this->ch,CURLOPT_POSTFIELDS,$fields);
  }

  /**
   * Execute the curl action
   * @return
   * The curl object
   */
  public function exec() {
    $this->response = curl_exec($this->ch);
    return $this;
  }

  public function close() {
    curl_close($this->ch);
  }

  public function getResponse() {
    if($this->gz)
      return gzdecode($this->response);
    else
      return $this->response;
  }
}