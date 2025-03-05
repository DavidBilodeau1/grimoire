<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('fetch:book-cover-image')->everyFiveMinutes();
