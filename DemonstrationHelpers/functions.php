<?php

use http\Client\Response;

function response(array $content, int $code = 200): Response
{
    return new Response();
}

function config(string $service): array
{
    return [];
}
