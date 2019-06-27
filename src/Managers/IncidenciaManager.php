<?php


namespace App\Managers;


use App\Entity\Incidencia;
use App\Events\IncidenciaEvent;
use App\Services\ImagesService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Security;

class IncidenciaManager
{
    private $entityManager;
    private $repository;
    private $dispatcher;
    private $security;
    private $imagesService;

    public function __construct(EntityManagerInterface $entityManager, EventDispatcherInterface $dispatcher, Security $security, ImagesService $imagesService)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Incidencia::class);
        $this->dispatcher = $dispatcher;
        $this->security = $security;
        $this->imagesService = $imagesService;
    }

    public function newObject(): Incidencia
    {
        $incidencia = new Incidencia();

        return $incidencia;
    }

    public function create($incidencia, $form): Incidencia
    {
        $image = $this->imagesService->uploadImage($form['imagenes']->getData());
        $incidencia->setImagenes($image);

        $user = $this->security->getUser();

        $incidencia->setUser($user);

        $this->entityManager->persist($incidencia);
        $this->entityManager->flush();

        $event = new IncidenciaEvent($incidencia);
        $this->dispatcher->dispatch(IncidenciaEvent::SAVED, $event);

        return $incidencia;
    }

    public function update($incidencia, $form)
    {
        $image = $this->imagesService->uploadImage($form['imagenes']->getData());
        $incidencia->setImagenes($image);

        $this->entityManager->flush();
    }

    public function delete($incidencia)
    {
        $this->entityManager->remove($incidencia);
        $this->entityManager->flush();
    }
}