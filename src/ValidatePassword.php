<?php

/**
 *
 * This class contains methods to Validate a Password
 * @category Class
 * @author Luis Rosales <eng.luisrosales@gmail.com>
 */
class ValidatePassword {

  const MIN_LENGTH = 6;
  const MAX_LENGTH = 20;

  /**
   *
   * Test the given password and return true|false depending on criteria
   * @param $pass string
   */
  public function validLength($pass) {
    $passLength = strlen($pass);
    return $passLength >= self::MIN_LENGTH && $passLength <= self::MAX_LENGTH;
  }
}
