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
        $elem = $driver->findElement($locator);
        return $elem;
    } catch (\Exception $e) {
        echo 'element is not found!';
        return false;
    }
}
