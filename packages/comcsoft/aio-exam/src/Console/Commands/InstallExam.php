<?php

namespace Comcsoft\Aio\Exam\Console\Commands;

use App\Helpers\General\MenuHelper;
use Illuminate\Console\Command;

class InstallExam extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aio:exam {todo : exam argument, `install` to install necessary data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aio exam console commands';

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
    public function handle(MenuHelper $menuHelper)
    {
        $todo = $this->argument('todo');

        if ($todo == 'install') {
            // install backend menu
            $parent = $menuHelper
                ->usingBackendMenu()
                ->addUrl(
                    __('aio-exam::backend.menu.titles.main'),
                    '#',
                    ['class' => 'nav-item nav-dropdown'],
                    ['fas fa-landmark']
                );

            $menuHelper->addRoute(
                __('aio-exam::backend.menu.titles.paper'),
                'aio-exam::admin.paper.index',
                ['class' => 'nav-item'],
                ['fas fa-clipboard']
            )->appendToNode($parent)
            ->save();

            $menuHelper->addRoute(
                __('aio-exam::backend.menu.titles.question'),
                'aio-exam::admin.question.index',
                ['class' => 'nav-item'],
                ['fas fa-pen-fancy']
            )->appendToNode($parent)
            ->save();

            $this->info('exam menu has been installed.');
        }
    }
}
