<?php

use App\Jobs\GenerateDailySalesReport;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new GenerateDailySalesReport)->dailyAt('22:00'); // 10:00 PM
