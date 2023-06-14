<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\People;
use Html\WebPage;

try {
    if (!isset($_GET['peopleId']) || !ctype_digit($_GET['peopleId']) || $_GET['peopleId'] < 0) {
        throw new ParameterException();
    }
    $peopleId = preg_replace('@<(.+)[^>]*>.*?@is', '', $_GET['peopleId']);
    if (! People::findById((int) $peopleId)) {
        throw new EntityNotFoundException();
    }
} catch (ParameterException) {
    http_response_code(400);
    exit;
} catch (EntityNotFoundException) {
    http_response_code(404);
    exit;
} catch (Exception) {
    http_response_code(500);
    exit;
}

