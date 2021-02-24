<?php

use phpDocumentor\Reflection\Types\Void_;

/**
 * @author <a href="mailto:bagus.seno39@gmail.com>seno</a>
 * Created on 25/02/21
 * Project evermos-service
 */

class TreasureHunt
{
    /**
     * @var int
     */
    private $gridColumn = 8;
    /**
     * @var int
     */
    private $gridRow = 6;
    /**
     * @var array
     */
    private $slot = [];
    /**
     * @var array
     */
    private $clearPathslot = [];
    /**
     * @var null
     */
    private $position_user = null;

    /**
     * TreasureHunt constructor.
     */
    function __construct()
    {
        $this->setGridValues();
    }

    /**
     * set grid slot values
     */
    private function setGridValues()
    {
        for ($i = 0; $i < $this->gridRow; $i++) {
            for ($j = 0; $j < $this->gridColumn; $j++) {
                if (
                    ($i == 0 || $i == ($this->gridRow - 1))
                    && ($j >= 0 && $j < $this->gridColumn)
                ) {
                    $this->slot[$i][$j] = "#";
                } else if (
                    ($j == 0 || $j == ($this->gridColumn - 1))
                    && ($i >= 0 && $i < $this->gridRow)
                ) {
                    $this->slot[$i][$j] = "#";
                } else if ($i == 2 && ($j >= 2 && $j <= 4)) {
                    $this->slot[$i][$j] = "#";
                } else if ($i == 3 && ($j == 4 || $j == 6)) {
                    $this->slot[$i][$j] = "#";
                } else if ($i == 4 && $j == 2) {
                    $this->slot[$i][$j] = "#";
                } else if ($i == 4 && $j == 1) {
                    $this->slot[$i][$j] = "X";
                    $userPosition = new stdClass();
                    $userPosition->row = $i;
                    $userPosition->column = $j;
                    $this->position_user = $userPosition;
                } else {
                    $this->slot[$i][$j] = ".";
                    $clearPath = new stdClass();
                    $clearPath->row = $i;
                    $clearPath->column = $j;
                    $this->clearPathslot["{$clearPath->row}::{$clearPath->column}"] = $clearPath;
                }
            }
        }
    }

    /**
     *
     */
    public function startHunt()
    {
        echo PHP_EOL . "==============================================================================================================================";
        echo PHP_EOL . "TASK 2 : Treasure Hunt";
        echo PHP_EOL . "==============================================================================================================================" . PHP_EOL;
        $this->generateGrid();
        echo PHP_EOL . "==============================================================================================================================" . PHP_EOL;

        // navigate how many step for Up/North
        echo "Navigate position in a specific order: " . PHP_EOL;
        echo "Up/North: ";
        $up = (int)trim(fgets(STDIN));

        // navigate how many step for Right/East
        echo "Right/East: ";
        $right = (int)trim(fgets(STDIN));

        // navigate how many step for Down/South
        echo "Down/South: ";
        $down = (int)trim(fgets(STDIN));

        /**
         * END navigate by user from starting position by order
         */

        // // generateGrid probable slot points where the treasure might be localted
        echo PHP_EOL . "==============================================================================================================================" . PHP_EOL;
        echo "Probable Treasure Locations: " . PHP_EOL . $this->setProbableTreasureSlot($up, $right, $down);

        // generateGrid grid after navigate position by user
        echo PHP_EOL . "==============================================================================================================================" . PHP_EOL;
        $this->generateGrid();
    }

    /**
     * generateGrid grid for grid slot values
     */
    private function generateGrid()
    {

        for ($i = 0; $i < $this->gridRow; $i++) {

            for ($j = 0; $j < $this->gridColumn; $j++) {
                echo $this->slot[$i][$j];
                if ($j == ($this->gridColumn - 1)) {
                    echo PHP_EOL;
                }
            }

        }

    }

    /**
     * generateGrid probable treasure slot point values from user navigate values
     * @param int $up
     * @param int $right
     * @param int $down
     * @return string
     */
    private function setProbableTreasureSlot(int $up, int $right, int $down): string
    {
        if ($up) $this->setSlotValues($up, "up");
        if ($right) $this->setSlotValues($right, "right");
        if ($down) $this->setSlotValues($down, "down");

        // Get list of probable treasure slot from clear path  after user navigate process
        $list_treasure_slot = [];
        foreach ($this->clearPathslot as $key => $slot) {
            $list_treasure_slot[] = "({$slot->row}, {$slot->column})";
            $this->slot[$slot->row][$slot->column] = "$";
        }
        return implode(', ', $list_treasure_slot);
    }

    /**
     * Change grid value slot according user navigate values
     * @param int $val the value from user navigate
     * @param string $navigate the direction from user navigate
     */
    private function setSlotValues(int $val, string $navigate)
    {
        while ($val != 0) {
            switch ($navigate) {
                case "right":
                    $column = ($this->position_user->column + 1);
                    if ($column >= 0) {
                        if ($this->slot[$this->position_user->row][$column] == ".") {
                            $this->slot[$this->position_user->row][$column] = 'X';
                            $this->position_user->column = $column;

                            // Delete slot from clear path
                            if (array_key_exists($this->position_user->row . "::" . $column, $this->clearPathslot)) {
                                unset($this->clearPathslot[$this->position_user->row . "::" . $column]);
                            }
                        }
                    }
                    break;
                case "up":
                case "down":
                    $row = ($this->position_user->row - 1);
                    if ($navigate == "down") $row = ($this->position_user->row + 1);

                    if ($row >= 0) {
                        if ($this->slot[$row][$this->position_user->column] == ".") {
                            $this->slot[$row][$this->position_user->column] = 'X';
                            $this->position_user->row = $row;
                            if (array_key_exists($row . "::" . $this->position_user->column, $this->clearPathslot)) {
                                unset($this->clearPathslot[$row . "::" . $this->position_user->column]);
                            }
                        }
                    }
                    break;
            }
            $val--;
        }
    }
}

$runner = new TreasureHunt();

echo ($runner->startHunt()), PHP_EOL;
