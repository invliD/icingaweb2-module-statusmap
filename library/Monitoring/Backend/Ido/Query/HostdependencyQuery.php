<?php

namespace Icinga\Module\Monitoring\Backend\Ido\Query;

class HostdependencyQuery extends IdoQuery {

	protected $columnMap = array(
		'hostdependencies' => array(
			'host_name' => 'ho1.name1 COLLATE latin1_general_ci',
			'dependent_host_name' => 'ho2.name1 COLLATE latin1_general_ci',
		),
	);

	protected function joinBaseTables() {
		$this->select->from(
			array('hd' => $this->prefix . 'hostdependencies'),
			array()
		)->join(
			array('ho1' => $this->prefix . 'objects'),
			'ho1.object_id = hd.host_object_id',
			array()
		)->join(
			array('ho2' => $this->prefix . 'objects'),
			'ho2.object_id = hd.dependent_host_object_id',
			array()
		);
		$this->joinedVirtualTables['hostdependencies'] = true;
	}

}
