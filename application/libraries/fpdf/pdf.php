<?php
require('fpdf.php');

class PDF extends FPDF
{
var $col = 0;
protected $y0;
	
function SetCol($col)
{
    // Positionnement sur une colonne
    $this->col = $col;
    $x = 10+$col*85;
    $this->SetLeftMargin($x);
    $this->SetX($x);
}

function AcceptPageBreak()
{
    // Méthode autorisant ou non le saut de page automatique
    if($this->col<2)
    {
        // Passage à la colonne suivante
        $this->SetCol($this->col+1);
        // Ordonnée en haut
        $this->SetY($this->y0);
        // On reste sur la page
        return false;
    }
    else
    {
        // Retour en première colonne
        $this->SetCol(0);
        // Saut de page
        return true;
    }
}


function Header()
{
    // En-tête
    $this->SetFont('Arial','B',17);
    $this->Cell(0,10,utf8_decode($this->title),1,2,'C');
    $this->Ln(10);
    // Sauvegarde de l'ordonnée
    $this->y0 = $this->GetY();
}

function Rayon($rayon)
{
    $this->SetFont('Arial','B',14);
    $this->Cell(0,10,utf8_decode($rayon),0,1,'L');
}

function ListeAchats($achats, $id_rayon) {
	$this->SetFont('Arial','',12);
	foreach($achats as $achat) {
		if($achat['rayon_id'] == $id_rayon) {
			$this->Write(0,utf8_decode('- '.$achat['produit_nom']));
			if(($achat['achat_quantite_totale'])!=0) {
				$this->Write(0,utf8_decode(' : '.$achat['achat_quantite_totale'].' '.$achat['unite_nom']));
			}
			$this->Ln(5);
		}
	}
}
}

?>
