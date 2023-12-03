<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

class Update extends Command
{
    use ConfirmableTrait;

    protected $signature = 'update:production
                              {--force : Force the operation to run when in production.}';

    protected $description = 'Perform update of AppHouse';

    public function handle()
    {
        if (!$this->confirmToProceed()) {
            return;
        }

        try {
            $this->call('down', ['--retry' => '10']);
            $this->call('config:clear');
            $this->call('route:clear');
            $this->call('view:clear');
            $this->call('cache:clear');

            $this->call('migrate', ['--force' => true]);
        } finally {
            $this->call('up');
        }

        $this->line('Application is update, enjoy.');
    }
}
