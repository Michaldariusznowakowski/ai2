<?php

namespace App\Controller;

use App\Entity\Location;
use App\Service\WeatherUtil;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WeatherController extends AbstractController
{
    #[Route('/weather/{country}/{city}', name: 'app_weather')]
    public function city(
        #[MapEntity(mapping: ['country' => 'country', 'city' => 'city'])]
        Location $location,
        WeatherUtil $util,
    ): Response {
        $measurements = $util->getWeatherForLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }
    #[Route('/', name: 'app_weather_welcome')]
    public function welcome(): Response
    {
        return $this->render('welcome.html.twig');
    }
    #[Route('/weather', name: 'app_weather_index')]
    public function index(WeatherUtil $util): Response
    {
        return $this->render('weather/index.html.twig', [
            'locations' =>  $util->getLocations(),
        ]);
    }
}
