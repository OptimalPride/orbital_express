<?php

namespace OrbitalExpress\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType; //Input type text
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; //Select
use Symfony\Component\Form\Extension\Core\Type\IntegerType; // input type number
use Symfony\Component\Form\Extension\Core\Type\TextareaType; // input type number

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;


class AdventureType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder
		->add("name", TextType::class, array(
			"constraints" => array(
				new Assert\NotBlank(),
				new Assert\Length(array(
					"min" => 3,
					"max" => 20
				))
			)
		))
		-> add('description', TextareaType::class, Array(
			"constraints" => array(
				new Assert\NotBlank(),
				new Assert\Length(array(
					"min" => 5,
					"max" => 200
				)
			))
		))
		-> add('pitch', TextareaType::class, Array(
			"constraints" => array(
				new Assert\NotBlank(),
				new Assert\Length(array(
					"min" => 3,
					"max" => 2000
				)
			))
		))
	}

	public function getName(){
		return "commentaire";
	}
}

?>
