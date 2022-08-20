<?php

namespace App\Console\Commands;

use App\Employer;
use Illuminate\Console\Command;

class UserSelect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'work:minute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Select all users';

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
     * @return mixed
     */
    public function handle()
    {
        $employers = Employer::with('education.faculty.institute')->get();
        if($employers)
            dd($employers);
    }
}
