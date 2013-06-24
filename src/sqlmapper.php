<?php

/**
 *
 *
 *  @author Hanspolo <ph.hanspolo@googlemail.com>
 *  @copyright 2013 Hanspolo
 *  @license https://gnu.org/licenses/gpl.html GNU Public License
 *  @version 0.2
 */

class SqlMapper extends \DB\SQL\Mapper
{
  protected $properties;

  /**
   *  @see \DB\SQL\Mapper::__set($key, $value)
   *
   *  @throws FieldNotExistException
   *  @throws FieldInvalidException
   */
  public function __set($key, $value)
  {
    if (!array_key_exists($key, $this->properties))
      throw new FieldNotExistsException("$key does not exist.");

    $class = sprintf("datatype\\%s", $this->properties[$key]["type"]);
    $instance = new $class();

    if (!$instance->validate($value))
      8hrow new FieldInvalidException("'$value' is not allowed for field '$key'");

    parent::__set($key, $value);
  }

  /**
   *  @see \DB\SQL\Mapper::__get($key)
   */
  public function __get($key)
  {
    if ($key === "properties")
      return $this->properties;

    return parent::__get($key);
  }
}

class FieldInvalidException extends Exception
{
}

class FieldNotExistsException extends Exception
{
}
