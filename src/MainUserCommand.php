<?php
/**
 * Created by PhpStorm.
 * User: pymerseme
 * Date: 18.10.18
 * Time: 12:55
 */

namespace App;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class MainUserCommand extends Command
{
    private const ROOT = __DIR__ . '/../';
    private const NAMESPACE = __NAMESPACE__;

    protected function configure()
    {
        $this
            ->setName('show')
            ->setDescription('Show project stat information.')
            ->setHelp('This command show you stat information in directories of currently project.')
            ->addArgument(
                'dir',
                InputArgument::OPTIONAL,
                'Directory for search. Default value is "src" directory in currently directory of project.'
            )
        ;
    }

    private function getClassType(\ReflectionClass $class): string
    {
        if ($class->isAbstract()) {
            return 'Abstract';
        } elseif ($class->isFinal()) {
            return 'Final';
        } else {
            return 'Sample';
        }
    }

    private function counter(array $input): array
    {
        $public = 0;
        $protected = 0;
        $private = 0;
        $noModifiers = 0;

        foreach ($input as $value) {
            if ($value->isPublic()) {
                $public++;
            } elseif ($value->isProtected()) {
                $protected++;
            } elseif ($value->isPrivate()) {
                $private++;
            } else {
                $noModifiers++;
            }
        }

        return [
            'public' => $public,
            'protected' => $protected,
            'private' => $private,
            'no_modifiers' => $noModifiers,
        ];
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $dir = $input->getArgument('dir') ?? 'src/';
        $finder = new Finder();
        $finder->files()->in(self::ROOT . $dir)->name('/^[A-Z].+\.php$/');

        foreach ($finder as $file) {
            $fileName = $file->getRelativePathname();
            $className = \rtrim($fileName, '.php');
            $fullClassName = self::NAMESPACE . '\\' . $className;

            if ($fullClassName === 'App\MainUserCommand') {
                continue;
            }

            $class = new \ReflectionClass($fullClassName);

            $classType = $this->getClassType($class);

            $properties = $class->getProperties();
            $countProperties = $this->counter($properties);

            $methods = $class->getMethods();
            $countMethods = $this->counter($methods);

            $output->writeln($classType . ' class: ' . $className);

            $output->writeln('Properties:');
            $output->writeln("    public: {$countProperties['public']}");
            $output->writeln("    protected: {$countProperties['protected']}");
            $output->writeln("    private: {$countProperties['private']}");
            $output->writeln('');

            $output->writeln('Methods:');
            $output->writeln("    public: {$countMethods['public']}");
            $output->writeln("    protected: {$countMethods['protected']}");
            $output->writeln("    private: {$countMethods['private']}");
            $output->writeln('');
        }
    }
}
