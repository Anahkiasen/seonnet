<?php
namespace Seonnet\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeTableCommand extends Command {

  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'seonnet:table';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Create a migration for the seonnet meta table';

  /**
   * The filesystem instance.
   *
   * @var \Illuminate\Filesystem\Filesystem
   */
  protected $files;

  /**
   * Create a new session table command instance.
   *
   * @param  \Illuminate\Filesystem\Filesystem  $files
   * @return void
   */
  public function __construct(Filesystem $files)
  {
    parent::__construct();

    $this->files = $files;
  }

  /**
   * Execute the console command.
   *
   * @return void
   */
  public function fire()
  {
    $fullPath = $this->createBaseMigration();

    $this->files->put($fullPath, $this->files->get(__DIR__.'/../../../stubs/migration.php'));

    $this->info('Migration created successfully!');
  }

  /**
   * Create a base migration file for the session.
   *
   * @return string
   */
  protected function createBaseMigration()
  {
    $name = 'create_seonnet';

    $path = $this->laravel['path'].'/database/migrations';

    return $this->laravel['migration.creator']->create($name, $path);
  }

}