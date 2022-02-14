<?php

declare(strict_types=1);

namespace App\Model;

use Nette;
use Nette\SmartObject;
use Nette\Utils\DateTime;
use Nette\Database\Explorer;


final class CommentManager
{
    public function __construct(
        private Explorer $db,
    ) { }

    public function getCommentsByPostId(int $postId, int $limit = null)
	{
		$retVal = $this->db->table('comment')
			->where('post_id', $postId);
            
        if ($limit) {
            $retVal->limit($limit);
        }

        return $retVal;
	}

    public function insert(array $data)
    {
        return $this->db->table('comment')->insert($data);
    }
}