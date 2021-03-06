<?php
/**
 * Created by PhpStorm.
 * User: Seb
 * Date: 26/04/2019
 * Time: 10:29
 */

namespace App\Controller;


use App\Entity\Medicament;
use App\Entity\MedicamentFilter;
use App\Entity\Products;
use App\Form\MedicamentFilterType;
use App\Form\ProductType;
use App\Repository\MedicamentRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedicamentController extends AbstractController
{
    /**
     * @var
     */
    private $repository;
    /**
     * @var
     */
    private $em;

    public function __construct(MedicamentRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/dash/medicaments", name="dash.medicament.index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        if(!$this->getUser()->getFamille()){
            return $this->redirectToRoute("dash.familles.init");
        }
        //On ajoute le formulaire de recherche et on le passe en argument à la requette
        $search = new MedicamentFilter();
        $form = $this->createForm(MedicamentFilterType::class, $search, [
            'famille' => $this->getUser()->getFamille()
        ]);
        $form->handleRequest($request);

        //on récupère la requette SQL dans le repository
        $queryMedicament = $this->repository->findAllEnableQuery($search, $this->getUser()->getFamille());

        //On utilise le bundle Paginator KNP
        $medicament = $paginator->paginate(
            $queryMedicament,
            $request->query->getInt('page', 1),
            10
        );



        return $this->render("medicaments/index.html.twig", [
            "current_menu" => "medicaments",
            "medicaments" => $medicament,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/dash/medicaments/{slug}-{id}", name="dash.medicament.detail", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function detail($slug, Medicament $medicament, Request $request): Response
    {
        if(!$this->getUser()->getFamille()){
            return $this->redirectToRoute("dash.familles.init");
        }
        //$medicament = $this->repository->find($id);
        ///*A la place de mettre $id en argument et de faire une recherche avec la méthode find comme ci-dessus,
        /// on peut faire une injection de l'entity Medicament, etant donné que symfony trouve un id, symfony va faire
        /// la recherche à notre place
$newProduct = new Products();
        //$form = $this->createForm(ProductType::class, $medicament);

        if ($medicament->getSlug() !== $slug) {
            return $this->redirectToRoute("dash.medicament.detail", [
                "id" => $medicament->getId(),
                "slug" => $medicament->getSlug()
            ], 301);
        }
        $form = $this->createForm(ProductType::class, $newProduct, [
            'famille' => $this->getUser()->getFamille(),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $newProduct->setFamille($this->getUser()->getFamille());
            $newProduct->setMedicament($medicament);
            $newProduct->setQuantity($medicament->getQuantity());
            $newProduct->setInitialQuantity($medicament->getQuantity());
            $this->em->persist($newProduct);
            $this->em->flush();
            $this->addFlash('success', 'Le médicament a bien été ajouté');
            //return $this->redirectToRoute("admin.medicaments.detail");
        }

        return $this->render("medicaments/detail.html.twig", [
            "medicament" => $medicament,
            "current_menu" => "medicaments",
            "slug" => $slug,
            "form" => $form->createView()
        ]);
    }


}