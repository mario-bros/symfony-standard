<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Search;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Inventory;
use AppBundle\Form\InventoryType;

class InventoryController extends Controller
{
  
    /**
     * @Route("/inventory", name="inventory list")
     */
    public function indexAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $result = $entityManager->getRepository('AppBundle:Inventory')->findAll();
//        print_r($result); exit(' bye');

        $searchEntity = new Search;
        $form = $this->createFormBuilder($searchEntity)
            ->add('fieldOptions', 'choice', ['choices' => ['nama' => "Name", 'description' => "Description"], 'required' => false])
            ->add('keyWord', 'text', ['attr' => ['placeholder' => "fill the name / description"] ])
            ->add('search', 'submit', ['label' => 'Search'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $q = $request->request->all(); // Get the posted data

//            print_r($q); exit(' how ?');

            $fieldOption = $q['form']['fieldOptions']; // Get the field to search
            $keyWord = $q['form']['keyWord']; // Get the search keyword
//            $em = $this->getDoctrine()->getManager();
            $em = $this->getDoctrine();

            $repo = $em->getRepository('AppBundle:Inventory');
            $query = $repo->createQueryBuilder('i')
                ->where('i.' . $fieldOption . ' LIKE :keyWord')
                ->setParameter('keyWord', "%" . $keyWord . "%")
                ->getQuery();

//            print_r($query->getSql()); exit(' how ?');

            $result = $query->getResult();
//            if ($repo instanceof EntityRepository) {print_r(' haha'); exit(' bye');}
//            print_r($repo); exit(' ???');
//            $result = $repo->findBySearchResult($fieldOption, $keyWord);
        }

        return $this->render('inventory/index.html.twig', [
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'inventories' => $result,
            'form' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/inventory/add", name="inventory add")
     *
     */
    public function addAction(Request $request)
    {
        $inventoryEntity = new Inventory;
        $form = $this->createForm(new InventoryType(), $inventoryEntity);

        if ($request->getMethod() === 'POST') {
            //print_r($_FILES); exit(' bye');
            $form->handleRequest($request);
            if ($form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($inventoryEntity);
                $entityManager->flush();

                return $this->redirectToRoute('inventory list');
            }
        }

        return $this->render('inventory/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/inventory/delete/{id}", requirements={"id" = "\d+"}, name="inventory delete")
     * @Method({"GET"})
     */
    public function deleteAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entity = $entityManager->getRepository('AppBundle:Inventory')->findOneBy(array('id' => $id));

        if ($entity != null){
            $entityManager->remove($entity);
            $entityManager->flush();
        }

        return $this->redirectToRoute('inventory list');
    }

    /**
     * @Route("/inventory/detail/{id}", requirements={"id" = "\d+"}, name="inventory detail")
     * @Method({"GET"})
     */
    public function detailAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entity = $entityManager->getRepository('AppBundle:Inventory')->findOneBy(array('id' => $id));

        return $this->render('inventory/detail.html.twig', [
            'inventory' => $entity,
        ]);
    }

    /**
     * @Route("/inventory/edit/{id}", requirements={"id" = "\d+"}, name="inventory edit")
     */
    public function editAction($id, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $inventoryEntity = $entityManager->getRepository('AppBundle:Inventory')->findOneBy(array('id' => $id));

        $form = $this->createForm(new InventoryType(), $inventoryEntity);

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($inventoryEntity);
                $entityManager->flush();

                return $this->redirectToRoute('inventory list');
            }
        }

        return $this->render('inventory/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
