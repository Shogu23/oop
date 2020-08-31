<?php

class Warrior
{
    /** @var int */
    private $health;

    /** @var int */
    private $hitPoint;

    private $hitCount;

    public function __construct(int $health, int $hitPoint) 
    {
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
    

} // Fin de class Warrior

// ------------------------------- *************************** ------------------------------------ //

class Wizard
{
    /** @var int */
    private $health;

    /** @var int */
    private $hitPoint;

    /** @var int */
    private $magicPoint;

    private $hitCount;

    public function __construct(int $health, int $hitPoint, int $magicPoint = 10) 
    {
        $this->health = $health;
        $this->hitPoint = $hitPoint;
        $this->magicPoint = $magicPoint;
        $this->hitCount = 0; 
    }

    public function isAlive()
    {
        return $this->health > 0;
    }

    public function attackWithMagic()
    {
        if (!$this->isAlive())
        {
            return 0;
        }
        else
        {
            $this->magicPoint -= 2;
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
