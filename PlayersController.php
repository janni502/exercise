<?php
include("Player.php");
include("PlayersView.php");

interface IPlayersControler {
    function readPlayers($source, $filename = null);
    function writePlayer($source, $player, $filename = null);
    function display($isCLI, $course, $filename = null);
}

class PlayersControler implements IPlayersControler {
	private $playersObject;
	private $playersView;

    public function __construct() {
        //playersObject is the Model
        $this->playersObject = new Players();

        //playersView is the View
        $this->playersView = new PlayersView();
    }

	/**
     * @param $source string Where we're retrieving the data from. 'json', 'array' or 'file'
     * @param $filename string Only used if we're reading players in 'file' mode.
     * @return string json
     */
    function readPlayers($source, $filename = null) {
        $playerData = null;

        switch ($source) {
            case 'array':
                $playerData = $this->playersObject->getPlayerDataArray();
                break;
            case 'json':
                $playerData = $this->playersObject->getPlayerDataJson();
                break;
            case 'file':
                $playerData = $this->playersObject->getPlayerDataFromFile($filename);
                break;
        }

        if (is_string($playerData)) {
            $playerData = json_decode($playerData);
        }

        return $playerData;

    }

    /**
     * @param $source string Where to write the data. 'json', 'array' or 'file'
     * @param $filename string Only used if we're writing in 'file' mode
     * @param $player \stdClass Class implementation of the player with name, age, job, salary.
     */
    function writePlayer($source, $player, $filename = null) {
        switch ($source) {
            case 'array':
                $this->playersObject->setPlayerDataArray($player);
                break;
            case 'json':
                $this->playersObject->setPlayerDataJson($player);
                break;
            case 'file':
                $this->playersObject->setPlayerDataFromFile($player,$filename);
                break;
        }
    }

	/**
     * @param $source string Where we're retrieving the data from. 'json', 'array' or 'file'
     * @param $filename string Only used if we're reading players in 'file' mode.
     */
    function display($isCLI, $source, $filename = null) {

        $players = $this->readPlayers($source, $filename);
        if (!$players){
            throw new \Exception(sprintf('players cannot be null for display'));
        }

        $this->playersView->view($isCLI, $players);
    }



}

$playersControler = new PlayersControler();

        $player = new \stdClass();
        $player->name = 'Janni Zhao';
        $player->age = 22;
        $player->job = 'Software Developer';
        $player->salary = '5.0m';


$playersControler->writePlayer('json',$player);
$playersControler->writePlayer('array',$player);
$playersControler->writePlayer('file',$player,'tempjson.json');

$playersControler->display(php_sapi_name() === 'cli','json');

?>    