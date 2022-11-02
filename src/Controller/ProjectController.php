<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\component\HttpFoundation\JsonResponse;
use App\Entity\Shoe;
use App\Entity\Brand;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\Type\ShoeType;
use App\Form\Type\BrandType;
use App\Form\Type\RegistrationFormType; 
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;




class ProjectController extends AbstractController
{
  


    #[Route('', name: 'homepage')]
    function homepagefct(
        ManagerRegistry $doctrine
    ): Response {
      
      $allproducts = $doctrine->getRepository(Shoe::class)->findAll();
      $isnewshoe = $doctrine->getRepository(Shoe::class)->findOneBy(['isnew'=>1]);
      $allbrands = $doctrine->getRepository(Brand::class)->findAll();
      $isnewbrand = $doctrine->getRepository(Brand::class)->findOneBy(['isnew'=>1]);
      


      return $this->render('homepage.html.twig' , [
        "allproducts"=>$allproducts,
        "isnewshoe" => $isnewshoe,
        "allbrands" => $allbrands,
        "isnewbrand" => $isnewbrand,
       ]);
    }
    #[IsGranted('ROLE_USER')]
    #[Route('/adminhomepage', name: 'adminhomepage')]
    function adminhomepagefct(ManagerRegistry $doctrine): Response {
      $allproducts = $doctrine->getRepository(Shoe::class)->findAll();
      $allbrands = $doctrine->getRepository(Brand::class)->findAll();
       return $this->render('adminhomepage.html.twig' , [
        "allproducts"=>$allproducts,
        "allbrands"=>$allbrands,
       ]);
    }

