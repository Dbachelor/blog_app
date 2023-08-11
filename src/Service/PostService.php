<?php 

namespace App\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class PostService
{
    public $entityManagerInterface;

    public function __construct(EntityManagerInterface $entityManagerInterface){
        $this->entityManagerInterface = $entityManagerInterface;
    }


    public function fetchAllPost($page=1, $search=null){
        $data = [];
        if ($page < 1){
            $page = 1;
        }
        $offset = ($page - 1) * 10;
        //using sql for better optimization
        $sql = "SELECT * FROM post WHERE 1";
        if ($search){
            $search = strtolower($search);
            $sql .= " AND (title LIKE '%$search%' OR content LIKE '%$search%')";
        }
        $sql .= " ORDER BY id DESC LIMIT $offset, 10";
        // echo $sql;
        $posts = $this->entityManagerInterface->getConnection()->executeQuery($sql)->fetchAllAssociative();
        foreach ($posts as $post){
            $data[] = ["id"=>$post['id'], "title"=>$post['title'], "content"=>$post['content'], "comments"=>$this->getPostComments($post['id'])];
        }
        return $data;
    }

    /**
     * getting all comments associated with a post
     */
    public function getPostComments($post_id){
        return $this->entityManagerInterface->getConnection()->executeQuery("SELECT * FROM comment WHERE post_id = :post_id", ['post_id'=>$post_id])->fetchAllAssociative();
    }

    public function getPostId($order){
       return $this->entityManagerInterface->getConnection()->executeQuery("SELECT id FROM post order BY id $order")->fetchAllAssociative()[0];
    }
}