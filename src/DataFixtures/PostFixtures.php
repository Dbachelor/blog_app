<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture
{
    public $titles = ["my first summer adventure", "AI is really taking over", "Why PHP is still relevant"];
    public $contents = ["My first summer was an interesting one...", "The adoption of AI is gradually becoming...", "IN 2023 PHP ranked really high..."];

    public function load(ObjectManager $manager): void
    {
        //seed dummy data to post table
        $max_count = count($this->titles) - 1;
        $i= 0;
        while ($i < 30){
            $randomIndex = rand(0, $max_count);
            $post = new Post();
            $post->setTitle(" post title $i - ". $this->titles[$randomIndex]);
            $post->setContent(" post content $i - ". $this->contents[$randomIndex]);
            $post->setCreatedAt();
            $manager->persist($post);
            $i++;
        }

        $manager->flush();
    }
}