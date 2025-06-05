<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PDF_MC_Table extends FPDF
{
	var $widths;
	var $aligns;

	function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths=$w;
	}
	function setUTF8($text)
	{
		return iconv( 'UTF-8','cp874//IGNORE',$text);
	}
	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns=$a;
	}

	function Row($data,$line="",$style="",$height=5,$underline=0,$textcolor="")
	{
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb, $this->NbLines($this->widths[$i], $data[$i]));
		$h=$height*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++)
		{
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			
			//Save the current position
			$x=$this->GetX();
			$_x[$i]=$this->GetX();
			$y=$this->GetY();

			if($line=="")
			{
				//Draw the border
				$this->SetDrawColor(0,0,0);
				$this->Line($x, $y,$x,$y+$h);
			}
			else
			{
				if($line[$i]==1)
				{
					//Draw the border
					$this->SetDrawColor(0,0,0);
					$this->Line($x, $y,$x,$y+$h);
				}else if($line[$i]==2)
				{
					//Draw the border
					$this->SetDrawColor(0,0,0);
					$this->Line($x, $y,$x,$y+$h);
					$this->Line($x, $y+$h,$x+$w,$y+$h);
				}
			}
			if($textcolor=="")
			{
				$this->SetTextColor(0,0,0);
			}
			else if(is_array($textcolor))
			{
				if(isset($textcolor[$i]) && !empty($textcolor[$i]))
				{
					$this->SetTextColor($textcolor[$i][0],$textcolor[$i][1],$textcolor[$i][2]);
				}else
				{
					$this->SetTextColor(0,0,0);
				}
			}else{
				$this->SetTextColor($textcolor[0],$textcolor[1],$textcolor[2]);
			}
			if($a!='X')
			{

				if($i+1==count($data))
					$this->Line($x+$w, $y,$x+$w, $y+$h);
			}
			else
				$a="L";


			//Print the text
			if($style!="")
				$this->SetFont('',$style[$i],'');
				
			$this->MultiCell($w, $height, $data[$i], $underline, $a);
			//Put the position to the right of the cell
			$this->SetXY($x+$w, $y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	function CheckPageBreak($h)
	{
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}

	function NbLines($w, $txt)
	{
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r", '', $txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ')
				$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax)
			{
				if($sep==-1)
				{
					if($i==$j)
						$i++;
				}
				else
					$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
				$i++;
		}
		return $nl;
	}
	function SetDash($black=null, $white=null)
    {
        if($black!==null)
            $s=sprintf('[%.3F %.3F] 0 d',$black*$this->k,$white*$this->k);
        else
            $s='[] 0 d';
        $this->_out($s);
    }
}