<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

// Modelos
use BlogBundle\Entity\Entry;

// Formulario
use BlogBundle\Form\EntryType;


class EntryController extends Controller
{

    private $session;

    public function __construct(){
        $this->session = new Session();
    }


    public function addAction(Request $request){
        $entry = new Entry();

        $form = $this->createForm(EntryType::class, $entry);

        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){
                $em = $this->getDoctrine()->getEntityManager();
                $category_repo = $em->getRepository("BlogBunde:Category");


                $entry = new Entry();
                $entry->setTitle($form->get("title")->getData());
                $entry->setContent($form->get("content")->getData());
                $entry->setStatus($form->get("status")->getData());
                $entry->setImage(null);
                $category = $category_repo->find($form->get("category")->getData());
                $entry->setCategory($category);
                $user = $this->getUser();
                $entry->setUser($user);

                $em->persist($entry);
                $flush = $em->flush();

                if($flush == null){
                    $status = "La entrada se ha creado correctamente";
                }else{
                    $status = "La entrada no se ha podido crear";
                }
            }else{
                $status = "Rellena los campos correctamente!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("blog_index_entry");

        }

        return $this->render(
            'BlogBundle:Entry:add.html.twig',
            array(
                "form" => $form->createView()
            )
        );
    }

}
