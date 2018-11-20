<?php

use PHPUnit\Framework\TestCase;

include 'BowlingGame.php';

class BowlingTest extends TestCase
{
    private $game;

    public function rollMany($pins, $rolls): void
    {
        foreach (range(1, $rolls) as $i) {
            $this->game->roll($pins);
        }
    }

    public function rollSpare(): void
    {
        $this->game->roll(5);
        $this->game->roll(5);
    }

    public function rollStrike(): void
    {
        $this->game->roll(10);
    }

    protected function setUp()
    {
        $this->game = new BowlingGame();
    }

    public function testGutterGame(): void
    {
        $this->rollMany(0, 20);
        $this->assertEquals(0, $this->game->score());
    }

    public function testOnesGame(): void
    {
        $this->rollMany(1, 20);
        $this->assertEquals(20, $this->game->score());
    }

    public function testOneSpare()
    {
        $this->rollSpare();
        $this->game->roll(2);
        $this->rollMany(0, 17);
        $this->assertEquals(14, $this->game->score());
    }

    public function testOneStrike()
    {
        $this->rollStrike();
        $this->game->roll(3);
        $this->game->roll(4);
        $this->rollMany(0, 17);
        $this->assertEquals(24, $this->game->score());
    }

    public function testPerfectGame()
    {
        $this->rollMany(10, 12);
        $this->assertEquals(300, $this->game->score());
    }

    public function testConsecutiveStrikes()
    {
        $this->rollStrike();
        $this->rollStrike();
        $this->game->roll(3);
        $this->game->roll(4);
        $this->rollMany(0, 14);
        $this->assertEquals(47, $this->game->score());
    }
}
