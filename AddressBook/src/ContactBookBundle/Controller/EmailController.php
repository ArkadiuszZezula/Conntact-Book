<?php

namespace ContactBookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ContactBookBundle\Entity\User;
use ContactBookBundle\Entity\Email;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class EmailController extends Controller
{
    
    /**
     * @Route("/{id}/addEmail/")     
     * @Template()
     */
    public function createFormToAddOrModifyEmailAction(Request $request, $id) {
        
        // generate form to add or update email
        $er1 = $this->getDoctrine()->getRepository("ContactBookBundle:User");
        $newEmail = new Email(); 
        
        //check if email exist
        if(!empty($er1->find($id)->getEmails())){
            $emailId = $er1->find($id)->getEmails()->getId();
            $er2 = $this->getDoctrine()->getRepository("ContactBookBundle:Email");
            $newEmail = $er2->find($emailId); 
        } 
        //fill form email
           $formEmail = $this->createFormBuilder($newEmail)
            ->add("addressEmail", "text")
            ->add("type","text")
            ->add("Add/Update Email","submit")
            ->getForm(); 
       
        if ($request->getMethod() == "POST"){
            //handle request 
            $formEmail->handleRequest($request);
            $newEmail = $formEmail->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($newEmail);
            $em->flush();
            //added email to user table
            $er = $this->getDoctrine()->getRepository("ContactBookBundle:User");
            $modifyContact = $er->find($id);
            $form = $this->createFormBuilder($modifyContact)
                ->add("emails","text")
                ->getForm();
            $form->handleRequest($request);
            $modifyContact = $form->getData();    
            $modifyContact->setEmails($newEmail);
            $em = $this->getDoctrine()->getManager();
            $em->persist($modifyContact);
            $em->flush();            
            return $this->redirect("/$id/");
        }
        // create view to add/modify email   
        return $this->render('ContactBookBundle:Email:addEmail.html.twig', array(
        "formEmail" => $formEmail->createView()
        ));
    }
}
