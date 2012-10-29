<?php

#
# Template (Version 1.5a)
#
# Klasse zum Parsen von Templates
#
# Autor:            Patrick Canterino <patrick@patshaping.de>
# Letzte Aenderung: 5.6.2005
#

class Template
{
 var $file;
 var $template;

 # get_template()
 #
 # Kompletten Vorlagentext zurueckgeben
 #
 # Parameter: -keine-
 #
 # Rueckgabe: Kompletter Vorlagentext (String)

 function get_template()
 {
  return $this->template;
 }

 # set_template()
 #
 # Kompletten Vorlagentext aendern
 #
 # Parameter: Vorlagentext
 #
 # Rueckgabe: -nichts- (Template-Objekt wird modifiziert)

 function set_template($text)
 {
  $this->template = $text;
 }

 # add_text()
 #
 # Vorlagentext ans Template-Objekt anhaengen
 #
 # Parameter: Vorlagentext
 #
 # Rueckgabe: -nichts- (Template-Objekt wird modifiziert)

 function add_text($text)
 {
  $this->set_template($this->get_template().$text);
 }

 # read_file()
 #
 # Einlesen einer Vorlagendatei und {INCLUDE}-Anweisungen ggf. verarbeiten
 # (Text wird an bereits vorhandenen Text angehaengt)
 #
 # Parameter: 1. Datei zum Einlesen
 #            2. Status-Code (Boolean):
 #               true  => {INCLUDE}-Anweisungen nicht verarbeiten
 #               false => {INCLUDE}-Anweisungen verarbeiten (Standard)
 #
 # Rueckgabe: -nichts- (Template-Objekt wird modifiziert)

 function read_file($file,$not_include=0)
 {
  $this->file = $file;

  if(filesize($file) > 0)
  {
   $fp = fopen($file,'r');
   if(!$fp) die;
   $content = fread($fp,filesize($file));
   fclose($fp);
  }
  else $content = '';

  $this->add_text($content);
  if(!$not_include) $this->parse_includes();
 }

 # fillin()
 #
 # Variablen durch Text ersetzen
 #
 # Parameter: 1. Variable zum Ersetzen
 #            2. Text, durch den die Variable ersetzt werden soll
 #
 # Rueckgabe: -nichts- (Template-Objekt wird modifiziert)

 function fillin($var,$text)
 {
  $template = $this->get_template();
  $template = str_replace('{'.$var.'}',$text,$template);

  $this->set_template($template);
 }

 # fillin_array()
 #
 # Variable durch Array ersetzen
 #
 # Parameter: 1. Variable zum Ersetzen
 #            2. Array, durch das die Variable ersetzt werden soll
 #            3. Zeichenkette, mit der das Array verbunden werden soll
 #               (Standard: '')
 #
 # Rueckgabe: -nichts- (Template-Objekt wird modifiziert)

 function fillin_array($var,$array,$glue='')
 {
  $this->fillin($var,join($glue,$array));
 }

 # to_file()
 #
 # Template in Datei schreiben
 #
 # Parameter: Datei-Handle
 #
 # Rueckgabe: Status-Code (Boolean)

 function to_file($handle)
 {
  return @fwrite($handle,$this->get_template());
 }

 # parse_if_block()
 #
 # IF-Bloecke verarbeiten
 #
 # Parameter: 1. Name des IF-Blocks (das, was nach dem IF steht)
 #            2. Status-Code (true  => Inhalt anzeigen
 #                            false => Inhalt nicht anzeigen
 #            3. true  => Verneinten Block nicht parsen
 #               false => Verneinten Block parsen (Standard)
 #
 # Rueckgabe: -nichts- (Template-Objekt wird modifiziert)

