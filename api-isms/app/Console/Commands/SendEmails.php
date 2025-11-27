<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendEmails extends Command
{


        /**
     * The name of the command/process we want to monitor. This string will be used both to check to see if the process
     * is currently running and to spawn it (The arguments are appended to it).
     *
     * @var string
     */
    protected $command = 'php artisan queue:work';

    /**
     * The arguments to pass to the process when spawning it.
     *
     * @var string
     */
    protected $arguments = '--tries=3';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue-process-listener';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'queue-process-listener';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!$this->isProcessRunning($this->command)) {
            $this->info("Starting queue listener.");
            $this->executeShellCommand($this->command, $this->arguments, true);
        } else {
            $this->info("Queue listener is running.");
        }
    }
    /**
     * Execute a shell command, with the provided arguments, and optionally in the background. Commands that are not run
     * in the background will return their output/response.
     *
     * @param $command
     * @param string $arguments
     * @param bool $background
     * @return string
     */
    public function executeShellCommand($command, $arguments = '', $background = false)
    {
        $command = trim($command);
        if (!is_string($command) || empty($command)) {
            return null;
        }

        $arguments = trim($arguments);

        $cmd = trim($command . ' ' . $arguments) . ($background ? ' > /dev/null 2>/dev/null &' : '');
        return shell_exec($cmd);
    }

    /**
     * Check if a process is running using pgrep.
     *
     * @param $process
     * @return bool
     */
    public function isProcessRunning($process)
    {
        $output = $this->executeShellCommand('pgrep -f "' . $process . '"');

        return !empty(trim($output));
    }
}
