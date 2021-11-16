<?php

class Command
{
    public Output $output;

    public function argument(string $name)
    {
        return [];
    }

    public function info(string $message): void
    {
        // this method is only for demonstration purpose
    }
}
