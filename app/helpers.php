<?php

use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

/**
 * Check if element exists
 *
 * @param WebDriver $driver
 * @param WebDriverBy $locator
 * @return bool|\Facebook\WebDriver\WebDriverElement
 */
function isElementExist(WebDriver $driver, WebDriverBy $locator)
{
    try {
        $driver->wait(5)->until(function () use ($locator) {
            return WebDriverExpectedCondition::visibilityOfElementLocated($locator);
        });
        return $driver->findElement($locator);
    } catch (\Exception $e) {
        app('log')->error($e);
        return false;
    }
}
