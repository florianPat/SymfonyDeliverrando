<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class CustomerLoginType extends AbstractCsrfTokenType
{
    public function __construct()
    {
        parent::__construct('login_customer');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setDefault('data_class', Customer::class);
        $resolver->setDefined(['autofocus', 'value']);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('email', EmailType::class, ['attr' => ['autofocus' => 'autofocus', 'value' => $options['value']]])
            ->add('password', PasswordType::class, ['constraints' => [new Length(['max' => 4096])]])
            ->add('remember_me', CheckboxType::class, ['mapped' => false, 'required' => false])
            ->add('login', SubmitType::class);
    }
}
