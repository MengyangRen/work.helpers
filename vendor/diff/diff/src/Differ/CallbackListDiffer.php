<?php

namespace Diff\Differ;

use Diff\ArrayComparer\StrategicArrayComparer;
use Diff\Comparer\CallbackComparer;
use Diff\DiffOp\DiffOp;

/**
 * Differ that only looks at the values of the arrays (and thus ignores key differences).
 * Values are compared via callback.
 *
 * Quantity matters: [42, 42] and [42] are different
 *
 * @since 0.5
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class CallbackListDiffer implements Differ {

	/**
	 * @var ListDiffer
	 */
	private $differ;

	/**
	 * @since 0.5
	 *
	 * @param callable $comparisonCallback
	 */
	public function __construct( $comparisonCallback ) {
		$this->differ = new ListDiffer(
			new StrategicArrayComparer( new CallbackComparer( $comparisonCallback ) )
		);
	}

	/**
	 * @see Differ::doDiff
	 *
	 * @since 0.5
	 *
	 * @param array $oldValues The first array
	 * @param array $newValues The second array
	 *
	 * @return DiffOp[]
	 */
	public function doDiff( array $oldValues, array $newValues ) {
		return $this->differ->doDiff( $oldValues, $newValues );
	}

}
