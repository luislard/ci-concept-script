<?php

class ValidatePassword {

  const MIN_LENGTH = 6;
  const MAX_LENGTH = 20;

  public function validLength($pass) {
    $passLength = strlen($pass);
    return $passLength >= self::MIN_LENGTH && $passLength <= self::MAX_LENGTH;
  }
}
