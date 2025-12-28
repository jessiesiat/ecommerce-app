<?php

use Illuminate\Support\Facades\Schedule;
use App\Jobs\GenerateDailySalesReport;

Schedule::job(new GenerateDailySalesReport)->dailyAt('22:00'); // 10:00 PM