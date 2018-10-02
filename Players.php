<?php    
interface IPlayers {
    function setPlayerDataArray($player);
    function setPlayerDataJson($player);
    function setPlayerDataFromFile($player,$filename);
    function getPlayerDataArray();
    function getPlayerDataJson();
    function getPlayerDataFromFile($filename);
}


class Players implements IPlayers {

    private $playersArray;

    private $playerJsonString;

    public function __construct() {
        //We're only using this if we're storing players as an array.
        $this->playersArray = [];
        $players = [];

        $jonas = new \stdClass();
        $jonas->name = 'Jonas Valenciunas';
        $jonas->age = 26;
        $jonas->job = 'Center';
        $jonas->salary = '4.66m';
        $players[] = $jonas;

        $kyle = new \stdClass();
        $kyle->name = 'Kyle Lowry';
        $kyle->age = 32;
        $kyle->job = 'Point Guard';
        $kyle->salary = '28.7m';
        $players[] = $kyle;

        $demar = new \stdClass();
        $demar->name = 'Demar DeRozan';
        $demar->age = 28;
        $demar->job = 'Shooting Guard';
        $demar->salary = '26.54m';
        $players[] = $demar;

        $jakob = new \stdClass();
        $jakob->name = 'Jakob Poeltl';
        $jakob->age = 22;
        $jakob->job = 'Center';
        $jakob->salary = '2.704m';
        $players[] = $jakob;

        $this->playersArray = $players;

        //We'll only use this one if we're storing players as a JSON string
        $this->playerJsonString = '[{"name":"Jonas Valenciunas","age":26,"job":"Center","salary":"4.66m"},{"name":"Kyle Lowry","age":32,"job":"Point Guard","salary":"28.7m"},{"name":"Demar DeRozan","age":28,"job":"Shooting Guard","salary":"26.54m"},{"name":"Jakob Poeltl","age":22,"job":"Center","salary":"2.704m"}]';
    }


    /**
     * @param $player \stdClass Class implementation of the player with name, age, job, salary.
     */
    function setPlayerDataArray($player) {
        $this->playersArray[] = $player;
    }

    /**
     * @param $player \stdClass Class implementation of the player with name, age, job, salary.
     */
    function setPlayerDataJson($player) {

        $players = [];
        if ($this->playerJsonString) {
            $players = json_decode($this->playerJsonString);
        }
        $players[] = $player;
        $this->playerJsonString = json_encode($players);

    }
    /**
     * @param $player \stdClass Class implementation of the player with name, age, job, salary.
     * @param $filename string Only used if we're writing in 'file' mode
     */
    function setPlayerDataFromFile($player,$filename) {
        $players = json_decode($this->getPlayerDataFromFile($filename));
        if (!$players) {
            $players = [];
        }
        $players[] = $player;
        file_put_contents($filename, json_encode($players));
    }

    /**
     * @return Array
     */
    function getPlayerDataArray() {
        return $this ->playersArray;
    }

    /**
     * @return String json
     */
    function getPlayerDataJson() {
        
        return $this->playerJsonString;
    }
    /**
     * @param $filename string Only used if we're writing in 'file' mode
     * @return file json     
     */
    function getPlayerDataFromFile($filename) {
        if (!$filename){
            throw new \Exception(sprintf('filename cannot be null'));
        }
        $file = file_get_contents($filename);
        return $file;
    }

}

?>