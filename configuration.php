<?php

$section = $this->menuSection('Overview', array(
	'priority' => 30,
));
$section->add($this->translate('Status Map'), array(
	'url'      => 'statusmap',
	'priority' => 42
));

$this->provideJsFile('vendor/vis.js');
$this->provideCssFile('vendor/vis.css');
