<?php

use Saloon\Http\BaseResource;
use Saloon\Http\Request;

it('all requests classes extend the base request', function () {
    expect('Mmorand\Apertus\Requests')->toExtend(Request::class);
});

it('all resources classes extend the base resource', function () {
    expect('Mmorand\Apertus\Resources')->toExtend(BaseResource::class);
});
