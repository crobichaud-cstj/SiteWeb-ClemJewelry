<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;

class ModificationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder


            ->add('lastName', TextType::class, [
                'required' => true, 
                'label' => 'Nom', 
                'attr' => []])

            ->add('firstName', TextType::class, [
                'required' => true, 
                'label' => 'Prénom', 
                'attr' => []])

            

            ->add('address', TextType::class, [
             'required' => true,
             'label' => 'Adresse',
             'attr' => []])

            ->add('city', TextType::class, [
            'required' => true,
            'label' => 'Ville',
            'attr' => []])

            ->add('zipCode', TextType::class, [
            'required' => true,
            'label' => 'Code Postal',
            'attr' => []])

            

            ->add('province', ChoiceType::class, [
            'required' => true,
            'label' => 'Province',
            'choices' => [
                'AB' => 'AB',
                'BC' => 'BC',
                'PE' => 'PE',
                'MB' => 'MB',
                'NB' => 'NB',
                'NS' => 'NS',
                'ON' => 'ON',
                'QC' => 'QC',
                'SK' => 'SK',
                'NL' => 'NL',
                'NU' => 'NU',
                'NT' => 'NT',
                'YT' => 'YT'

            ]])

            ->add('phone', TextType::class, [
             'required' => true,
             'label' => 'Téléphone',
             'attr' => []])

            ->add('create', SubmitType::class, [
                'label' => "Modifier votre compte",
                'row_attr' => ['class' => 'form-button'],
                'attr' => ['class' => 'btnCreate btn-primary']
            ]);
            

            $builder->get('phone')->addModelTransformer(new CallbackTransformer(
                function($phoneFromDatabase) {
                    $newPhone = substr_replace($phoneFromDatabase, "-", 3, 0);
                    return substr_replace($newPhone, "-", 7, 0);
                }, 
                function ($phoneFromView) {
                    return str_replace("-", "", $phoneFromView);
                }
        ));

        $builder->get('zipCode')->addModelTransformer(new CallbackTransformer(
            function($zipCodeFromDatabase) {
                $newZipCode = substr_replace(strtoupper($zipCodeFromDatabase), " ", 3, 0);
                return substr_replace(strtoupper($newZipCode), " ", 3, 0);
            }, 
            function ($zipCodeFromView) {
                return str_replace(" ", "", strtoupper($zipCodeFromView));
            }
    ));

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
