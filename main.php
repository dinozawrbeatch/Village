<?php
class Animal
{
    static $id = 1;
    public $animalId = 0;
    public $product;

    public function getAnimalName(){
        return static::class;
    }
    public function getProduct(){
    }
}

class Cow extends Animal{
    function __construct(){
        $this->product = 'Молоко';
        $this->animalId = Animal::$id++;
    }
    public function getProduct()
    {
        return rand(8,12);
    }
}

class Chicken extends Animal{
    function __construct(){
        $this->product = 'Яйцо';
        $this->animalId = Animal::$id++;
    }
    public function getProduct()
    {
        return rand(0,1);
    }
}

class Pig extends Animal{
    function __construct(){
        $this->product = 'Трюфель';
        $this->animalId = Animal::$id++;
    }
    public function getProduct()
    {
        return rand(0,6);
    }
}

class Farm{
    private $barn = array();
    private $result;

    public function numberAnimals($animal){
        array_push($this->barn[$animal->getAnimalName()], $animal);
    }

    public function countAnimals(){
        echo "В хлеву: ";
        foreach ($this->barn as $animal => $count){
            echo  " $animal: " . count($count);
        }
    }

    public function getProductsOnDay(){
        foreach ($this->barn as $animal => $value){
            $sum = 0;
            $animalClass = $value[0]->product;
            $this->result[$animalClass] = $sum;
            foreach ($value as $animal){
                $sum += $animal->getProduct();
            }
            $this->result[$animalClass] += $sum;
        }
    }

    public function getProductsOnWeek(){
        for($i = 0; $i < 7; $i++){
            $this->getProductsOnDay();
        }
        foreach ($this->result as $product => $value){
            echo PHP_EOL . "$product: " . $value;
        }
    }

    public function addAnimal($animal){
        $this->barn[$animal->getAnimalName()] = array();
    }
}

$farm = new Farm();
$farm->addAnimal(new Cow);
for ($i = 0; $i < 10; $i++){
    $farm->numberAnimals(new Cow);
}
$farm->addAnimal(new Pig);
$farm->numberAnimals(new Pig);

$farm->addAnimal(new Chicken);
for ($i = 0; $i < 20; $i++){
    $farm->numberAnimals(new Chicken);
}

$farm->countAnimals();
$farm->getProductsOnWeek();

echo PHP_EOL . "Съездили на рынок, купили животных" . PHP_EOL;
for($i = 0; $i < 5; $i++){
    $farm->numberAnimals(new Chicken);
}

for($i = 0; $i < 3; $i++){
    $farm->numberAnimals(new Pig);
}

$farm->numberAnimals(new Cow);
$farm->countAnimals();
$farm->getProductsOnWeek();

function asking($farm){
    while(true) {
        $ask = readline(PHP_EOL . "Хотите добавить животных? y/n");
        if ($ask == 'y' || $ask == 'н' || $ask == 'Y' || $ask == 'Н') {
            $ask1 = readline('1)Добавить одну корову' . PHP_EOL . '2)Добавить одну курицу');
            if ($ask1 == '1') {
                $farm->numberAnimals(new Cow);
                $farm->countAnimals();
            }
            if ($ask1 == '2') {
                $farm->numberAnimals(new Chicken);
                $farm->countAnimals();
            }
        } else {
            return false;
        }
    }
}

asking($farm);