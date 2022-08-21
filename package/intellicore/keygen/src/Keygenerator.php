<?php

class KeyGenerator
{
  /** @var array **/
  static $shifts = [[0,5,2], [1,7,4,9], [6,3,8]];

  /**
   * @param int $pin
   *
   * @return bool
   */
  private static function isPalindrome(int $pin): bool
  {
    $reversedPin = implode(array_reverse(str_split($pin)));

    return (int) $reversedPin === (int) $pin;
  }

  /**
   * @param int $pin
   *
   * @return bool
   */
  private static function isPinValidate(int $pin): bool
  {
    if (self::isPalindrome($pin)) {
      return false;
    }

    return true;
  }

  /**
   * @param int $first
   * @param int $second
   *
   * @return bool
   */
  private static function isSequential(?int $first, ?int $second): bool
  {
    if ($first === $second // prevent repeating
      || $first === ($second + 1) // prevent sequential
      || $first === ($second - 1) // prevent reverse sequential
    ) {
      return true;
    }

    return false;
  }

  /**
   * @param int $digits
   *
   * @return string
   */
  public static function generatePin(int $digits = 4): string
  {
    $cursor = rand(0, 2);
    $pin = [];
    $lastDigit = null;

    while (count($pin) < $digits) {
      $shift = static::$shifts[$cursor];
      $currentDigit = $shift[rand(0, count($shift) - 1)];

      if (!static::isSequential($lastDigit, $currentDigit)) {
        $pin[] = $currentDigit;
        $lastDigit = $currentDigit;
      }
  
      $cursor++;
      if ($cursor > 2) {
        $cursor = 0; // reset precision
      }
    }
  
    return implode($pin);
  }

  /**
   * @param int $num - number of pins to generate
   * @param int $digits - length of each pin to generate
   *
   * @return array - generated pins
   */
  public static function generatePins(int $num, int $digits = 4): array
  {
    $pins = [];
    // continue generating pins that are unique
    // until we reach the number we want
    while (count($pins) < $num) {
      $pin = static::generatePin($digits);
      // add validation here
      if (self::isPinValidate($pin)) {
        // use an associative array to remove duplicates
        $pins[$pin] = 1;
      }
    }

    return array_keys($pins);
  }
}

$pins = KeyGenerator::generatePins(100, 4);
for ($i = 0; $i < count($pins); $i++) {
  print_r($pins[$i] . "<br>");
}