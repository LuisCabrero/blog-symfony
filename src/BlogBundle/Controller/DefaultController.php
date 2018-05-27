<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexOld()
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$entry_repo = $em->getRepository("BlogBundle:Entry");

    	$entries = $entry_repo->findAll();

    	if(!empty($entries)){
    		foreach ($entries as $key => $entry) {
	    		echo $enty->getTitle().'<br>';
	    		echo $enty->getCategory()->getName().'<br>';
	    		echo $enty->getUser()->getName().'<br><hr>';
	    	}
    	}else{
    		echo "There are no entries yet!<br><hr>";
    	}
    	

        return $this->render('BlogBundle:Default:index.html.twig');
    }

    public function indexAction()
    {
        return $this->render('BlogBundle:Default:index.html.twig');
    }
}
