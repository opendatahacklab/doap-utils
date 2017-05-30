<?php 
/**
 * Convert a list of projects in a gitlab repository (see https://docs.gitlab.com/ee/api/projects.html)
 * to doap files
 *
 * @author Cristiano Longo
 *
 * This file is part of rss-tools.
 *
 * Copyright 2017 Cristiano Longo
 *
 * rss-tools is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * rss-tools is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
include_once('GitlabProjectsParser.php');
include_once('DOAPOntology.php');

$o=new DOAPOntology("http://git.muttelab.org/ontology/");
$p=GitlabProjectsParser::getFromRESTEndpoint("https://git.mittelab.org/api/v4/projects/","https://www.mittelab.org/projects/");
foreach ($p as $entry){
	$o->add($entry);
}

header('Content-type: application/rdf+xml; charset=UTF-8');
/*
 * Impostazioni locali in italiano, utilizzato per la stampa di data e ora
 * (il server deve avere il locale italiano installato
 */
setlocale(LC_TIME, 'it_IT');
echo $o->getXML()->saveXML();
?>