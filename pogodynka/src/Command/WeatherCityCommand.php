<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:city',
    description: 'Displays measurements for location by country and city',
)]
class WeatherCityCommand extends Command
{
    public function __construct(
        private readonly WeatherUtil $weatherUtil,
        private readonly LocationRepository $locationRepository,
        string $name = null,
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('country', InputArgument::REQUIRED, 'Country code')
            ->addArgument('city', InputArgument::REQUIRED, 'City name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $country = $input->getArgument('country');
        $city = $input->getArgument('city');
        $measurements = $this->weatherUtil->getWeatherForCountryAndCity($country, $city);
        $io->writeln(sprintf('Location: %s', $city));
        foreach ($measurements as $measurement) {
            $io->writeln(sprintf(
                "\t%s: %s",
                $measurement->getDate()->format('Y-m-d'),
                $measurement->getCalsius()
            ));
        }
        return Command::SUCCESS;
    }
}
