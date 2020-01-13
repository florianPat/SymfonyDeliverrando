<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Csrf\Type\FormTypeCsrfExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Csrf\CsrfTokenManager;

abstract class AbstractCsrfTokenType extends AbstractType
{
    /**
     * @var CsrfTokenManager
     */
    protected $tokenManager;
    /**
     * @var FormTypeCsrfExtension
     */
    protected $csrfType;
    /**
     * @var string
     */
    protected $tokenId;

    public function __construct(string $tokenId)
    {
        $this->tokenManager = new CsrfTokenManager();
        //NOTE: STP: every transaction also sends a token in a hidden field, to share
        // a secret that the attacker does not have access to
        $this->csrfType = new FormTypeCsrfExtension($this->tokenManager);
        $this->tokenId = $tokenId;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'scrf_protection' => true,
            'csrf_field_name' => '_csrf_token',
            'csrf_token_id' => $this->tokenId,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        $this->csrfType->buildForm($builder, []);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        parent::buildView($view, $form, $options);
        $this->csrfType->buildView($view, $form, $options);
    }

    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        parent::finishView($view, $form, $options);
        $this->csrfType->finishView($view, $form, $options);
    }
}