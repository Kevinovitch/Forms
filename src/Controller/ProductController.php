<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductController extends AbstractController
{

    protected $em;

    protected $fileUploader;

    /**
     * @param EntityManagerInterface $em
     * @param FileUploader $fileUploader
     */
    public function __construct(EntityManagerInterface $em, FileUploader $fileUploader)
    {
        $this->em = $em;
        $this->fileUploader = $fileUploader;
    }


    /**
     * @Route("/product/list", name="app_product_list")
     */
    public function listProducts()
    {

        $products = $this->em->getRepository('App:Product')->findAll();

        return $this->render('product/list.html.twig', [
            'products' => $products
        ]);

    }


    /**
     * @Route("/product/new", name="app_product_new")
     */
    public function new(Request $request, SluggerInterface $slugger)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('brochureFilename')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile){
                $brochureFileName = $this->fileUploader->upload($brochureFile);
                $product->setBrochureFilename($brochureFileName);


            }

            $this->em->persist($product);
            $this->em->flush();

            return $this->redirect($this->generateUrl('app_product_list'));
        }

        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}