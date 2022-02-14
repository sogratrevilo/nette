<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use App\Model\PostManager;
use Nette\Application\UI\Presenter;


final class HomepagePresenter extends Presenter
{
    public function __construct(
        private PostManager $PostManager,
    ) { }

    public function renderDefault(): void
    {
        $this->template->posts = $this->PostManager->getPublicPosts(5);
    }
}