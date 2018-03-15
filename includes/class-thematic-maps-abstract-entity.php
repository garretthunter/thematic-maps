<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * @link       https://github.com/garretthunter
 * @since      1.0.0
 *
 * @package    Thematic_Maps
 * @subpackage Thematic_Maps/includes
 */

/**
 * Read-only data access class for accessing Google region names and codes
 *
 * @package    Thematic_Maps
 * @subpackage Thematic_Maps/includes
 * @author     Garrett Hunter <garrett.hunter@blacktower.com>
 */
abstract class Thematic_Maps_Abstract_Entity {

	/**
	 * @var array
	 */
	protected $attributes = [];

	/**
	 * @param array $body
	 */
	public function __construct(array $body)
	{
		$this->attributes = $body;
	}

	/**
	 * Retrieve attributes on the entity.
	 *
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function __get($key)
	{
		if (array_key_exists($key, $this->attributes) === true) {
			return $this->attributes[$key];
		}

		return null;
	}

	/**
	 * Set attributes on the entity.
	 *
	 * @param string $key
	 * @param mixed  $value
	 *
	 * @return void
	 */
	public function __set($key, $value)
	{
		$this->attributes[$key] = $value;
	}

	/**
	 * Determine if the given attribute exists.
	 *
	 * @param mixed $offset
	 *
	 * @return bool
	 */
	public function offsetExists($offset)
	{
		return isset($this->$offset);
	}

	/**
	 * Get the value for a given offset.
	 *
	 * @param mixed $offset
	 *
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		return $this->$offset;
	}

	/**
	 * Set the value for a given offset.
	 *
	 * @param mixed $offset
	 * @param mixed $value
	 *
	 * @return void
	 */
	public function offsetSet($offset, $value)
	{
		$this->$offset = $value;
	}

	/**
	 * Unset the value for a given offset.
	 *
	 * @param mixed $offset
	 *
	 * @return void
	 */
	public function offsetUnset($offset)
	{
		unset($this->$offset);
	}

	/**
	 * Determine if an attribute exists on the entity.
	 *
	 * @param string $key
	 *
	 * @return bool
	 */
	public function __isset($key)
	{
		return (isset($this->attributes[$key]));
	}

	/**
	 * Unset an attribute on the entity.
	 *
	 * @param string $key
	 *
	 * @return void
	 */
	public function __unset($key)
	{
		unset($this->attributes[$key]);
	}

}