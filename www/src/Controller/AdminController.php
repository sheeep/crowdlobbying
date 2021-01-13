<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Campaign;
use App\Utils\WriterInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class AdminController extends EasyAdminController
{
    private WriterInterface $writer;

    public function __construct(WriterInterface $writer)
    {
        $this->writer = $writer;
    }

    public function exportAction(): Response
    {
        $id = $this->request->query->get('id');

        if (null === $id) {
            return $this->redirectToRoute('easyadmin', [
                'action' => 'list',
                'entity' => $this->request->query->get('entity'),
            ]);
        }

        $campaign = $entity = $this->em->getRepository(Campaign::class)->find($id);

        if (null === $campaign) {
            return $this->redirectToRoute('easyadmin', [
                'action' => 'list',
                'entity' => $this->request->query->get('entity'),
            ]);
        }

        $file = $this->writer->write($campaign);

        return $this->file($file, basename($file), ResponseHeaderBag::DISPOSITION_INLINE);
    }
}
