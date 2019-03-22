<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OracleCommand extends Command {
	protected static $defaultName = 'oracle:export';

	protected function configure() {
		// ...
		$this
			->setDescription('Exécuter un export Oracle')
			->setHelp("Cette commande permet de lancer une tâche d'export sur un système Oracle");
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		// ...
		$header = $output->section();
		$content = $output->section();
		$header->writeln([
			"Lancement d'une procedure d'import Oracle",
			'============================',
			'',
		]);

		$content->writeln($this->launchTask());

		$content->writeln([
			'============================',
			"Fin de la procedure d'import",
			'============================',
			'',
		]);
	}

	private function launchTask() {
		$user = 'axel';
		$pwd = 'ALEX';
		$tnsname = strtoupper('TeamNet');

		echo "impdp $user/$pwd@$tnsname -par exp$tnsname.par";
	}
}