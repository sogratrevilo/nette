<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use App\Model\PostManager;
use App\Model\CommentManager;
use Nette\Database\Explorer;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;


final class PostPresenter extends Presenter
{
    public function __construct(
        private CommentManager $CommentManager,
        private PostManager $PostManager,
        private Explorer $db,
    ) { }

    public function renderShow(int $postId): void
	{
		$post = $this->PostManager->getById($postId);

        if (!$post) {
            $this->error('Stránka nebyla nalezena', 404);
        }

        $this->template->post = $post;
	    $this->template->comments = $post->related('comment')->order('created_at');
	}

    public function renderEdit(int $postId): void
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage("Třeba se přihlásit.", 'success');
            $this->redirect('Homepage:');
        }

        $post = $this->PostManager->getById($postId);

        if (!$post) {
            $this->error('Post not found', 404);
        }

        if ($post['user'] == $this->user->getId()) {   
            $this->getComponent('postForm')
            ->setDefaults($post->toArray());
        }

        else {
            $this->flashMessage("Nemáš na to.", 'success');
            $this->redirect('Post:show', $post->id);
        }
    }

    protected function createComponentCommentForm(): Form
    {
        $form = new Form;
        $form->addText('name', 'Jméno:')->setRequired();
        $form->addEmail('email', 'E-mail:');
        $form->addTextArea('content', 'Komentář:')->setRequired();
        $form->addSubmit('send', 'Publikovat komentář');
        $form->onSuccess[] = [$this, 'commentFormSucceeded'];
        return $form;
    }

    public function commentFormSucceeded(Form $form, \stdClass $data): void
    {
        $postId = $this->getParameter('postId');

        $this->CommentManager->insert([
            'post_id' => $postId,
            'name' => $data->name,
            'email' => $data->email,
            'content' => $data->content,
        ]);

        $this->flashMessage('Děkuji za komentář', 'success');
        $this->redirect('this');
    }

    protected function createComponentPostForm(): Form
    {
        $form = new Form;
        $form->addText('title', 'Titulek:')->setRequired();
        $form->addTextArea('content', 'Obsah:')->setRequired();
        $form->addSubmit('send', 'Uložit a publikovat');
        $form->onSuccess[] = [$this, 'postFormSucceeded'];
        return $form;
    }
    public function postFormSucceeded(array $data): void
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage("Třeba se přihlásit.", 'success');
            $this->redirect('Homepage:');
        }
        
        $postId = $this->getParameter('postId');
        $author = $this->user->getId();

        if ($postId) {
            $post = $this->db
                ->table('post')
                ->get($postId);
                $post->update($data);

        } else {
            $data['user'] = $author;
            $post = $this->PostManager->insert($data);
        }
        
        $this->flashMessage("Příspěvek byl úspěšně publikován.", 'success');
        $this->redirect('Post:show', $post->id);
    }
    public function actionCreate()
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage("Třeba se přihlásit.", 'success');
            $this->redirect('Homepage:');
        }
    }
}