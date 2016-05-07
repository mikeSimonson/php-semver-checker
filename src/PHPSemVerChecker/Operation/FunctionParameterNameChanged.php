<?php

namespace PHPSemVerChecker\Operation;

class FunctionParameterNameChanged extends FunctionOperationDelta
{
	/**
	 * @var string
	 */
	protected $code = 'V067';
	/**
	 * @var string
	 */
	protected $reason = 'Function parameter name changed.';
}
