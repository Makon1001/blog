<?php


namespace App\Controller;


use App\Entity\Category;
use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;




class BlogController extends AbstractController
{


    /**
     * @Route("/blog", name="blog_index")
     */
    public function index()
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }

        return $this->render(
            'blog/index.html.twig',
            ['articles' => $articles]
        );
    }


    /**
     * Getting a article with a formatted slug for title
     *
     * @param string $slug The slugger
     *
     * @Route("blog/show/{slug<^[a-z0-9-]+$>}",
     *     defaults={"slug" = null},
     *     name="blog_show")
     * @return Response A response instance
     */
    public function show(?string $slug) : Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }

        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article with '.$slug.' title, found in article\'s table.'
            );
        }

        return $this->render(
            '/blog/show.html.twig',
            [
                'article' => $article,
                'slug' => $slug,
            ]
        );
    }

    /**
     * @param string $category
     * @Route("/blog/category/{name<^[a-zA-Z0-9-]+$>}",
     *      defaults={"name" = null},
     *  name="show_category")
     *  @return Response
     */
    public function showByCategory(Category $category)
    {
        if(!$category) {
            throw $this
                ->createNotFoundException('No categoryName send ');
        }

        $articles = $category->getArticles();

        return $this->render(
            'blog/category.html.twig',
            [
                'articles' => $articles,
                'category' => $category
            ]
        );


    }
    /*public function showByCategory(string $categoryName)
    {
        if (!$categoryName) {
            throw $this
                ->createNotFoundException('No category Name has been sent to find articles in article\'s table.');
        }

        $categoryName = ucwords(trim(strip_tags($categoryName)));

        $category=  $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneByName($categoryName);

        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            -> findByCategory(
                $category,
                ['id' => 'DESC'],
                3);

        return $this->render(
            'blog/category.html.twig',
            [
                'articles' => $articles,
                'categoryName' => $categoryName,
            ]
        );
    }*/


    /**
     * @param Tag $tag
     * @Route("/tag/{name<\w+>}",defaults={"name" = null}, name="show_tag")
     * @return Response
     */
    public function showByTag (Tag $tag)
    {
        if(!$tag) {
            throw $this
                ->createNotFoundException('No tag Name send ');
        }

        $articles = $tag->getArticles();

        return $this->render(
            'blog/tag.html.twig',
            [
                'articles' => $articles,
                'tag' => $tag
            ]
        );

    }

    /**
     * @param Article $article
     * @Route("article/{id}", name="show_ById")
     */
    public function showById (Article $article)
    {
        if (!$article) {
            throw $this->createNotFoundException(
                'No article with '.$article.' title, found in article\'s table.'
            );
        }


        return $this->render(
            'blog/detail.html.twig',
            [
                'article' => $article
            ]
        );
    }


}