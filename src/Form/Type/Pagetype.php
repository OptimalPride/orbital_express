<?php

namespace OrbitalExpress\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

class Pagetype extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder
		->add("story", TextareaType::class, array(
			"constraints" => array(
				new Assert\NotBlank(),
				new Assert\Length(array(
					"min" => 3,
					"max" => 2000
					)
				))
			));
//		-> add('choice', textType::class)
//    -> add('crew', textType::class)
//    -> add('lien', textType::class)

//		-> add('choice', textType::class)
//    -> add('crew', textType::class)
//    -> add('lien', textType::class)

//		-> add('choice', TextType::class)
//    -> add('crew', textType::class)
//    -> add('lien', textType::class);

	}
}
