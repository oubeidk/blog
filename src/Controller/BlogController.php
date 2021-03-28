<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends Controller
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(): Response
        
    {
        //permet de trouver les posts dans la base et les afficher par ordre decroissant avec la contrainte temps
        $posts =$this->getDoctrine()->getRepository(Post::class)
                        ->findBy([],['time'=>'DESC']);
        $latests = $this->getDoctrine()
                        ->getRepository(Post::class)
                        ->findBy([],['time'=>'DESC'],5);

        return $this->render('blog/index.html.twig', [
            'posts' => $posts,
            'latests' => $latests
        ]);
    }
    /**
     * @Route("/blog/{slug}", name="blog_show",requirements={"slug"=".+"})
     */
    public function show($slug)
        // recuperer un post par le slug (lire la suite)
    {
        $post = $this->getDoctrine()
                        ->getRepository(Post::class)
                        ->findOneBy(['slug' => $slug]);
        $latests = $this->getDoctrine()
                        ->getRepository(Post::class)
                        ->findBy([],['time'=>'DESC'],5);

        return $this->render('blog/show.html.twig', [
            'post' => $post,
            'latests' => $latests
        ]);
    }
     /**
     * @Route("/posts/{username}", name="user_posts")
     */
    public function renderUserPosts(User $user)
        // recuperer touts les posts d'un utilisateur par son nom
    {
        $posts = $this->getDoctrine()
                        ->getRepository(Post::class)
                        ->findBy(['user' => $user],['time'=>'DESC']);
        

        return $this->render('blog/user_posts.html.twig', [
            'posts' => $posts,
            'user' => $user
        ]);
    }
    
}
