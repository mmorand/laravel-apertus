<?php

/** @noinspection PhpUnhandledExceptionInspection */

use Mmorand\Apertus\Apertus;

it('has default values', function () {
    $apertus = new Apertus(
        apiKey: config('apertus.api_key'),
        baseUrl: config('apertus.base_url'),
        userAgent: config('apertus.user_agent'),
        timeout: config('apertus.timeout')
    );

    expect($apertus->getRequestTimeout())->toEqual($apertus->getConnectTimeout());
    expect($apertus->getRequestTimeout())->toEqual(120);
    expect($apertus->resolveBaseUrl())->toEqual('https://api.apertus.ai');
    expect($apertus->getUserAgent())->toEqual('Apertus-PHP/1.0.0');
});

it('Can setup timeout', function () {
    $apertus = new Apertus(
        apiKey: config('apertus.api_key'),
        baseUrl: config('apertus.base_url'),
        userAgent: config('apertus.user_agent'),
        timeout: 10
    );

    expect($apertus->getRequestTimeout())->toEqual(10);
});

it('Can change the timeout to 0', function () {
    $mistral = new Apertus(
        apiKey: config('apertus.api_key'),
        baseUrl: config('apertus.base_url'),
        userAgent: config('apertus.user_agent'),
        timeout: 0
    );

    expect($mistral->getRequestTimeout())->toEqual(0);
});

it('Can setup base url', function () {
    $apertus = new Apertus(
        apiKey: config('apertus.api_key'),
        baseUrl: 'https://example.com',
        userAgent: config('apertus.user_agent'),
        timeout: config('apertus.timeout')
    );

    expect($apertus->resolveBaseUrl())->toEqual('https://example.com');
});

it('Can setup user agent', function () {
    $apertus = new Apertus(
        apiKey: config('apertus.api_key'),
        baseUrl: config('apertus.base_url'),
        userAgent: 'MyApp/1.0.0',
        timeout: config('apertus.timeout')
    );

    expect($apertus->getUserAgent())->toEqual('MyApp/1.0.0');
});
