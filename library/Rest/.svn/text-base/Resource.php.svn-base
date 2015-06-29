<?php
/**
 * Interface implemented by RESTful resources.
 * @author David Luecke (daff@neyeon.de)
 *
 */
interface Rest_Resource
{
	/**
	 * Return a list of all resources.
	 * @param $params A list of additional parameters
	 * given (e.g. paging and sorting parameters).
	 * @return array
	 */
	//public function index($params = null);

	/**
	 * Get a resource by a given id.
	 * @param $id The id to use. Can be an array, too
	 * which will represent a sub path in this resource.
	 * @param $params Additional parameters given
	 * @return array | object
	 */
	public function get($id, $params = null);

	/**
	 * POST to that resource. Usually used
	 * to create a new instance.
	 * @param $data An associative array of
	 * the data given.
	 * @param $params Additional parameters given
	 * @param $id The id of the object to update.
	 * @return array
	 */
	//public function post($data, $params = null);

	/**
	 * @param $data
	 * @param $params
	 * @return unknown_type
	 */
	//public function put($data, $id = null, $params = null);

	/**
	 * @param $id
	 * @param $params
	 * @return unknown_type
	 */
	//public function delete($id, $params = null);
}