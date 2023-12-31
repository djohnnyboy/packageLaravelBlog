<?php

namespace Djohnnyboy\Poweredblog\Fields;

class Description extends FieldContract {
	
	public static function process($fieldType, $fieldValue, $data) {
		return [$fieldType => $fieldValue];
	}
}