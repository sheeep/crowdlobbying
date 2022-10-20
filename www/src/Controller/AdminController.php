<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Campaign;
use App\Utils\WriterInterface;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class AdminController extends EasyAdminController
{
    private WriterInterface $writer;
    private EntityManagerInterface $entityManager;

    public function __construct(WriterInterface $writer, EntityManagerInterface $entityManager)
    {
        $this->writer = $writer;
        $this->entityManager = $entityManager;
    }

    public function exportAction(): Response
    {
        $redirectToList = $this->redirectToRoute('easyadmin', [
            'action' => 'list',
            'entity' => $this->request->query->get('entity'),
        ]);

        $id = $this->request->query->get('id');

        if (null === $id) {
            return $redirectToList;
        }

        /** @var Campaign|null $campaign */
        $campaign = $this->entityManager->find(Campaign::class, $id);

        if (null === $campaign) {
            return $redirectToList;
        }

        $file = $this->writer->write($campaign);

        if (null === $file) {
            return $redirectToList;
        }

        return $this->file($file, basename($file), ResponseHeaderBag::DISPOSITION_INLINE);
    }
}
