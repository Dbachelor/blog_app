<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use App\Service\PostService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{

    public $postService;
    
    public $comments = ['what a wonderful season', 'php is here to stay', 'AI can still be made better'];
    public $authors = ['Joachim', 'John', 'James'];
    public function __construct(PostService $postService){
        $this->postService = $postService;
    }

    /**
     * load dummy comments randomly for existing posts
     * */
    public function load(ObjectManager $objectManager){
        //Ensure ids are present
        $firstPostId = $this->postService->getPostId('ASC');
        $lastPostId = $this->postService->getPostId('DESC');
        $max_count = count($this->authors) - 1;
        $i = 0;
        //creating an average of 3 comments per post
        while ($i < 90){
            $randomIndex = rand(0, $max_count);
            $post_id = rand($firstPostId['id'], $lastPostId['id']);
            $post = $objectManager->getRepository(Post::class)->find($post_id);
            $comment = new Comment();
            $comment->setPost($post);
            $comment->setAuthor($this->authors[$randomIndex]);
            $comment->setCreatedAt();
            $comment->setText($this->comments[$randomIndex]);
            $objectManager->persist($comment);
            $i++;

        }
        $objectManager->flush();
    }

    public function getDependencies(){
        return [PostFixtures::class];
    }
}