<?php
require_once '../core/Template.php';
require_once '../core/Controller.php';

/**
 * Created by PhpStorm.
 * User: ematgrz
 * Date: 2017-01-02
 * Time: 14:14
 */
class Parser extends Controller
{


    public $allConfigs = [];
    public $bsc116 = [];
    public $bsc126 = [];
    public $bsc116Run = [];
    public $bsc126Run = [];
    public $bsc116Idle = [];
    public $bsc126Idle = [];
    public $bsc116Offline = [];
    public $bsc126Offline = [];

    /**
     * Parser constructor.
     */
    public function __construct()
    {
        $this->sortConfigs();
    }


    public function index()
    {
        $template = new Template('../public/templates/index.php');
        $template->renderBody('header');
        $template->renderBody('menu');
        $template->renderBody('footer');
        $template->renderTitle(['title' => 'Node', 'description' => 'Current node status', 'controller' => 'Parser']);
        $template->renderBody('body', 'nodes');

        $template->renderMultiPartials('bsc116', '../public/templates/partials/singleNode.php', $this->bsc116, ['displayName',
            'offline', 'offlineCauseReason', 'name', 'bscnr', 'tgnr', 'confnr', 'ionicon', 'color', 'overlay']);

        $template->renderMultiPartials('bsc126', '../public/templates/partials/singleNode.php', $this->bsc126, ['displayName',
            'offline', 'offlineCauseReason', 'name', 'bscnr', 'tgnr', 'confnr', 'ionicon', 'color', 'overlay']);

        $template->show();

    }

    public
    function statistics()
    {
        $template = new Template('../public/templates/index.php');

        $template->renderBody('header');
        $template->renderBody('menu');
        $template->renderBody('footer');
        $template->renderTitle(['title' => 'Statistics', 'description' => 'Current node usage statistics', 'controller' => 'Parser']);
        $template->renderBody('body', 'statistics');

        if (count($this->bsc116Run) > 0) {
            $template->assign('bsc116run', 'BSC 116');
        }
        if (count($this->bsc126Run) > 0) {
            $template->assign('bsc126run', 'BSC 126');
        }
        if (count($this->bsc116Idle) > 0) {
            $template->assign('bsc116idle', 'BSC 116');
        }
        if (count($this->bsc126Idle) > 0) {
            $template->assign('bsc126idle', 'BSC 126');
        }
        if (count($this->bsc116Offline) > 0) {
            $template->assign('bsc116offline', 'BSC 116');
        }
        if (count($this->bsc126Offline) > 0) {
            $template->assign('bsc126offline', 'BSC 126');
        }

        $template->assign('bsc116run', 'BSC116');
        $template->assign('bsc126run', 'BSC126');
        $template->assign('bsc116idle', 'BSC116');
        $template->assign('bsc126idle', 'BSC126');
        $template->assign('bsc116offline', 'BSC116');
        $template->assign('bsc126offline', 'BSC126');

        $template->renderMultiPartials('bsc116run', '../public/templates/partials/singleNodeListed.php', $this->bsc116Run, ['name', 'bscnr', 'tgnr', 'confnr', 'callout']);
        $template->renderMultiPartials('bsc126run', '../public/templates/partials/singleNodeListed.php', $this->bsc126Run, ['name', 'bscnr', 'tgnr', 'confnr', 'callout']);
        $template->renderMultiPartials('bsc116idle', '../public/templates/partials/singleNodeListed.php', $this->bsc116Idle, ['name', 'bscnr', 'tgnr', 'confnr', 'callout']);
        $template->renderMultiPartials('bsc126idle', '../public/templates/partials/singleNodeListed.php', $this->bsc116Idle, ['name', 'bscnr', 'tgnr', 'confnr', 'callout']);
        $template->renderMultiPartials('bsc116offline', '../public/templates/partials/singleNodeListed.php', $this->bsc116Offline, ['name', 'bscnr', 'tgnr', 'confnr', 'callout']);
        $template->renderMultiPartials('bsc126offline', '../public/templates/partials/singleNodeListed.php', $this->bsc126Offline, ['name', 'bscnr', 'tgnr', 'confnr', 'callout']);

        $template->show();

    }


// PRIVATE FUNCTIONS

    private
    function parseNodes()
    {
        $json = [];
        try {
            $url = 'https://fem102-eiffel005.lmera.ericsson.se:8443/jenkins/computer/api/json?pretty=true';
            $content = file_get_contents($url);
            $json = json_decode($content, true);
        } catch (Exception $e) {
            header("location: /btscivis/public/parser/index");
        }

        return $json;
    }