    #[Route('/connexion', name: 'connexion')]
    function connexionfct(ManagerRegistry $doctrine): Response {
      $allbrands = $doctrine->getRepository(Brand::class)->findAll();
       return $this->render('connect/index.html.twig',[
        "allbrands" => $allbrands,
       ]);
    }
    #[IsGranted('ROLE_USER')]
    #[Route('/newproduct', name: 'product_new')]
    function newproductfct(Request $request, ManagerRegistry $doctrine): Response {
      $shoe = new Shoe();

      $form = $this->createForm(ShoeType::class, $shoe);

      $form->handleRequest($request);
      
      if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $doctrine->getManager();
        $shoe = $form->getData();
        $entityManager->persist($shoe);
        $entityManager->flush();

        return $this->redirectToRoute('product_new');
    }
      return $this->renderForm('formsubmitted.html.twig', [
          'form' => $form,
      ]);
    }
    #[IsGranted('ROLE_USER')]
    #[Route('/newbrand', name: 'brand_new')]
    function newbrandfct(Request $request, ManagerRegistry $doctrine): Response {
      $brand = new Brand();

      $form = $this->createForm(BrandType::class, $brand);

      $form->handleRequest($request);
      
      if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $doctrine->getManager();
        $brand = $form->getData();
        $entityManager->persist($brand);
        $entityManager->flush();

        return $this->redirectToRoute('brand_new');
    }
    return $this->renderForm('formsubmitted.html.twig', [
      'form' => $form,
  ]);
    }

    
    #[IsGranted('ROLE_USER')]
    #[Route('/modifproduct/{slug}', name: 'product_modif')]
    function productmodiffct(string $slug, ManagerRegistry $doctrine, Request $request): Response {
      $allproducts = $doctrine->getRepository(Shoe::class)->findAll();
      $allbrands = $doctrine->getRepository(Brand::class)->findAll();
      $product= $doctrine->getRepository(Shoe::class)->findOneBy(['id'=>$slug]);
    
      

      $form = $this->createForm(ShoeType::class, $product);

      $form->handleRequest($request);
      
      if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $doctrine->getManager();
        $product = $form->getData();
        $entityManager->persist($product);
        $entityManager->flush();

        return $this->redirectToRoute('adminhomepage');
    }
    return $this->renderForm('productmodif.html.twig', [
      "allproducts"=>$allproducts,
      "slug"=>$slug,
      "allbrands"=>$allbrands,
      "product"=>$product,
      "form"=>$form
    ]);
 }
     

    #[Route('/product/{slug}', name: 'product_specific')]
    public function show(string $slug, ManagerRegistry $doctrine): Response
    {
      $allproducts = $doctrine->getRepository(Shoe::class)->findAll();
      $allbrands = $doctrine->getRepository(Brand::class)->findAll();
      $product= $doctrine->getRepository(Shoe::class)->findOneBy(['id'=>$slug]);
     
        return $this->render('specificshoe.html.twig', [

         "allproducts"=>$allproducts,
         "slug"=>$slug,
         "allbrands"=>$allbrands,
         "shoe"=>$product
       ]);
    }

    #[Route('/brand/{slug}', name: 'brand_specific')]
    public function specificbrand(string $slug, ManagerRegistry $doctrine): Response
    {
      $allproducts = $doctrine->getRepository(Shoe::class)->findAll();
      $allbrands = $doctrine->getRepository(Brand::class)->findAll();
      $brand=$doctrine->getRepository(Brand::class)->findOneBy(['id'=>$slug]);
        return $this->render('specificbrand.html.twig', [
         
          "allproducts"=>$allproducts,
          "slug"=>$slug,
          "allbrands"=>$allbrands,
          "brand"=>$brand
       ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/product/delete/{id}', name: 'product_delete')]
    public function Delete(ManagerRegistry $doctrine, string $id): Response
    {
        $entityManager = $doctrine->getManager();
        $shoe = $doctrine->getRepository(Shoe::class)->find($id);
        $entityManager->remove($shoe);
        $entityManager->flush();
        return $this->redirectToRoute('adminhomepage');

    }
    
    #[IsGranted('ROLE_USER')]
    #[Route('/brand/delete/{id}', name: 'brand_delete')]
    public function Deletebrand(ManagerRegistry $doctrine, string $id): Response
    {
        $entityManager = $doctrine->getManager();
        $brand = $doctrine->getRepository(Brand::class)->find($id);
        $entityManager->remove($brand);
        $entityManager->flush();
        return $this->redirectToRoute('adminhomepage');

    }
    
    #[IsGranted('ROLE_USER')]
    #[Route('/brandmodif/{slug}', name: 'brand_modif')]
    function brandmodiffct(string $slug, ManagerRegistry $doctrine, Request $request): Response {
      $allproducts = $doctrine->getRepository(Shoe::class)->findAll();
      $allbrands = $doctrine->getRepository(Brand::class)->findAll();
      $brand= $doctrine->getRepository(Brand::class)->findOneBy(['id'=>$slug]);
      $product= $doctrine->getRepository(Brand::class)->findOneBy(['id'=>$slug]);
      

      $form = $this->createForm(BrandType::class, $brand);

      $form->handleRequest($request);
      
      if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $doctrine->getManager();
        $product = $form->getData();
        $entityManager->persist($product);
        $entityManager->flush();

        return $this->redirectToRoute('adminhomepage');
    }
    return $this->renderForm('productmodif.html.twig', [
      "allproducts"=>$allproducts,
      "slug"=>$slug,
      "allbrands"=>$allbrands,
      "product"=>$product,
      "form"=>$form
    ]);
 }
    
 #[Route('/search', name: 'search')]
    public function Search(ManagerRegistry $doctrine): Response
    {
      $allproducts = $doctrine->getRepository(Shoe::class)->findAll();
      $allbrands = $doctrine->getRepository(Brand::class)->findAll();
      return $this->render('search.html.twig', [
        "allproducts"=>$allproducts,
        "allbrands"=>$allbrands,
        "search"=>$_POST['search']
     ]);
    }

    /*
    #[IsGranted('ROLE_USER')]
    #[Route('/newisnewshoe/{slug}', name: 'newisnewshoe')]
    public function newisnewshoe(ManagerRegistry $doctrine, string $slug): Response
    {
      $entityManager = $doctrine->getManager();
      $allproducts = $doctrine->getRepository(Shoe::class)->findAll();
      $allbrands = $doctrine->getRepository(Brand::class)->findAll();
      $product= $doctrine->getRepository(Brand::class)->findOneBy(['id'=>$slug]);
      foreach($allproducts as $element){
        $element->setIsnew('0');
        $entityManager->persist($element);
      }
      $product->setIsnew('1');
      $entityManager->persist($product);
      $entityManager->flush();

      return $this->redirectToRoute('adminhomepage');
    }
    */
}