<?php
/**
 * An interface that classes used for deserializing strings
 * should implement.
 * @author David Luecke (daff@neyeon.de)
 */
interface Rest_Deserialize_Interface
{
	/**
	 * Deserialize the data given. Usually returns an array, but
	 * might also return specific object instances.
	 * @param mixed The data to deserialize. Can e.g. be a plain string
	 * or a HTTP request object etc.
	 * @return mixed
	 */
	public function deserialize($data);
}