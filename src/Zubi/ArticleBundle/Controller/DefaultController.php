<?php

namespace Zubi\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Zubi\ArticleBundle\Entity\Article;
use Zubi\ArticleBundle\Form\Article\ArticleForm;

class DefaultController extends Controller
{
    
    public function indexAction() {        
        $em = $this->getDoctrine()->getEntityManager();            
        $articles = $em->getRepository('ZubiArticleBundle:Article')->findAll();     
        $a = 0;        
        $editLinks[0] = "";
        foreach ($articles as $article){
            $editLinks[$a] = $this->generateUrl('ZubiArticleBundle_showarticle',
                    array('id' => $article->getId()));
            $a++;
        }   
        return $this->render('ZubiArticleBundle:Default:index.html.twig',
                array (
                    'articles' => $articles,       
                    'editLinks' => $editLinks
                ));
    }
    
    public function showArticleAction($id){       
        $em = $this->getDoctrine()->getEntityManager();            
        $article = $em->getRepository('ZubiArticleBundle:Article')->findOneById($id);   
        //jeśli nie znaleziono artykułu, więc redirect na listę artyk
        if (!$article) {
            $this->get('session')->setFlash('errorMsg', 'Próbowałeś wyświetlić nieistniejący artykuł');
            return $this->redirect($this->generateUrl('ZubiArticleBundle_homepage'));
        }
        //jes artykuł więc dalej pobieramy autora, twórcę, kategorię 
        $author = $em->getRepository('ZubiUserBundle:Osoba')->findOneById($article->getAuthorId());
        $creator = $em->getRepository('ZubiUserBundle:User')->findOneById($article->getUserId());
        $category = $em->getRepository('ZubiArticleBundle:ArticleGroup')->findOneById($article->getGroupId());
        return $this->render('ZubiArticleBundle:Default:showArticle.html.twig',
                array (
                    'id' => $id,
                    'article' => $article,
                    'author' => $author,
                    'creator' => $creator,
                    'category' => $category,
                    'backLink' => $this->generateUrl('ZubiArticleBundle_homepage')
                ));
    }
    
    
    public function addAction()
    {
        $newArticle = new Article();
        $em = $this->getDoctrine()->getEntityManager();    
        $form = $this->createForm(new ArticleForm(), $newArticle);          
        return $this->render('ZubiArticleBundle:Default:add.html.twig',
                array (                   
                    'form' => $form->createView()                    
                ));
    }    
}
