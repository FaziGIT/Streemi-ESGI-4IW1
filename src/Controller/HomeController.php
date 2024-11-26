<?php

namespace App\Controller;

use App\Repository\MediaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(MediaRepository $mediaRepository): Response
    {
        $medias = $mediaRepository->findRandomMediaOptimized(9);

        return $this->render('other/index.html.twig', [
            'medias' => $medias,
        ]);
    }
}
