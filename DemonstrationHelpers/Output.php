<?php

class Output
{
    public function error(string $message): void
    {
        // this method is only for demonstration purpose
    }

    public function title(string $message): void
    {
        // this method is only for demonstration purpose
    }

    public function createProgressBar(int $max = 0): Bar
    {
        return new Bar();
    }
}
