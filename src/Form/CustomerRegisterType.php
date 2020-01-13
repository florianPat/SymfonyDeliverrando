<?php

namespace App\Form;

use App\Entity\Customer;
use App\Security\Constraint\CustomerEmailAvailable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class CustomerRegisterType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setDefault('data_class', Customer::class);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('email', EmailType::class, ['constraints' => [new CustomerEmailAvailable()]])
            ->add('password', PasswordType::class, ['constraints' => [new Length(['max' => 4096])]])
            ->add('register', SubmitType::class);
    }
}
