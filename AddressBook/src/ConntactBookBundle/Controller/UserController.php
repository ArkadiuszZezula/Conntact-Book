<?php

namespace ConntactBookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ConntactBookBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class UserController extends Controller
{
    
    /**
     * @Route("/new/")
     * @Method("GET")
     * @Template()
     */
    public function newConntactSendDataByFormAction(Request $request) {
        // generate form to send new conntact
        $newUser = new User();
        $form = $this->createFormBuilder($newUser)
            ->setAction( $this->generateUrl("conntactbook_user_newconntactreciveddatabyform"))
            ->add("userName", "text")
            ->add("userSurname","text")
            ->add("userDescription","text")
            ->add("Create new ","submit")
            ->getForm(); 
        // return form view 
        return $this->render('ConntactBookBundle:User:formUser.html.twig', array(
        "form" => $form->createView(), "title" => "Add new Conntact"
        ));
    }
    
    
    /**
     * @Route("/new/")
     * @Method("POST")
     * @Template()
     */
    public function newConntactRecivedDataByFormAction(Request $request) {
        // generate form to receive new conntact and added to DB
        $receivedNewConntact = new User();
        $form = $this->createFormBuilder($receivedNewConntact)
            ->add("userName", "text")
            ->add("userSurname","text")
            ->add("userDescription","text")
            ->getForm();
        //handle request
        $form->handleRequest($request);
        // save to DB
        if($form->isSubmitted()){
            $receivedNewConntact = $form->getData();
            $idNewConntact = $receivedNewConntact->getId();
            $em = $this->getDoctrine()->getManager();
            $em->persist($receivedNewConntact);
            $em->flush();            
        }
        return $this->redirectToRoute("/$idNewConntact");
    }
     
     
    /**
     * @Route("/{id}/modify")
     
     * @param Request $request
     * @param type $id
     * @return type* @Template()
     */
    public function createFormToModifyConntactAction(Request $request, $id) {
        // find user in DB by send id
        $er = $this->getDoctrine()->getRepository("ConntactBookBundle:User");
        $modifyConntact = $er->find($id);
        // create form to modify conntact
        $form = $this->createFormBuilder($modifyConntact)
            ->add("userName", "text")
            ->add("userSurname","text")
            ->add("userDescription","text")
            ->add("Modify conntact ","submit")
            ->getForm();
        // update conntact in DB
        if ($request->getMethod() == "POST"){
                $form->handleRequest($request);
                $modifyConntact = $form->getData();
                $idModifyConntact = $modifyConntact->getId();
                $em = $this->getDoctrine()->getManager();
                $em->persist($modifyConntact);
                $em->flush();
                return $this->redirectToRoute("/$idModifyConntact");
            }
        // return form to create form view 
        return $this->render('ConntactBookBundle:User:formUser.html.twig', array(
        "form" => $form->createView(), "title" => "Modify Conntact"
        ));
    }
    
    
    
    
    
}
