<?php

namespace Diff\Patcher;

use Diff\DiffOp\Diff\Diff;

/**
 * Interface for objects that can apply an array of DiffOp on an array.
 *
 * @since 0.4
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface Patcher {

	/**
	 * Applies the applicable operations from the provided diff to
	 * the provided base value.
	 *
	 * @since 0.4
	 *
	 * @param array $base
	 * @param Diff $diffOps
	 *
	 * @return array
	 */
	public function patch( array $base, Diff $diffOps );

}
