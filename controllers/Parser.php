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
    public function index()
    {
        $parsedNodes = $this->parseNodes();
        $template = new Template('../public/templates/index.php');
        $bsc116 = [];
        $bsc126 = [];

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
                } else {
                    $computer['ionicon'] = 'ion-close-round';
                    $computer['color'] = 'red';
                }
                if (empty($computer['offlineCauseReason'])) {
                    $computer['offlineCauseReason'] = 'Runnning';
                }

                if (strpos($computer['displayName'], 'bsc116') !== false) {
                    array_push($bsc116, $computer);
                }

                if (strpos($computer['displayName'], 'bsc126') !== false) {
                    array_push($bsc126, $computer);
                }
            }
        }

        $template->renderBody('header');
        $template->renderBody('menu');
        $template->renderBody('footer');
        $template->renderBody('title');
        $template->renderTitle(['title' => 'Node', 'description' => 'Current node status', 'controller' => 'Parser']);
        $template->renderBody('body', 'nodes');

        // TODO: do renderMultiPartials dodać wyświetlanie dla każdego elementu tablicy innej wartości pod tym samym kluczem.
        $template->renderMultiPartials('bsc116', '../public/templates/partials/singleNode.php', $bsc116, ['displayName',
            'offline', 'offlineCauseReason', 'name', 'bscnr', 'tgnr', 'confnr', 'ionicon', 'color']);

        $template->renderMultiPartials('bsc126', '../public/templates/partials/singleNode.php', $bsc126, ['displayName',
            'offline', 'offlineCauseReason', 'name', 'bscnr', 'tgnr', 'confnr', 'ionicon', 'color']);

        $template->show();

    }

    public function parseNodes()
    {
        $url = 'https://fem102-eiffel005.lmera.ericsson.se:8443/jenkins/computer/api/json?pretty=true';
        $content = file_get_contents($url);
//
//        $file = '../public/json';
//        $content = file_get_contents($file);
        $json = json_decode($content, true);

        return $json;
    }
}