<?php
use Illuminate\Support;  // https://laravel.com/docs/5.8/collections - provides the collect methods & collections class
use LSS\Array2Xml;
require_once('classes/Exporter.php');

class Controller {

    public function __construct($args) {
        $this->args = $args;
    }

    public function export($type, $format) {
        $data = [];
        $exporter = new Exporter();
        $searchArgs = ['player', 'playerId', 'team', 'position', 'country'];
        $search = $this->args->filter(function($value, $key) use ($searchArgs) {
            return in_array($key, $searchArgs);
        });

        if ($type == 'playerstats')
            $data = $exporter->getPlayerStats($search);
        else if ($type == 'players')
            $data = $exporter->getPlayers($search);
        
        if (!$data) {
            exit("Error: No data found!");
        }
        return $exporter->format($data, $format);
    }
}