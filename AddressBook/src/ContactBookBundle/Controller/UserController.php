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


class UserController extends Controller
{
    
    /**
     * @Route("/new/")
     * @Method("GET")
     * @Template()
     */
    public function newContactSendDataByFormAction(Request $request) {
        // generate form to send new contact
        $newUser = new User();
        $form = $this->createFormBuilder($newUser)
            ->add("userName", "text")
            ->add("userSurname","text")
            ->add("userDescription","text")
            ->add("Create new ","submit")
            ->getForm(); 
        // return form view 
        return $this->render('ContactBookBundle:User:formUser.html.twig', array(
        "form" => $form->createView(), "title" => "Add new Contact"
        ));
    }
    
    
    /**
     * @Route("/new/")
     * @Method("POST")
     * @Template()
     */
    public function newContactRecivedDataByFormAction(Request $request) {
        // generate form to receive new contact and added to DB
        $receivedNewContact = new User();
        $form = $this->createFormBuilder($receivedNewContact)
            ->add("userName", "text")
            ->add("userSurname","text")
            ->add("userDescription","text")
            ->getForm();
        //handle request
        $form->handleRequest($request);
        // save to DB
        if($form->isSubmitted()){
            $receivedNewContact = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($receivedNewContact);
            $em->flush();     
        }
        $idNewContact = $receivedNewContact->getId();
        return $this->redirect("/$idNewContact/");
    }
     
     
    /**
     * @Route("/{id}/modify/")     
     * @Template()
     */
    public function createFormToModifyContactAction(Request $request, $id) {
        // find user in DB by send id
        $er = $this->getDoctrine()->getRepository("ContactBookBundle:User");
        $modifyContact = $er->find($id);
        if(!$modifyContact) {
            return new Response ("Contact isn't exist");
        }
        // create form to modify contact
        $form = $this->createFormBuilder($modifyContact)
            ->add("userName", "text")
            ->add("userSurname","text")
            ->add("userDescription","text")
            ->add("Modify contact ","submit")
            ->getForm();
        // update contact in DB
        $form->handleRequest($request);
        $modifyContact = $form->getData();
        $idModifyContact = $modifyContact->getId();
        if ($request->getMethod() == "POST"){
            $em = $this->getDoctrine()->getManager();
            $em->persist($modifyContact);
            $em->flush();
            return $this->redirect("/$idModifyContact/");
        }
        // return form to create form view 
        return $this->render('ContactBookBundle:User:formUserModify.html.twig', array(
        "form" => $form->createView(), "title" => "Modify Contact", "id"=> $idModifyContact
        ));
    }
    
    
    /**
     * @Route("/{id}/delete/")
     * @Template()
     */
    public function deleteContactAction(Request $request, $id) {
        //find contact in DB 
        $er = $this->getDoctrine()->getRepository("ContactBookBundle:User");
        $deleteContact = $er->find($id);
        if(!$deleteContact) {
            return new Response ("Contact isn't exist");
        }
        //remove contact
        $em = $this->getDoctrine()->getManager();
        $em->remove($deleteContact);
        $em->flush();
        //go back to view all contacts
        return $this->redirect("/");
    }
    
    
    /**
     * @Route("/{id}/")
     * @Method("GET")
     * @Template()
     */
    public function showOneContactAction(Request $request, $id) {
        //find contact in DB
        $er = $this->getDoctrine()->getRepository("ContactBookBundle:User");
        $showContact = $er->find($id);
        $address = $showContact->getAddress();
        $phone = $showContact->getPhones();
        if(!$showContact) {
            return new Response ("Contact isn't exist");
        }
        return $this->render('ContactBookBundle:User:showUser.html.twig', array(
        "contact" => $showContact, "address" => $address, "phone"=> $phone
        ));
    }
    
    
    /**
     * @Route("/")
     * @Method("GET")
     * @Template()
     */
    public function showAllContactAction(Request $request) {
        // find all contact and return view
        $er = $this->getDoctrine()->getRepository("ContactBookBundle:User");
        $allContacts = $er->findAll();
        return $this->render('ContactBookBundle:User:showAllUsers.html.twig', array(
        "allContacts" => $allContacts
        ));
    }
    
}
