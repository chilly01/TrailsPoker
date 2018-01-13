<?php

class VoidTrafficLight {

    public $eastwest;
    public $north;
    public $time_cycled;
    public $sensor_on_for;
    public $sensor_off_for;
    public $time_ew;
    public $time_n;
    private $cycle;
    private $going_west;
    public $car_waiting;

// initally setting the light to go west and the sensor is off
    function __construct() {
        $this->sensor_on_for = 0;
        $this->time_ew = 0;
        $this->time_n = 0;
        $this->going_west = true;
        $this->car_waiting = true;
        $this->cycle = 0;
        $this->time_cycled = 0;
    }

    function UpdateController() {
        $this->check_sensor();
        $this->time_cycled++;
        if ($this->going_west) {
            $this->time_n = 0;
            $this->time_ew++;
            if ($this->time_ew < 31) {  // don't do anything until it ran after 30 seconds
                $this->eastwest = "green";
                $this->north = "red";
                return "EW: green :: NS: red\n";
            }
            // if the cycle is larger then 3 then it's ready for red red
            if ($this->cycle > 3) {
                $this->cycle++;
                if ($this->cycle > 5) { // times up for red red... 
                    $this->time_ew = 0;
                    $this->going_west = false;
                    $this->cycle = 0;
                }
                $this->eastwest = "red";
                $this->north = "red";
                return "EW: red :: NS: red\n";
            }

            if ($this->sensor_on_for > 10 && $this->cycle == 0) {
                $this->cycle = 1; // start cycle 
            }
            // if the cycle has started then turn yellow
            if ($this->cycle > 0) {
                $this->cycle++;
                $this->eastwest = "yellow";
                $this->north = "red";
                return "EW: yellow :: NS: red\n";
            }

            // for when the sensor isn't on long enough or the cycle hasn't started
            $this->eastwest = "green";
            $this->north = "red";
            return "EW: green :: NS: red\n";
        } else {
            $this->time_n++;
            // if the cycle is beyond 4 seconds go red red
            if ($this->cycle > 3) {
                $this->cycle++;
                if ($this->cycle > 5) { // end red red and switch
                    $this->time_n = 0;
                    $this->cycle = 0;
                    $this->going_west = true;
                }
                $this->eastwest = "red";
                $this->north = "red";
                return "EW: red :: NS: red\n";
            }
            // start cycle if standards are met
            if (($this->sensor_off_for > 5 || $this->time_n > 40) && ($this->cycle == 0)) {
                $this->cycle = 1;
            }

            if ($this->cycle > 0) {
                $this->cycle++;

                $this->eastwest = "red";
                $this->north = "yellow";
                return "EW: red :: NS: yellow\n";
            }
            // else use the default return
        }

        $this->eastwest = "red";
        $this->north = "green";
        return "EW: red :: NS: green\n";
    }

    function StatusReport() {
        echo "todo";
    }

// this is triggered each update 
    function check_sensor() {
        if ($this->car_waiting) {
            $this->sensor_on_for++;
            $this->sensor_off_for = 0;
        } else {
            $this->sensor_on_for = 0;
            $this->sensor_off_for++;
        }
    }

    function change_sensor() {
        $this->car_waiting = !$this->car_waiting;
    }

}
