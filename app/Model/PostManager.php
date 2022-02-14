<?php

declare(strict_types=1);

namespace App\Model;

use Nette;
use Nette\SmartObject;
use Nette\Utils\DateTime;
use Nette\Database\Explorer;


final class PostManager
{
    public function __construct(
        private Explorer $db,
    ) { }

    public function getPublicPosts(int $limit = null)
	{
		$retVal = $this->db
			->table('post')
			->where('created_at < ', new DateTime)
			->order('created_at DESC');
            
        if ($limit) {
            $retVal->limit($limit);
        }
        
        return $retVal;
	}

    public function getById(int $id)
    {
        return $this->db->table('post')->get($id);
    }

    public function insert(array $data)
    {
        return $this->db->table('post')->insert($data);
    }
}