    private
    function getConfigs($bscName)
    {
        $parsedNodes = $this->parseNodes();
        $bsc = [];

        foreach ($parsedNodes['computer'] as $computer) {
            if (strpos($computer['displayName'], $bscName) !== false) {
                $split = split('-', $computer['displayName']);

                $computer['name'] = strtoupper($split[3]);
                $computer['bscnr'] = strtoupper($split[0]);
                $computer['tgnr'] = strtoupper($split[1]);
                $computer['confnr'] = strtoupper($split[2]);

                if ($computer['idle'] == false && $computer['offline'] == false) {
                    $computer['ionicon'] = 'ion-load-d';
                    $computer['color'] = 'green';
                    $computer['overlay'] = '<div class="overlay dark"><i class="fa fa-refresh fa-spin"></i></div>';
                    $computer['callout'] = 'success';
                } else {
                    $computer['ionicon'] = 'ion-close-round';
                    $computer['color'] = 'red';
                    $computer['overlay'] = '';
                    $computer['callout'] = 'danger';
                }
                if ($computer['idle'] !== true && $computer['offline'] !== true && empty($computer['offlineCauseReason'])) {
                    $computer['offlineCauseReason'] = 'Runnning';
                }
                if ($computer['idle'] == true && $computer['offline'] !== true && empty($computer['offlineCauseReason'])) {
                    $computer['color'] = 'light-blue';
                    $computer['offlineCauseReason'] = 'Idle';
                    $computer['callout'] = 'info';
                }
                array_push($bsc, $computer);
            }
        }

        return $bsc;
    }

    private function sortConfigs()
    {
        $parsedNodes = $this->parseNodes();
        foreach ($parsedNodes['computer'] as $computer) {
            if (strpos($computer['displayName'], 'bsc') !== false) {
                $split = split('-', $computer['displayName']);
                $computer['name'] = strtoupper($split[3]);
                $computer['bscnr'] = strtoupper($split[0]);
                $computer['tgnr'] = strtoupper($split[1]);
                $computer['confnr'] = strtoupper($split[2]);
                if ($computer['idle'] == false && $computer['offline'] == false) {
                    $computer['ionicon'] = 'ion-load-d';
                    $computer['color'] = 'green';
                    $computer['overlay'] = '<div class="overlay dark"><i class="fa fa-refresh fa-spin"></i></div>';
                    $computer['callout'] = 'success';
                    $computer['offlineCauseReason'] = 'Runnning';

                    if (strpos($computer['displayName'], 'bsc116') !== false) {
                        array_push($this->bsc116Run, $computer);
                    } elseif (strpos($computer['displayName'], 'bsc126') !== false) {
                        array_push($this->bsc126Run, $computer);
                    }
                } elseif($computer['idle'] == true && $computer['offline'] == true) {
                    $computer['ionicon'] = 'ion-close-round';
                    $computer['color'] = 'red';
                    $computer['overlay'] = '';
                    $computer['callout'] = 'danger';

                    if (strpos($computer['displayName'], 'bsc116') !== false) {
                        array_push($this->bsc116Offline, $computer);
                    } elseif (strpos($computer['displayName'], 'bsc126') !== false) {
                        array_push($this->bsc126Offline, $computer);
                    }
                }
                if ($computer['idle'] == true && $computer['offline'] == true && empty($computer['offlineCauseReason'])) {
                    $computer['offlineCauseReason'] = 'Offline';
                }
                if ($computer['idle'] == true && $computer['offline'] !== true && empty($computer['offlineCauseReason'])) {
                    $computer['color'] = 'light-blue';
                    $computer['offlineCauseReason'] = 'Idle';
                    $computer['callout'] = 'info';

                    if (strpos($computer['displayName'], 'bsc116') !== false) {
                        array_push($this->bsc116Idle, $computer);
                    } elseif (strpos($computer['displayName'], 'bsc126') !== false) {
                        array_push($this->bsc126Idle, $computer);
                    }
                }
                if (strpos($computer['displayName'], 'bsc116') !== false) {
                    array_push($this->bsc116, $computer);
                } elseif (strpos($computer['displayName'], 'bsc126') !== false) {
                    array_push($this->bsc126, $computer);
                }
                array_push($this->allConfigs, $computer);
            }
        }
    }
}