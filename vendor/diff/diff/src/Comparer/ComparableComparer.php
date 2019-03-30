<?php

namespace Diff\Comparer;

/**
 * Value comparer for objects that provide an equals method taking a single argument.
 *
 * @since 0.9
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ComparableComparer implements ValueComparer {

	public function valuesAreEqual( $firstValue, $secondValue ) {
		if ( method_exists( $firstValue, 'equals' ) ) {
			return $firstValue->equals( $secondValue );
		}

		return false;
	}

}
