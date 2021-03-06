<?php

namespace PHPSemVerChecker\Analyzer;

use PHPSemVerChecker\Operation\TraitAdded;
use PHPSemVerChecker\Operation\TraitRemoved;
use PHPSemVerChecker\Registry\Registry;
use PHPSemVerChecker\Report\Report;
use PHPSemVerChecker\SemanticVersioning\Level;

class TraitAnalyzer
{
	protected $context = 'trait';

	public function analyze(Registry $registryBefore, Registry $registryAfter)
	{
		$report = new Report();

		$keysBefore = array_keys($registryBefore->data['trait']);
		$keysAfter = array_keys($registryAfter->data['trait']);
		$added = array_diff($keysAfter, $keysBefore);
		$removed = array_diff($keysBefore, $keysAfter);
		$toVerify = array_intersect($keysBefore, $keysAfter);

		foreach ($removed as $key) {
			$fileBefore = $registryBefore->mapping['trait'][$key];
			$traitBefore = $registryBefore->data['trait'][$key];

			$data = new TraitRemoved($fileBefore, $traitBefore);
			$report->addTrait($data, Level::MAJOR);
		}

		// TODO: Verify similar traits methods <tom@tomrochette.com>

		foreach ($added as $key) {
			$fileAfter = $registryAfter->mapping['trait'][$key];
			$traitAfter = $registryAfter->data['trait'][$key];

			$data = new TraitAdded($fileAfter, $traitAfter);
			$report->addTrait($data, Level::MINOR);
		}

		return $report;
	}
}
