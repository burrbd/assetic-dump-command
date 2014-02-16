<?php

namespace Burrbd;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Assetic\Factory\LazyAssetManager;
use Assetic\Extension\Twig\TwigResource;
use Assetic\Extension\Twig\TwigFormulaLoader;
use Assetic\AssetWriter;


class DumpAssetsCommand extends Command
{
    protected function configure()
    {
        $this->setName('assetic:dump')
            ->setDescription('Dump assetic assets to your web root')
            ->addArgument('templates', InputArgument::REQUIRED, 'Single or space separated list of twig templates')
            ->addArgument('target', InputArgument::REQUIRED, 'Target directory (ie, your web root)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $templates = explode(' ', $input->getArgument('templates'));
        $targetDir = $input->getArgument('target');
        $am = new LazyAssetManager($this->getHelper('factory')->getFactory());
        $twig = $this->getHelper('twig')->getEnvironment();
        $am->setLoader('twig', new TwigFormulaLoader($twig));
        foreach ($templates as $template) {
            $resource = new TwigResource($twig->getLoader(), $template);
            $am->addResource($resource, 'twig');
        }
        $writer = new AssetWriter($targetDir);
        $writer->writeManagerAssets($am);
        if (count($am->getNames()) > 0) {
            $output->writeln('Assets written:');
            foreach ($am->getNames() as $name) {
                $output->writeln($targetDir . $am->get($name)->getTargetPath());
            }
        } else {
            $output->writeln('No templates found');
        }
    }
}
