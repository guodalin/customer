<?php

namespace Comcsoft\Aio\Comment\Console\Commands;

use App\Helpers\General\MenuHelper;
use Illuminate\Console\Command;

class InstallComment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comment:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install comment';

    /**
     * Create a new command instance.
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
        // install backend menu
        $menuHelper
            ->usingBackendMenu()
            ->addRoute(
                __('aio-comment::backend.menu.title'),
                'aio-comment::admin.comment.index',
                ['class' => 'nav-item'],
                ['far fa-comments']
            );
    }
}
