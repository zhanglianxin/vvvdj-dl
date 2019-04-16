<?php

use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;

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
        // TODO optimize it by using wait...until
        return $driver->findElement($locator);
    } catch (\Exception $e) {
        app('log')->error($e);
        return false;
    }
}
