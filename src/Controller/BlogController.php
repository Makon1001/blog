<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Article;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{


    /**
     * @Route("/blog", name="blog_index")
     */
    public function index()
    {
        return $this->render('blog/index.html.twig', [
            'owner' => 'Manuel',
        ]);
    }


    /**
     * @Route("/blog/show/{slug}", requirements={"slug"="[a-z0-9-]+"}, name="blog_show")
     */
    public function show($slug = 'Article Sans Titre')
    {
        $arrayTitre = (explode('-', $slug));
        foreach ($arrayTitre as $item) {
            $arrTitrAvMaj[] = ucwords($item);
        }
        $slug = implode(' ', $arrTitrAvMaj);
        return $this->render('blog/show.html.twig', [
            'slug' => $slug,
        ]);
    }

}