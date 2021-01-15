<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use DateTime;
use DB;
use Event;
use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Database\Events\TransactionCommitted;
use Illuminate\Database\Events\TransactionRolledBack;
use Log;

class SqlLogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if (config('logging.enable_sql_log') === false) {
            return;
        }

        DB::listen(function ($query) {
            $sql = $query->sql;
            foreach ($query->bindings as $binding) {
                if (is_string($binding)) {
                    $binding = "'{$binding}'";
                } elseif (is_bool($binding)) {
                    $binding = $binding ? '1' : '0';
                } elseif ($binding === null) {
                    $binding = 'NULL';
                } elseif ($binding instanceof Carbon) {
                    $binding = "'{$binding->toDateTimeString()}'";
                } elseif ($binding instanceof DateTime) {
                    $binding = "'{$binding->format('Y-m-d H:i:s')}'";
                }

                $sql = preg_replace("/\?/", $binding, $sql, 1);
            }

            Log::debug('SQL', ['sql' => $sql, 'time' => "$query->time ms"]);
        });

        Event::listen(TransactionBeginning::class, function (TransactionBeginning $event) {
            Log::debug('START TRANSACTION');
        });

        Event::listen(TransactionCommitted::class, function (TransactionCommitted $event) {
            Log::debug('COMMIT');
        });

        Event::listen(TransactionRolledBack::class, function (TransactionRolledBack $event) {
            Log::debug('ROLLBACK');
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
