<?php

use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverElement;
use Facebook\WebDriver\WebDriverExpectedCondition;

/**
 * Wait element and return it, or throw an exception
 *
 * @param WebDriver $driver
 * @param WebDriverBy $locator
 * @return WebDriverElement
 * @throws \Facebook\WebDriver\Exception\NoSuchElementException
 * @throws \Facebook\WebDriver\Exception\TimeOutException
 */
function getElement(WebDriver $driver, WebDriverBy $locator): WebDriverElement
{
    return $driver->wait(10, 500)
        ->until(WebDriverExpectedCondition::presenceOfElementLocated($locator),
            'element not found');
}
