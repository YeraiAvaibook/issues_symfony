<?php


namespace App\Managers;


use App\Entity\Incidencia;
use App\Events\IncidenciaEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class IncidenciaManager
{
    private $entityManager;
    private $repository;
    private $dispatcher;

    public function __construct(EntityManagerInterface $entityManager, EventDispatcherInterface $dispatcher)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Incidencia::class);
        $this->dispatcher = $dispatcher;
    }

    public function newObject(): Incidencia
    {
        $incidencia = new Incidencia();

        return $incidencia;
    }

    public function create($incidencia, $form): Incidencia
    {
        $incidencia = $this->saveImage($incidencia, $form);

        $this->entityManager->persist($incidencia);
        $this->entityManager->flush();

        $event = new IncidenciaEvent($incidencia);
        $this->dispatcher->dispatch(IncidenciaEvent::SAVED, $event);

        return $incidencia;
    }

    public function update($incidencia, $form)
    {
        $incidencia = $this->saveImage($incidencia, $form);

        $this->entityManager->flush();
    }

    public function delete($incidencia)
    {
        $this->entityManager->remove($incidencia);
        $this->entityManager->flush();
    }

    private function saveImage($incidencia, $form): Incidencia
    {
        $file = $form['imagenes']->getData();

        if(!empty($file)){
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move('uploads', $fileName);

            $incidencia->setImagenes($fileName);
        }

        return $incidencia;
    }
}