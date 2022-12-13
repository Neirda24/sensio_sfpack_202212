<?php

namespace App\Command;

use App\Entity\Movie as MovieEntity;
use App\Omdb\ApiConsumer;
use App\ReadModel\Movie;
use App\Repository\GenreRepository;
use App\Repository\MovieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\String\Slugger\SluggerInterface;
use Throwable;
use function array_column;
use function array_map;
use function count;
use function sprintf;

#[AsCommand(
    name: 'app:movies:import:omdb',
    description: 'Add a short description for your command',
)]
class MoviesImportOmdbCommand extends Command
{
    public function __construct(
        private readonly ApiConsumer      $omdbApiConsumer,
        private readonly MovieRepository  $movieRepository,
        private readonly GenreRepository  $genreRepository,
        private readonly SluggerInterface $slugger,
        private readonly ManagerRegistry  $registry,
    ) {
        parent::__construct(null);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('id-or-title', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'Can either be an ID or a title.')
            ->setHelp(<<<EOT
            The <info>%command.name%</info> import movies data from OMDB api to database:
            <info>php %command.full_name% movie1-title movie2-title</info>
            <info>php %command.full_name% movie1-id movie2-id</info>
            <info>php %command.full_name% movie1-id movie2-title</info>
            EOT,
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $idOrTitleList = $input->getArgument('id-or-title');

        $io->info(sprintf('Trying to import %d movies.', count($idOrTitleList)));

        $addedMovies  = [];
        $failedMovies = [];
        foreach ($idOrTitleList as $idOrTitle) {
            try {
                $movie = Movie::fromOmdbApi($this->omdbApiConsumer->getById($idOrTitle), $this->slugger);
            } catch (Throwable) {
                $searchResults = $this->omdbApiConsumer->searchByName($idOrTitle);

                if ([] === $searchResults) {
                    $io->error("No movie found for either ID or title : {$idOrTitle}");
                    $failedMovies[] = $idOrTitle;

                    continue;
                }

                if ($input->isInteractive() === true) {
                    $movie = Movie::fromOmdbApi($this->omdbApiConsumer->getById($io->choice(
                        'Which title do you want to import ?',
                        array_column($searchResults, 'Title', 'imdbID'),
                    )), $this->slugger);
                }
            }

            $movieEntity = new MovieEntity();
            $movieEntity->setTitle($movie->title);
            $movieEntity->setPoster($movie->poster);
            $movieEntity->setReleasedAt($movie->releasedAt);
            $movieEntity->setSlug($movie->slug);
            $movieEntity->setRated($movie->rated);

            foreach ($movie->genres as $genre) {
                $movieEntity->addGenre($this->genreRepository->getOrCreate($genre));
            }

            $this->movieRepository->save($movieEntity);
            $addedMovies[] = $movieEntity;

            $io->success("'{$movieEntity->getTitle()}' as been added !");
        }

        $manager = $this->registry->getManagerForClass(MovieEntity::class);
        $manager->flush();

        if ([] !== $addedMovies) {
            $io->table(
                ['Id in database', 'Title', 'Rated'],
                array_map(
                    static fn(MovieEntity $movieEntity): array => [$movieEntity->getId(), $movieEntity->getTitle(), $movieEntity->getRated()],
                    $addedMovies,
                ),
            );
        }

        if ([] !== $failedMovies) {
            $io->error('The following movies have failed to be inserted :');
            $io->listing($failedMovies);
        }

        return Command::SUCCESS;
    }
}
