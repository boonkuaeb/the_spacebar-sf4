<?php


namespace App\Controller;


use Michelf\MarkdownInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;
use Twig\Environment;


class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     *
     * @return Response
     */
    public function homepage()
    {
        return $this->render('article/homepage.html.twig');
    }


    /**
     * @Route("/news/{slug}", name="article_show")
     *
     * @param $slug
     * @param Environment $twigEnvironment
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function show($slug, MarkdownInterface $markdown , AdapterInterface $cache)
    {

        $comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
            'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];

        $articleContent = <<<EOF
        
        **turkey** shank eu pork belly meatball non cupim.

Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow,
lorem proident [beef ribs](https://baconipsum.com/) aute enim veniam ut cillum pork chuck picanha. Dolore reprehenderit
labore minim pork belly spare ribs cupim short loin in. Elit exercitation eiusmod dolore cow
turkey shank eu pork belly meatball non cupim.
Laboris beef ribs fatback fugiat eiusmod jowl kielbasa alcatra dolore velit ea ball tip. Pariatur
laboris sunt venison, et laborum dolore minim non meatball. Shankle eu flank aliqua shoulder,
capicola biltong frankfurter boudin cupim officia. Exercitation fugiat consectetur ham. Adipisicing
picanha shank et filet mignon pork belly ut ullamco. Irure velit turducken ground round doner incididunt
occaecat lorem meatball prosciutto quis strip steak.
Meatball adipisicing ribeye bacon strip steak eu. Consectetur ham hock pork hamburger enim strip steak
mollit quis officia meatloaf tri-tip swine. Cow ut reprehenderit, buffalo incididunt in filet mignon
strip steak pork belly aliquip capicola officia. Labore deserunt esse chicken lorem shoulder tail consectetur
cow est ribeye adipisicing. Pig hamburger pork belly enim. Do porchetta minim capicola irure pancetta chuck
fugiat.
EOF;

        $articleContent = $markdown->transform($articleContent);

        $item = $cache->getItem('markdown_'.md5($articleContent));
        if (!$item->isHit()) {
            $item->set($markdown->transform($articleContent));
            $cache->save($item);
        }
        $articleContent = $item->get();

        return $this->render('article/show.html.twig', [
            'articleContent' => $articleContent,
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'slug' => $slug,
            'comments' => $comments,
        ]);
    }


    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart")
     *
     * @param $slug
     * @return JsonResponse
     */
    public function toggleArticleHeart($slug, LoggerInterface $logger)
    {
        // TODO - actually heart/unheart the article!
        $logger->info('Article is being hearted!');
        return new JsonResponse(['hearts' => rand(5, 100)]);
    }


}