<?php

use SebastianBergmann\CodeCoverage\Filter;
use SebastianBergmann\CodeCoverage\Driver\Selector;
use SebastianBergmann\CodeCoverage\CodeCoverage;
use SebastianBergmann\CodeCoverage\Report\PHP as PhpReport;
use SebastianBergmann\FileIterator\Facade as FileIteratorFacade;

if (!extension_loaded('pcov') || !ini_get('pcov.enabled')) {
    return;
}

$filter = new Filter;
$filter->includeFiles(\array_filter(
    (new FileIteratorFacade)->getFilesAsArray( dirname(__DIR__), '.php'),
    function ($path) {
        if (!preg_match('#(lib/(max|OA|OX|RV)|plugins_repo)#', $path)) {
            return false;
        }

        return !preg_match('#/tests?|openXDeveloperToolbox|language/#', $path);
    }
));

$coverage = new CodeCoverage(
(new Selector)->forLineCoverage($filter),
$filter
);

$coverageName = "{$_GET['folder']}/tests/{$_GET['type']}/{$_GET['file']}";

$coverage->start($coverageName);

function save_coverage()
{
    global $coverage, $coverageName;

    $coverage->stop();
    (new PhpReport)->process($coverage, __DIR__ . '/../build/test-coverage/' . bin2hex(random_bytes(16)) . '.cov');
}

register_shutdown_function('save_coverage');