 function parse_if_block($name,$state,$no_negate=0)
 {
  $template = $this->get_template();

  $count = 0;

  while(strpos($template,'{IF '.$name.'}') !== false)
  {
   # Das alles hier ist nicht wirklich elegant geloest...
   # ... aber solange es funktioniert... ;-)

   $count++;

   $start    = strpos($template,'{IF '.$name.'}');
   $tpl_tmp  = substr($template,$start);
   $splitted = explode('{ENDIF}',$tpl_tmp);

   $block = ''; # Kompletter bedingter Block
   $ifs   = 0;  # IF-Zaehler (wird fuer jedes IF erhoeht und fuer jedes ENDIF erniedrigt)

   # {IF}

   for($x=0;$x<count($splitted);$x++)
   {
    if($x == count($splitted)-1) die('Nesting error found while parsing IF block "'.$name.'" nr. '.$count.' in template file "'.$this->file.'"');

    $ifs += substr_count($splitted[$x],'{IF '); # Zum Zaehler jedes Vorkommen von IF hinzuzaehlen
    $ifs--;                                     # Zaehler um 1 erniedrigen
    $block .= $splitted[$x].'{ENDIF}';          # Daten zum Block hinzufuegen

    if($ifs == 0)
    {
     # Zaehler wieder 0, also haben wir das Ende des IF-Blocks gefunden :-))

     break;
    }
   }

   $if_block = substr($block,strlen($name)+5,-7); # Alles zwischen {IF} und {ENDIF}

   # {ELSE}

   $else_block = ''; # Alles ab {ELSE}
   $ifs        = 0;  # IF-Zaehler

   $splitted = explode('{ELSE}',$if_block);

   for($x=0;$x<count($splitted);$x++)
   {
    $ifs += substr_count($splitted[$x],'{IF ');    # Zum Zaehler jedes Vorkommen von IF hinzuzaehlen
    $ifs -= substr_count($splitted[$x],'{ENDIF}'); # Vom Zaehler jedes Vorkommen von ENDIF abziehen

    if($ifs == 0)
    {
     # Zaehler 0, also haben wir das Ende des IF-Abschnitts gefunden

     # Aus dem Rest den ELSE-Block zusammenbauen

     for($y=$x+1;$y<count($splitted);$y++)
     {
      $else_block .= '{ELSE}'.$splitted[$y];
     }

     if($else_block)
     {
      $if_block   = substr($if_block,0,strlen($if_block)-strlen($else_block));
      $else_block = substr($else_block,6);
     }

     break;
    }
   }

   # Block durch die jeweiligen Daten ersetzen

   $replacement = ($state) ? $if_block : $else_block;

   $template = str_replace($block,$replacement,$template);
  }

  $this->set_template($template);

  # Evtl. verneinte Form parsen

  if(!$no_negate)
  {
   $this->parse_if_block('!'.$name,!$state,1);
  }
 }

 # parse_condtag()
 #
 # Bedingungstags in einem Vorlagentext verarbeiten
 #
 # Parameter: 1. Tagname
 #            2. Status-Code (true  => Tag-Inhalt anzeigen
 #                            false => Tag-Inhalt nicht anzeigen
 #
 # Rueckgabe: -nichts- (Template-Objekt wird modifiziert)

 function parse_condtag($condtag,$state)
 {
  $template = $this->get_template();

  while(strpos($template,'<'.$condtag.'>') !== false)
  {
   $start = strpos($template,'<'.$condtag.'>');                                        # Beginn des Blocks
   $end   = strpos($template,'</'.$condtag.'>')+strlen($condtag)+3;                    # Ende des Blocks

   $extract = substr($template,$start,$end-$start);                                    # Kompletten Bedingungsblock extrahieren...

   $replacement = ($state) ? substr($extract,strlen($condtag)+2,0-strlen($condtag)-3) : '';

   $template = str_replace($extract,$replacement,$template);                           # Block durch neue Daten ersetzen
  }
  $this->set_template($template);
 }

 # parse_includes()
 #
 # {INCLUDE}-Anweisungen verarbeiten
 #
 # Parameter: -nichts-
 #
 # Rueckgabe: -nichts- (Template-Objekt wird modifiziert)

 function parse_includes()
 {
  $template = $this->get_template();

  preg_match_all('/\{INCLUDE (\S+?)\}/',$template,$matches,PREG_SET_ORDER);

  foreach($matches as $match)
  {
   list($directive,$file) = $match;

   if(is_file($file))
   {
    $inc = new Template;
    $inc->read_file($file);

    $template = str_replace($directive,$inc->get_template(),$template);
   }
  }

  $this->set_template($template);
 }

 # ==================
 #  Alias-Funktionen
 # ==================

 function addtext($text)
 {
  $this->add_text($text);
 }

 function as_string()
 {
  return $this->get_template();
 }

 function condtag($condtag,$state)
 {
  $this->parse_condtag($condtag,$state);
 }

 function readin($tfile)
 {
  $this->read_file($tfile);
 }
}

#
### Ende ###

?>