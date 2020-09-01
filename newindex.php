<?php

class Arena
{
    /** @var Fighter[] */
    private $fighters;

    /** @var Fighter|null */
    private $winner;

    public function __construct()
    {
        $this->fighters = [];
        $this->winner = null;
    }

    public function add(Fighter $fighter): void
    {
        $this->fighters[] = $fighter;
    }

    public function fightAll(): void
    {
        while (null === $this->winner) {
            $aliveFighters = $this->getAliveFighters();
            if (count($aliveFighters) === 0) {
                return;
            } elseif (count($aliveFighters) === 1) {
                $this->winner = $aliveFighters[0];
            } else {
                shuffle($aliveFighters);
                $fighterOne = $aliveFighters[0];
                $fighterTwo = $aliveFighters[1];
                $fighterOne->takeDamage($fighterTwo->attack());
                $fighterTwo->takeDamage($fighterOne->attack());
            }
        }

        //Here
    }

    public function getWinner(): ?Fighter
    {
        return $this->winner;
    }

    /**
     * @return Fighter[]
     */
    private function getAliveFighters(): array
    {
        $aliveFighters = [];
        foreach ($this->fighters as $fighter) {
            if ($fighter->isAlive()) {
                $aliveFighters[] = $fighter;
            }
        }

        return $aliveFighters;
    }
}


abstract class Fighter
{

    protected $health;

    protected $hitPoint;

    private $hitCount;

    public function __construct(string $name, int $health, int $hitPoint) 
    {
        $this->name = $name;
        $this->health = $health;
        $this->hitPoint = $hitPoint;
        $this->hitCount = 0; 
    }

    public function isAlive()
    {
        return $this->health > 0;
    }

    public function attack()
    {
        if (!$this->isAlive())
        {
            return 0;
        }
        else
        {
            return $this->hitPoint;
        }
    }

    public function takeDamage(int $damage)
    {
        if ($this->isAlive())
        {
            $this->health -= $damage;
            $this->hitCount++;
        }
    }

    public function getHitCount()
    {
        return $this->hitCount;
    }
    
} // Fin class Fighter

class Warrior extends Fighter{

} // Fin de class Warrior


class Wizard extends Fighter{

    const MAGIC_POINT_PER_ATTACK = 2;
    
    private $magicPoint;

    public function __construct(string $name, int $health, int $hitPoint, int $magicPoint = 10) 
    {
        parent::__construct($name, $health, $hitPoint);
        $this->magicPoint = $magicPoint;
    }

    public function attackWithMagic()
    {
        if (!$this->isAlive() || $this->magicPoint < self::MAGIC_POINT_PER_ATTACK) 
        {
            return 0;
        }
        else
        {
            $this->magicPoint -= self::MAGIC_POINT_PER_ATTACK;
            return $this->hitPoint;
        }
    }
} // Fin de class Wizard

$guerrierBourru = new Warrior(100, random_int(0, 10));

$guerrierJoufflu = new Warrior(100, random_int(0, 10));

$magePoillu = new Wizard(100, random_int(5, 25));

$mageTrappu = new Wizard(100, random_int(5, 25));


while ($guerrierBourru->isAlive() && $guerrierJoufflu->isAlive()) 
{
    $guerrierJoufflu->takeDamage($guerrierBourru->attack());
    $guerrierBourru->takeDamage($guerrierJoufflu->attack());
}

if ($guerrierJoufflu->isAlive())
{
    echo "Bourru fought well, he died a hero, after Joufflu striked him {$guerrierBourru->getHitCount()} times with an axe for {$guerrierJoufflu->attack()} damage, until he died...<br />";
}
else if ($guerrierBourru->isAlive())
{
    echo "Joufflu fought well, he died a hero, after Bourru ran over him {$guerrierJoufflu->getHitCount()} times with his katana, doing {$guerrierBourru->attack()} to him, until he became just soup.<br />";
}

while ($magePoillu->isAlive() && $mageTrappu->isAlive())
{
    $mageTrappu->takeDamage($magePoillu->attackWithMagic());
    $magePoillu->takeDamage($mageTrappu->attackWithMagic());
}

if ($magePoillu->isAlive())
{
    echo "Trappu fought well, he died a hero, after Poillu smited him with {$mageTrappu->getHitCount()} fireballs for {$magePoillu->attackWithMagic()} damage, until he was just ashes...<br />";
}
else if ($mageTrappu->isAlive())
{
    echo "Poillu fought well, he died a hero, after Trappu blew {$magePoillu->getHitCount()} frost wind on him with his wand, {$mageTrappu->attackWithMagic()} damage each time, until he became a giant popcicle.<br />";
}
else if ($magePoillu->isAlive() && $mageTrappu->isAlive())
{
    echo "After a long long fight, both mage went on a nap, and never woke up...";
}

$arena = new Arena();
for ($i = 1; $i <= 10; $i++) {
    $warrior = new Warrior("Number $i", 100, rand(0, 50));
    $wizard = new Wizard("Number $i", 100, rand(25, 50));

    $arena->add($warrior);
    $arena->add($wizard);
}

$arena->fightAll();
$winner = $arena->getWinner();
if (null === $winner) {
    echo "<h1>There is no winner!</h1>";
} else {
    echo "<h1>" . $winner . " has won!</h1>";
}
