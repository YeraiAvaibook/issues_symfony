<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Entity\Incidencia;
use App\Events\IncidenciaEvent;
use App\Form\IncidenciaSearchType;
use App\Form\IncidenciaType;
use App\Managers\IncidenciaManager;
use App\Repository\IncidenciaRepository;
use App\Services\MessageGenerator;
use App\Services\SecurityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/incidencia")
 */
class IncidenciaController extends AbstractController
{

    /**
     * @Route("/", name="incidencia_index", methods={"GET", "POST"})
     */
    public function index(Request $request, IncidenciaRepository $incidenciaRepository): Response
    {
        $formSearch = $form = $this->createForm(IncidenciaSearchType::class, null);
        $formSearch->handleRequest($request);

        if($formSearch->isSubmitted()){
            $categoriaSearch = $formSearch->getData()['categoriaSearch'];
            $tituloSearch = $formSearch->getData()['tituloSearch'];
            $incidencias = $incidenciaRepository->findByTitleAndCategory($categoriaSearch, $tituloSearch);
        }else{
            $incidencias = $incidenciaRepository->findAll();
        }

        return $this->render('incidencia/index.html.twig', array(
            'incidencias' => $incidencias,
            'formSearch' => $formSearch->createView()
        ));
    }

    /**
     * @Route("/new", name="incidencia_new", methods={"GET", "POST"})
     */
    public function new(Request $request, IncidenciaManager $incidenciaManager, SecurityService $securityService): Response
    {
        $incidencia = $incidenciaManager->newObject();
        $form = $this->createForm(IncidenciaType::class, $incidencia);
        $form->handleRequest($request);

        $user = $securityService->getUser();

        if($form->isSubmitted() && $form->isValid()){

            $incidenciaManager->create($incidencia, $form);

            $this->addFlash('success', 'Bien hecho!!');

            return $this->redirectToRoute('incidencia_show', [
                'id' => $incidencia->getId()
            ]);

        }

        return $this->render('incidencia/new.html.twig', [
            'incidencias' => $incidencia,
            'form' => $form->createView(),
	        'user' => $user
        ]);
    }

    /**
     * @Route("/{id}", name="incidencia_show", methods={"GET"})
     */
    public function show(Incidencia $incidencia, MessageGenerator $messageGenerator): Response
    {
        $mensaje = '';

        if($messageGenerator->comprobarTexto($incidencia->getTitulo()) !== false){
            $mensaje = $messageGenerator->getMensajeIncidencia();
            $mensaje = $this->addFlash('success', $mensaje);
        }

        return $this->render('incidencia/show.html.twig', [
            'incidencia' => $incidencia,
            'mensaje' => $mensaje
        ]);
    }

    /**
     * @Route("/{id}/edit", name="incidencia_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Incidencia $incidencia, IncidenciaManager $incidenciaManager): Response
    {

        $form = $this->createForm(IncidenciaType::class, $incidencia);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $incidenciaManager->update($incidencia, $form);

            $this->addFlash('success', 'Bien hecho!!');

            return $this->redirectToRoute('incidencia_show', [
                'id' => $incidencia->getId()
            ]);
        }

        return $this->render('incidencia/edit.html.twig', [
            'incidencia' => $incidencia,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="incidencia_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Incidencia $incidencia, IncidenciaManager $incidenciaManager): Response
    {
        if($this->isCsrfTokenValid('delete'.$incidencia->getId(), $request->request->get('_token'))){
            $incidenciaManager->delete($incidencia);
        }

        return $this->redirectToRoute('incidencia_index');
    }
}