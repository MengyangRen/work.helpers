<?php

namespace Diff\DiffOp;

/**
 * Interface for diff operations. A diff operation
 * represents a change to a single element.
 * In case the elements are maps or diffs, the resulting operation
 * can be a MapDiff or ListDiff, which contain their own list of DiffOp objects.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface DiffOp extends \Serializable, \Countable {

	/**
	 * Returns a string identifier for the operation type.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getType();

	/**
	 * Returns if the operation is atomic, opposing to it
	 * being a composite that can contain one or more child elements.
	 *
	 * @since 0.1
	 *
	 * @return bool
	 */
	public function isAtomic();

	/**
	 * Returns the DiffOp in array form.
	 *
	 * All element of the array with either be primitives or arrays, with the exception
	 * of complex values. For instance an add operation containing an object will have this
	 * object in the resulting array.
	 *
	 * This array form is particularly useful for serialization, as you can feed it
	 * to serialization functions such as json_encode() or serialize(), keeping in mind
	 * you might need extra handling for complex objects contained in the DiffOp.
	 *
	 * Roundtrips with DiffOpFactory::newFromArray.
	 *
	 * @since 0.5
	 *
	 * @param callable|null $valueConverter optional callback used to convert any
	 *        complex values to arrays.
	 *
	 * @return array
	 */
	public function toArray( $valueConverter = null );

}
