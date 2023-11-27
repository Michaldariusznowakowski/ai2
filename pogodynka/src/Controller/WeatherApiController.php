<?php

namespace App\Controller;

use App\Entity\Measurement;
use App\Service\WeatherUtil;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Xml;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api')]
    public function index(
        WeatherUtil $util,
        #[MapQueryParameter('country')] string $country,
        #[MapQueryParameter('city')] string $city,
        #[MapQueryParameter('format')] string $format = 'json',
        #[MapQueryParameter('twig')] bool $twig = false,
    ): Response {
        $measurements = $util->getWeatherForCountryAndCity($country, $city);
        if ($format === 'csv') {
            if ($twig) {
                return $this->render('weather_api/index.csv.twig', [
                    'city' => $city,
                    'country' => $country,
                    'measurements' => $measurements,
                ]);
            }
            $csv = "city,country,date,celsius\n";
            foreach ($measurements as $measurement) {
                $csv .= sprintf(
                    '%s,%s,%s,%s',
                    $city,
                    $country,
                    $measurement->getDate()->format('Y-m-d'),
                    $measurement->getCalsius(),
                    $measurement->getFahrenheit(),
                ) . "\n";
            }
            return new Response($csv, 200, [
                'Content-Type' => 'text/csv',
            ]);
        }
        $formattedMeasurements = array_map(function (Measurement $measurement) {
            return [
                'date' => $measurement->getDate()->format('Y-m-d'),
                'celsius' => $measurement->getCalsius(),
                'fahrenheit' => $measurement->getFahrenheit(),
            ];
        }, $measurements);
        if ($twig) {
            return $this->render('weather_api/index.json.twig', [
                'city' => $city,
                'country' => $country,
                'measurements' => $formattedMeasurements,
            ]);
        }
        return $this->json([
            'city' => $city,
            'country' => $country,
            'measurements' => $formattedMeasurements,
        ]);
    }
}
