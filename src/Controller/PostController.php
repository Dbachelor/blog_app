<?php

namespace App\Controller;

use App\Service\PostService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{

    public $postService;
    public function __construct(PostService $postService){
        $this->postService = $postService;
    }


    #[Route('/posts', name: 'app_post', methods:['GET'])]
    public function index(): JsonResponse
    {
        $posts = $this->postService->fetchAllPost(isset($_GET['page'])?$_GET['page']:1, isset($_GET['search'])?$_GET['search']:null);
        if (!is_array($posts)){
            return $this->json(["success"=>false, "message"=>"something went wrong"], 500);
        }
        if (count($posts) == 0){
            $message = "no post found";
            if (isset($_GET['search'])){
                $message .= " for keyword " . $_GET['search'];
            }
            return $this->json(["success"=>true, "message"=>$message], 404);
        }else{
            return $this->json(["sucees"=>true, "data"=>$posts], 200);
        }
    }
}
