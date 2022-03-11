<?php

namespace App;

use Illuminate\Contracts\Encryption\Encrypter as EncrypterContract;
use phpseclib\Crypt\Blowfish;

class BlowfishEncrypter implements EncrypterContract
{
  protected $encrypter;

  public function __construct(string $key)
  {
    $this->encrypter = new Blowfish();
    $this->encrypter->setKey($key);
  }

  public function encrypt($value, $serialize = true)
  {
    return $this->encrypter->encrypt($value);
  }

  public function decrypt($payload, $unserialize = true)
  {
    return $this->encrypter->decrypt($payload);
  }
}
