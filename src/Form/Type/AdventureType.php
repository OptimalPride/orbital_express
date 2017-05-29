<?php

namespace OrbitalExpress\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
		->add('submit', SubmitType::class, [
	            'label' => 'Send',
	        ]);
	}
}

?>
