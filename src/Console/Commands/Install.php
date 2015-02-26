<?php namespace Cinject\AdminPanel\Console\Commands;

use Cinject\AdminPanel\Providers\AdminPanelServiceProvider;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Install extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'adminPanel:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'AdminPanel install command';

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
    public function fire()
    {
        if ($this->confirm('Generate user model and migrate? [y|N]')) {

            $this->call('make:model', ['name' => 'User', '--no-migration' => true]);
            $this->call('vendor:publish', [
                '--provider' => AdminPanelServiceProvider::class,
                '--tag' => 'migrate',
            ]);

        }

        $this->call('entrust:migration');

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
//	protected function getArguments()
//	{
//		return [
//			['example', InputArgument::REQUIRED, 'An example argument.'],
//		];
//	}
//
//	/**
//	 * Get the console command options.
//	 *
//	 * @return array
//	 */
//	protected function getOptions()
//	{
//		return [
//			['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
//		];
//	}

}
