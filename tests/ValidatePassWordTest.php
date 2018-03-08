<?php

use \PHPUnit\Framework\TestCase;

class ValidatePasswordTest extends TestCase {

    public function testValidLength() {
      $valPass = new ValidatePassword();
      return $this->assertFalse($valPass->validLength('1234asdfafsdf'));
    }
}
