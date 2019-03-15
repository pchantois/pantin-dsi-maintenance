<?php

namespace App\Controller\Logiciel\Teamnet\Axel;

use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class QuotientFamillialeController extends Controller {
	/**
	 * @Route("/logiciel/teamnet/axel/quotient-familliale", name="logiciel_teamnet_axel_quotient_familliale")
	 */
	public function index() {

		//$reader = ReaderFactory::create(Type::XLSX); // for XLSX files
		//$reader = ReaderFactory::create(Type::CSV); // for CSV files
		$reader = ReaderFactory::create(Type::ODS); // for ODS files

		$reader->open('files/impots.ods');
		$datas = array();

		foreach ($reader->getSheetIterator() as $sheet) {
			$feuille = $sheet->getName();
			$datas[$feuille] = array();
			//$this->qf_generate($feuille, $sheet);
			foreach ($sheet->getRowIterator() as $row) {
				// do stuff with the row
				$datas[$feuille][] = array($row[0], explode(" ", $row[1])[0], $row[2]);
				//$datas[] = $row;
			}
		}
		//var_dump($datas);

		$reader->close();

		return $this->render('logiciel/teamnet/axel/quotient_familliale/index.html.twig', [
			'controller_name' => 'QuotientFamillialeController',
			'items' => $datas,
		]);
	}

	public function qf_generate($sheetName, $sheet) {

		$query_start = 'insert into famcommentaires (ordre, GROUPEFAMILLE, LIBELLE, texte, utilisateur, datecreation, datemaj) values (';
		$query_end = ");\n";
		$datecreation = $datemaj = '14/06/2018';
		switch ($sheetName) {
		case 'qf_moins':
			$ordre = 10;
			$LIBELLE = 'RENTREE 2018';
			$texte = 'QF 2018 + Bordereau de situationTP';
			$utilisateur = 'AXEL';
			break;
		case 'qf_plus':
			$ordre = 11;
			$LIBELLE = 'RENTREE 2018';
			$texte = "PAS D''INSCRIPTION";
			$utilisateur = 'AXEL';
			break;

		default:
			return 0;
			break;
		}
		$handle = fopen('/home/pchantois/Sites/maintenance/public/' . $sheetName . '.sql', 'w+');
		$handle2 = fopen('/home/pchantois/Sites/maintenance/public/' . $sheetName . '_delete.sql', 'w+');
		foreach ($sheet->getRowIterator() as $row) {
			$GROUPEFAMILLE = explode(" ", $row[1])[0];
			if (empty($GROUPEFAMILLE)) {
				continue;
			}
			// do stuff with the row
			$query = $query_start;
			$query .= $ordre . ",";
			$query .= $GROUPEFAMILLE . ",";
			$query .= "'" . addslashes($LIBELLE) . "',";
			$query .= "'" . $texte . "',";
			$query .= "'" . addslashes($utilisateur) . "',";
			$query .= "'" . addslashes($datecreation) . "',";
			$query .= "'" . addslashes($datemaj) . "'";
			$query .= $query_end;
			fwrite($handle, $query);
			$query = "delete from famcommentaires where LIBELLE='RENTREE 2018' and groupefamille = $GROUPEFAMILLE;\n";
			//$query = "$GROUPEFAMILLE,\n";
			fwrite($handle2, $query);
			//$datas[] = $row;
		}
		fclose($handle);
		fclose($handle2);
	}

	public function qf_injection_test() {}
}
