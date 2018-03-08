<?php

use \PHPUnit\Framework\TestCase;

class ValidatePasswordTest extends TestCase {

    public function testValidLength() {
      $valPass = new ValidatePassword();
      $this->assertFalse($valPass->validLength('12345678'));
    }
}
