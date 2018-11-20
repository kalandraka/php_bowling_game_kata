<?php

class BowlingGame
{

    private $score = 0;
    private $rolls = [];
    private $firstBallInFrame = 0;

    private function isStrike(): bool
    {
        return $this->rolls[ $this->firstBallInFrame ] == 10;
    }

    private function isSpare(): bool
    {
        return $this->twoBallsInFrame() == 10;
    }

    private function nextBallForSpare()
    {
        return $this->rolls[ $this->firstBallInFrame + 2 ];
    }

    private function nextTwoBallsForStrike()
    {
        return $this->rolls[ $this->firstBallInFrame + 1 ] + $this->rolls[ $this->firstBallInFrame + 2 ];
    }

    private function twoBallsInFrame(): int
    {
        return $this->rolls[ $this->firstBallInFrame ] + $this->rolls[ $this->firstBallInFrame + 1 ];
    }

    public function roll($pins)
    {
        $this->rolls[] = $pins;
    }

    public function score()
    {
        $this->firstBallInFrame = 0;
        foreach (range(1, 10) as $currentFrame) {
            if ($this->isStrike()) {
                $this->score += 10 + $this->nextTwoBallsForStrike();
                $this->firstBallInFrame++;
            } else if ($this->isSpare()) {
                $this->score += 10 + $this->nextBallForSpare();
                $this->firstBallInFrame += 2;
            } else {
                $this->score += $this->twoBallsInFrame();
                $this->firstBallInFrame += 2;
            }
        }

        return $this->score;
    }
}