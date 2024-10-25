<?php

use Doctrine\ORM\Mapping\ClassMetadataInfo;

$metadata->setInheritanceType(ClassMetadataInfo::INHERITANCE_TYPE_NONE);
$metadata->customRepositoryClassName = 'AppBundle\Repository\ClienteRepository';
$metadata->setChangeTrackingPolicy(ClassMetadataInfo::CHANGETRACKING_DEFERRED_IMPLICIT);
$metadata->mapField(array(
   'fieldName' => 'id',
   'type' => 'integer',
   'id' => true,
   'columnName' => 'id',
  ));
$metadata->mapField(array(
   'columnName' => 'Nombre',
   'fieldName' => 'nombre',
   'type' => 'string',
   'length' => '50',
  ));
$metadata->mapField(array(
   'columnName' => 'primer_apellido',
   'fieldName' => 'primerApellido',
   'type' => 'string',
   'length' => '50',
  ));
$metadata->mapField(array(
   'columnName' => 'segundo_apellido',
   'fieldName' => 'segundoApellido',
   'type' => 'string',
   'length' => '50',
  ));
$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_AUTO);