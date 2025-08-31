<?php

declare(strict_types=1);

arch('No file in the app directory uses `die`, `dd`, or `dump`.')
    ->expect('App')
    ->not->toUse(['die', 'dd', 'dump', 'ray']);
