<?php

namespace App\Controller\Global;

use App\Repository\MediaRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListController extends AbstractController
{
    #[Route('/lists', name: 'app_lists')]
    public function index(MediaRepository $mediaRepository, PlaylistRepository $playlistRepository): Response
    {
        $medias = $mediaRepository->findAll();
        $allPlaylists = $playlistRepository->findAll();

        return $this->render('other/lists.html.twig', [
            'medias' => $medias,
            'allPlaylists' => $allPlaylists,
        ]);
    }
}
