<?php

use Icinga\Data\Filter\Filter;
use Icinga\Module\Monitoring\Controller as MonitoringController;
use Icinga\Module\Monitoring\Object\HostList;
use Icinga\Web\Url;

class StatusMap_IndexController extends MonitoringController {

	protected $hostList;

	public function init() {
		$this->hostList = new HostList($this->backend);
		$this->hostList->addFilter(Filter::matchAll());

		$this->getTabs()->add(
			'show',
			array(
				'title' => 'Show Status Map',
				'label' => 'Status Map',
				'url' => Url::fromRequest(),
			)
		)->activate('show');
	}

	public function indexAction() {
		$this->hostList->setColumns(array(
			'host_name',
			'host_display_name',
			'host_state',
		));

		$hosts = $this->hostList->fetch();

		$dependencies = $this->backend->select()
			->from('hostdependency', array('host_name', 'dependent_host_name'))
			->fetchAll();

		$data_dep = array();
		foreach ($dependencies as $dependency) {
			$data_dep[] = array(
				'parent' => $dependency->host_name,
				'child' => $dependency->dependent_host_name,
			);
		}
		$this->view->data_dependencies = json_encode($data_dep);

		$data_hosts = array();
		foreach ($hosts as $host) {
			$data_hosts[] = array(
				'host_name' => $host->host_name,
				'display_name' => $host->host_display_name,
				'state' => (int) $host->host_state,
			);
		}
		$this->view->data_hosts = json_encode($data_hosts);
	}

}
