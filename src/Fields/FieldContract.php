<?php

namespace Djohnnyboy\Poweredblog\Fields;

abstract class FieldContract {
	
	public static function process($fieldType, $fieldValue, $data) {

		return [$fieldType => $fieldValue];
	}
}