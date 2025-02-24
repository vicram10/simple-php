<?php

namespace Src\Core;

use DateTimeImmutable;
use DateTimeInterface;

class BaseObject {
    // the project born in Paraguay, so the default timezone is America/Asuncion
    const defaultTimeZone = 'America/Asuncion';
    const utcTimeZone = 'UTC';

    function __construct() {}

    static function utcNow():DateTimeImmutable {
        return new DateTimeImmutable('now', new \DateTimeZone('UTC'));
    }

    static function pyNow():DateTimeImmutable {
        return self::utcNow()->setTimezone(new \DateTimeZone(self::defaultTimeZone));
    }

    static function immutableUtc(string $date):DateTimeImmutable {
        return DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $date, new \DateTimeZone(self::utcTimeZone));
    }

    static function interfaceToImmutable(DateTimeInterface $interface):DateTimeImmutable {
        return DateTimeImmutable::createFromMutable($interface)->setTimezone(new \DateTimeZone(self::utcTimeZone));
    }
}