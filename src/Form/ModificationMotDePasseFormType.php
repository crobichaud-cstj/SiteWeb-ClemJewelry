<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ModificationMotDePasseFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder



        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => "Les mots de passe doivent être identiques",
            'constraints' => [new Assert\Length(min: 6, minMessage: "Le mot de passe doit contenir au moins {{ limit }} caractères")],
            'options' => ['attr' => ['class' => 'password-field']],
            'required' => true,
            'first_options' => ['label' => "Nouveau mot de passe"],
            'second_options' => ['label' => "Confirmation du nouveau mot de passe"]
        ])

        ->add('oldPassword', PasswordType::class,[
            'label' => "Mot de passe actuel",
            'invalid_message' => "Le mot de passe est mauvais",
            'constraints' => [new Assert\Length(min: 6, minMessage: "Le mot de passe doit contenir au moins {{ limit }} caractères")],
            'required' => true,
            
        ])

        ->add('create', SubmitType::class, [
            'label' => "Modification du mot de passe",
            'row_attr' => ['class' => 'form-button'],
            'attr' => ['class' => 'btnCreate btn-primary']
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
