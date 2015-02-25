<?php

require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Bucyou\Product;

$product = new Product();
$product->itemSold = 20;
$product->commission = 7.5;
$product->price = 19.99;

AnnotationRegistry::registerFile(__DIR__.'/vendor/symfony/serializer/Symfony/Component/Serializer/Annotation/Groups.php');
$classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
$normalizer = new PropertyNormalizer($classMetadataFactory);
$serializer = new Serializer([$normalizer]);

var_dump($serializer->normalize($product, null, ['groups' => ['admins']]));
/*
array(3) {
  'itemSold' =>
  int(20)
  'commission' =>
  double(7.5)
  'price' =>
  double(19.99)
}
 */
var_dump($serializer->normalize($product, null, ['groups' => ['affiliates']]));
/*
array(2) {
  'commission' =>
  double(7.5)
  'price' =>
  double(19.99)
}
*/
var_dump($serializer->normalize($product, null, ['groups' => ['users']]));
/*
array(1) {
  'price' =>
  double(19.99)
}
*/
var_dump($serializer->normalize($product, null, ['groups' => ['affiliates', 'users']]));
/*
array(2) {
  'commission' =>
  double(7.5)
  'price' =>
  double(19.99)
}
*/
