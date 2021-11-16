<?php

class Collection implements Countable
{
    public function all(): array
    {
        return [];
    }

    public function count(): int
    {
        return 1;
    }

    public function updateExistingPivot(Company $company, array $parameters, bool $flag): void
    {
        // this method is only for demonstration purpose
    }
}
