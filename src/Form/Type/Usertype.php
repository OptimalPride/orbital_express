<?php

namespace OrbitalExpress\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;


class Usertype extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options){
		global $app;
		$builder
		->add("username", TextType::class, array(
			"constraints" => array(
				new Assert\NotBlank(),
				new Assert\Length(array(
					"min" => 3,
					"max" => 20
					)
				))
			))
		-> add('password', PasswordType::class, array(
			"constraints" => array(
				new Assert\NotBlank(),
				new Assert\Length(array(
					"min" => 5,
					"max" => 15
					)
				))
			))
		-> add('email', EmailType::class)
		-> add('avatar', TextType::class)
		-> setAction($app['url_generator']->generate('register'));
	}
}
