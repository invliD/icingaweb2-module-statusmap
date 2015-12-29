<?php

namespace Icinga\Module\Monitoring\DataView;

class Hostdependency extends DataView {

	public function getColumns() {
		return array(
			'host_name',
			'dependent_host_name',
		);
	}

}
