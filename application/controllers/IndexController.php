<?php


use Icinga\Module\Monitoring\Controller as MonitoringController;
use Icinga\Web\Url;

class StatusMap_IndexController extends MonitoringController
{

    protected $hosts;

    public function init()
    {
        $this->getTabs()->add(
            'show',
            array(
                'title' => 'Show Status Map',
                'label' => 'Status Map',
                'url' => Url::fromRequest(),
            )
        )->activate('show');
    }

    public function indexAction()
    {
        $query = $this->backend
            ->select()
            ->from('hoststatus', array(
                'host_display_name',
                'host_name',
                'host_state' => 'host_state'));

        $this->applyRestriction('monitoring/filter/objects', $query);

        $hosts = $query->fetchAll();

        $dependencies = $this->backend
            ->select()
            ->from('customvar', array(
                'host_name',
                'varvalue'))
            ->where('varname', 'parent_host_name')->fetchAll();

        $data_dep = array();
        foreach ($dependencies as $dependency) {
            $data_dep[] = array(
                'parent' => $dependency->host_name,
                'child' => $dependency->varvalue,
            );
        }
        $this->view->data_dependencies = json_encode($data_dep);

        $data_hosts = array();
        foreach ($hosts as $host) {
            $data_hosts[] = array(
                'host_name' => $host->host_name,
                'display_name' => $host->host_display_name,
                'state' => (int)$host->host_state,
            );
        }
        $this->view->data_hosts = json_encode($data_hosts);
    }

}
