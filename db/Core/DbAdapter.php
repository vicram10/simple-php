<?php

namespace Db\Core;

use DateTimeImmutable;

interface DbAdapter {
    function toDbDate(DateTimeImmutable $date): string;
    function fromDbDate(string $date): DateTimeImmutable;
}