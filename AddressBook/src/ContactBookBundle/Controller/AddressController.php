<?php

namespace ContactBookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ContactBookBundle\Entity\Address;
use ContactBookBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\Common\Collections\ArrayCollection;

class AddressController extends Controller
{

    
    /**
     * @Route("/{id}/addAddress/")     
     * @Template()
     */
    public function createFormToModifyAddressAction(Request $request, $id) {
        
        // generate form to add or update address
        $er1 = $this->getDoctrine()->getRepository("ContactBookBundle:User");
        $newAddress = new Address(); 
        
        //check if address exist
        if(!empty($er1->find($id)->getAddress())){
            $addressId = $er1->find($id)->getAddress()->getId();
            $er2 = $this->getDoctrine()->getRepository("ContactBookBundle:Address");
            $newAddress = $er2->find($addressId); 
        } 
        //fill form address
           $formAddress = $this->createFormBuilder($newAddress)
            ->add("city", "text")
            ->add("street","text")
            ->add("nrHouse","text")
            ->add("nrFlat","text")
            ->add("Add/Update Address","submit")
            ->getForm(); 
       
        if ($request->getMethod() == "POST"){
            //handle request 
            $formAddress->handleRequest($request);
            $newAddress = $formAddress->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($newAddress);
            $em->flush();
            //added address in user table
            $er = $this->getDoctrine()->getRepository("ContactBookBundle:User");
            $modifyContact = $er->find($id);
            $form = $this->createFormBuilder($modifyContact)
                ->add("address","text")
                ->getForm();
            $form->handleRequest($request);
            $modifyContact = $form->getData();    
            $modifyContact->setAddress($newAddress);
            $em = $this->getDoctrine()->getManager();
            $em->persist($modifyContact);
            $em->flush();            
            return $this->redirect("/$id/");
        }
        // create view to add/modify address   
        return $this->render('ContactBookBundle:Address:addAddress.html.twig', array(
        "formAddress" => $formAddress->createView()
        ));
    }
    
    
    
    
    
}
