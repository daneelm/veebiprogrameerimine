<?php
    class Test{
        //muutujad ehk properties, tevre klassi see kättesaadavad, väljaspool klassi on public kättesaadav
        private $secretNumber;
        public $knownNumber;
        
        //funktsioonid ehk methods
        //constructor ehk meetod, mis käivitub üks kord, klassi kasutuselevõtmisel
        function __construct($sentNumber){//kaks allkriipsu     saadetud info tuleb konstruktorile
            $this->secretNumber = 3;
            $this->knownNumber = $sentNumber;
            echo "salajane: " .$this->secretNumber ." ja teadaolev: " .$this->knownNumber;
            $this->addNumbers();
            //$this->multiplyNumbers();
        }//constuct lõppeb

        //destructor, kasutatakse üks kord klassi töö lõpetamisel

        function __destruct(){
            echo " klass lõpetab!";
        }//destruct lõpp

        private function addNumbers(){
            $sum = $this->secretNumber + $this->knownNumber;
            echo " summa on: " .$sum;
        }

        public function multiplyNumbers(){
            $result = $this->secretNumber * $this->knownNumber;
            echo " korrutis on: " .$result;
        }

    }//class lõppeb