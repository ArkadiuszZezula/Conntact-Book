<?php

namespace ContactBookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ContactBookBundle\Entity\User;
use ContactBookBundle\Entity\Address;
use ContactBookBundle\Entity\Phone;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PhoneController extends Controller
{
    
    
    /**
     * @Route("/{id}/addPhone/")     
     * @Template()
     */
    public function createFormToModifyAddressAction(Request $request, $id) {
        
        // generate form to add or update phone
        $er1 = $this->getDoctrine()->getRepository("ContactBookBundle:User");
        $newPhone = new Phone(); 
        
        //check if phone exist
        if(!empty($er1->find($id)->getPhones())){
            $phoneId = $er1->find($id)->getPhones()->getId();
            $er2 = $this->getDoctrine()->getRepository("ContactBookBundle:Phone");
            $newPhone = $er2->find($phoneId); 
        } 
        //fill form address
           $formPhone = $this->createFormBuilder($newPhone)
            ->add("number", "number")
            ->add("type","text")
            ->add("Add/Update Phone","submit")
            ->getForm(); 
       
        if ($request->getMethod() == "POST"){
            //handle request 
            $formPhone->handleRequest($request);
            $newPhone = $formPhone->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($newPhone);
            $em->flush();
            //added address in user table
            $er = $this->getDoctrine()->getRepository("ContactBookBundle:User");
            $modifyContact = $er->find($id);
            $form = $this->createFormBuilder($modifyContact)
                ->add("address","text")
                ->getForm();
            $form->handleRequest($request);
            $modifyContact = $form->getData();    
            $modifyContact->setPhones($newPhone);
            $em = $this->getDoctrine()->getManager();
            $em->persist($modifyContact);
            $em->flush();            
            return $this->redirect("/$id/");
        }
        // create view to add/modify address   
        return $this->render('ContactBookBundle:Phone:addPhone.html.twig', array(
        "formPhone" => $formPhone->createView()
        ));
    }
    
}
